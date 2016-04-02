<?php
namespace KeineWaste\Services;

use Doctrine\Bundle\DoctrineCacheBundle\Tests\Functional\Fixtures\Memcached;
use Facebook\Exceptions\FacebookAuthenticationException;
use Facebook\Facebook;
use KeineWaste\Dto\Dto;
use KeineWaste\Dto\User as DtoUser;
use KeineWaste\Dto\User;
use KeineWaste\Services\Repository\UserRepository;
use Pseudo\Exception;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserService
{

    use LoggerAwareTrait;
    use CacheableTrait;

    const CACHE_TTL = 60;

    /**
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * @var Facebook
     */
    protected $fbClient;

    /**
     * UserService constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(
        UserRepository $repository,
        Facebook $fbClient
    ) {
        $this->repository = $repository;
        $this->fbClient   = $fbClient;
    }

    public function getUserById($id)
    {
        return $this->getUser(['id' => $id]);
    }

    public function getUserByUsername($username)
    {
        return $this->getUser(['username' => $username]);
    }

    public function getUserByMail($email)
    {
        return $this->getUser(['email' => $email]);

    }

    public function getUserByToken($token)
    {
        $facebookUser = $this->getFacebookUserByToken($token);

        if (null === $facebookUser) {
            throw new AccessDeniedHttpException("Facebook token is invalid");
        }

        $registered = $this->getUser(['facebookId' => $facebookUser->getId()]);

        if (null !== $registered) {
            return $registered;
        }

        /**
         * Register a new user with these information
         */
        $newUser = new User(
            $facebookUser->getId(),
            $facebookUser->getEmail(),
            $facebookUser->getName()
        );
        $newUser->setToken($token);

        $this->repository->save($newUser);
        $this->populateFacebookData($newUser);

        return $newUser;
    }

    /**
     * @param array $array
     *
     * @returns DtoUser
     */
    protected function getUser(array $array)
    {
        $user = $this->repository->getUser($array);
        if ($user) {
            $this->populateFacebookData($user);
        }
        return $user;
    }

    /**
     *
     * @returns DtoUser[]
     */
    public function getUsers()
    {
        $users = $this->repository->getUsers();
        array_walk($users, [$this, 'populateFacebookData']);
        return $users;
    }

    /**
     * @param DtoUser $user
     *
     * @return DtoUser
     */
    public function populateFacebookData(DtoUser &$user)
    {
        try {
            $facebookUser = $this->getFacebookData($user);
            $user->setEmail($facebookUser->getEmail());
            $user->setName($facebookUser->getName());
            $user->setProfilePicture($facebookUser->getPicture()->getUrl());
            $this->repository->save($user);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getFacebookData(DtoUser $user)
    {

        $ck = 'fb_data' . md5($user->getId());

        $fbUser = $this->memcached->get($ck);

        if ($this->memcached->getResultCode() === Memcached::RES_NOTFOUND) {
            $fbUser = $this->fbClient->get('me?fields=id,email,name,picture', $user->getToken())->getGraphUser();
            $this->memcached->set($ck, $fbUser, static::CACHE_TTL);
        }

        return $fbUser;
    }

    protected function getFacebookUserByToken($token)
    {
        try {
            $ck = 'fb_user_' . md5($token);

            $user = $this->memcached->get($ck);

            if ($this->memcached->getResultCode() === Memcached::RES_NOTFOUND) {
                $user = $this->fbClient->get('me?fields=id,email,name,picture', $token)->getGraphUser();
                $this->memcached->set($ck, $user, static::CACHE_TTL);
            }

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function updateUser(User $user, array $data)
    {
        foreach ($data as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            if (method_exists($user, $methodName)) {
                call_user_func_array([$user, $methodName], [$value]);
            } else {
                throw new Exception($key . ' is not a valid property');
            }
        }
        $this->repository->save($user);
    }
}

