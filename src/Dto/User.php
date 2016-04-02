<?php
namespace KeineWaste\Dto;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="keinewaste.users")
 **/
class User extends Dto implements \JsonSerializable
{


    function __construct($facebookId, $email, $name, $createdAt = null)
    {

        $this->facebookId = $facebookId;
        $this->email      = $email;
        $this->name       = $name;

        $this->offers    = new ArrayCollection();
        $this->createdAt = $createdAt ? $createdAt : new \DateTime("now");
    }

    public function jsonSerialize()
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer->jsonSerialize();
        }

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'address'     => $this->address,
            'companyName' => $this->companyName,
            'email'       => $this->email,
            'bio'         => $this->bio,
            'type'        => $this->type,
            'offers'      => $offers,
            'createdAt'   => $this->createdAt,
            'imageUrl'    => $this->getProfilePicture()
        ];
    }

    /**
     * @Id @Column(type="integer", name="id") @GeneratedValue
     * @var int $id
     */
    protected $id;

    /**
     * @Column(type="bigint", name="facebook_id", unique=true)
     * @var int
     */
    protected $facebookId;

    /**
     * @var Offer[] $offers
     * @OneToMany(targetEntity="Offer", mappedBy="user")
     */
    protected $offers;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    protected $companyName;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    protected $address;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    protected $type;

    /**
     * @Column(type="text", nullable=true)
     * @var string
     */
    protected $bio;


    /**
     * @Column(type="datetime", name="posted_at")
     */
    protected $createdAt;

    /**
     * @Column(type="string", name="email")
     * @var string
     */
    protected $email;

    /**
     * @Column(type="text", name="token")
     * @var string
     */
    protected $token = null;

    /**
     * @OneToMany(targetEntity="Message", mappedBy="sender")
     * @var Message[]
     */
    protected $sentMessages;

    /**
     * @OneToMany(targetEntity="Message", mappedBy="receiver")
     * @var Message[]
     */
    protected $receivedMessages;


    /**
     * @var string
     */
    protected $profilePicture;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function isIndividual()
    {
        return $this->type === null;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        if ($this->isIndividual()) {
            return $this->profilePicture;
        }
        return null;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }


    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param \KeineWaste\Dto\Offer[] $offers
     */
    public function setOffers($offers)
    {
        $this->offers = $offers;
    }

    /**
     * @return \KeineWaste\Dto\Offer[]
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}