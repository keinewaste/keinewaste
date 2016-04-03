<?php


namespace KeineWaste\Controllers;

use KeineWaste\Controllers\Base\BaseTrait;
use KeineWaste\Services\UserService;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController
{
    use BaseTrait;
    use LoggerAwareTrait;

    /**
     * @var UserService
     */
    protected $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function getAction(Request $request)
    {

        $id = $request->get('id');

        if ($id == 'me') {
            $user = $this->getLoggedUser($request, false);
        } else {
            $user = $this->userService->getUserById($id);
        }

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        return $this
            ->getResponse()
            ->setData(
                $user
            );
    }

    public function updateAction(Request $request)
    {
        $user = $this->getLoggedUser($request, false);

        $requestContent = $request->getContent();

        $requestData = json_decode($requestContent, true);

        //@todo:remove hardcore
        $requestData['companyName'] = 'Restaurant amigo';
        $requestData['address'] = 'Greifswalder Strasse 212, Berlin';
        $requestData['type'] = 'donor';
        $requestData['bio'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sit amet ante tincidunt, bibendum arcu ut, elementum nunc. In hac habitasse platea dictumst. Nullam vulputate id felis vitae commodo. Donec finibus, ante vel congue placerat, urna sapien feugiat quam, ut bibendum metus sapien vel lorem. Nunc placerat fringilla mauris eget congue. Fusce et finibus magna, sit amet fermentum leo. Praesent tellus augue, pellentesque vel consequat id, venenatis eget nulla. Nunc pharetra ante at dignissim rhoncus. Aliquam hendrerit fermentum purus, et pellentesque nisl malesuada id. Fusce pharetra, metus ut fringilla aliquam, lectus erat suscipit est, nec tristique sem neque eu nisi.';
        $requestData['imageUrl'] = 'https://avatars.slack-edge.com/2015-03-18/4091755768_facdb1b91bc481c3d895_192.jpg';

        if ($requestData == null || !is_array($requestData)) {
            throw new BadRequestHttpException();
        }

        $this->userService->updateUser($user, $requestData);

        return $this
            ->getResponse()
            ->setData(
                $user
            )
            ->setStatusCode(201);
    }
}