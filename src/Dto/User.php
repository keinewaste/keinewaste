<?php
namespace KeineWaste\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Pseudo\Exception;

/**
 * @Entity
 * @Table(name="keinewaste.users")
 **/
class User extends Dto implements \JsonSerializable
{
    const USER_TYPE_DONOR = "donor";
    const USER_TYPE_RECEIVER = "receiver";

    function __construct($facebookId, $email, $name, $createdAt = null)
    {
        $this->facebookId = $facebookId;
        $this->email      = $email;
        $this->name       = $name;
        $this->type       = static::USER_TYPE_RECEIVER;
        $this->offers     = new ArrayCollection();
        $this->createdAt  = $createdAt ? $createdAt : new \DateTime("now");
        $this->categories = new ArrayCollection;
    }

    public function jsonSerialize()
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer->jsonSerialize();
        }

        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = $category->jsonSerialize();
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
            'imageUrl'    => $this->imageUrl,
            // consumer fields below. empty for donors
            'deliveryType' => $this->deliveryType,
            'distance' => $this->distance,
            'categories' => $categories,
            'meetingTimeFrom' => $this->meetingTimeFrom,
            'meetingTimeTo' => $this->meetingTimeTo,
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


    /** @Column(type="string", nullable=true) */
    protected $imageUrl;


    // consumer fields below. empty for donors
    /**
     * @var Category[] $categories
     * @ManyToMany(targetEntity="Category",cascade={"persist"})
     * @JoinTable(name="users_categories",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */
    protected $categories;

    /** @Column(type="datetime", nullable=true) */
    protected $meetingTimeFrom;

    /** @Column(type="datetime", nullable=true) */
    protected $meetingTimeTo;

    /** @Column(type="string", nullable=true) */
    protected $deliveryType;

    /** @Column(type="integer", nullable=true) */
    protected $distance;

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
     * @param $type
     *
     * @throws Exception
     */
    public function setType($type)
    {
        if ($type !== static::USER_TYPE_RECEIVER && $type != static::USER_TYPE_DONOR) {
            throw new Exception("User type is invalid");
        }
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \KeineWaste\Dto\Category[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \KeineWaste\Dto\Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $deliveryType
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return mixed
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    /**
     * @param mixed $meetingTimeFrom
     */
    public function setMeetingTimeFrom($meetingTimeFrom)
    {
        $this->meetingTimeFrom = $meetingTimeFrom;
    }

    /**
     * @return mixed
     */
    public function getMeetingTimeFrom()
    {
        return $this->meetingTimeFrom;
    }

    /**
     * @param mixed $meetingTimeTo
     */
    public function setMeetingTimeTo($meetingTimeTo)
    {
        $this->meetingTimeTo = $meetingTimeTo;
    }

    /**
     * @return mixed
     */
    public function getMeetingTimeTo()
    {
        return $this->meetingTimeTo;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }


}