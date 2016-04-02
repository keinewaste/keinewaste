<?php
namespace KeineWaste\Dto;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="keinewaste.users")
 **/
class User extends Dto implements \JsonSerializable
{

    function __construct($address, $bio, $companyName, $email, $name, $type, $imageUrl, $offers = null, $createdAt = null)
    {
        $this->address = $address;
        $this->bio = $bio;
        $this->companyName = $companyName;
        $this->createdAt = $createdAt ? $createdAt : new \DateTime("now");
        $this->email = $email;
        $this->imageUrl = $imageUrl;
        $this->name = $name;
        $this->offers = $offers ? $offers : new ArrayCollection();
        $this->type = $type;
    }

    public function jsonSerialize()
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer->jsonSerialize();
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'companyName' => $this->companyName,
            'email' => $this->email,
            'bio' => $this->bio,
            'type' => $this->type,
            'imageUrl' => $this->imageUrl,
            'offers' => $offers,
            'createdAt' => $this->createdAt,
        ];
    }

    /**
     * @Id @Column(type="integer", name="id") @GeneratedValue
     * @var int $id
     */
    protected $id;

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
     * @Column(type="string")
     * @var string
     */
    protected $companyName;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $address;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $type;

    /**
     * @Column(type="text")
     * @var string
     */
    protected $bio;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $imageUrl;

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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