<?php
namespace KeineWaste\Dto;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="keinewaste.offers")
 **/
class Offer extends Dto implements \JsonSerializable
{

    function __construct($user, $deliveryType, $description, $distance, $products, $meetingTime, $categories)
    {
        $this->user = $user;
        $this->deliveryType = $deliveryType;
        $this->description = $description;
        $this->distance = $distance;
        $this->products = $products ? $products : new ArrayCollection;
        $this->categories = $categories ? $categories : new ArrayCollection;
        $this->meetingTime = $meetingTime;

        $this->createdAt = new \DateTime("now");
        $this->status = 'new';
    }

    //@todo: __toString()

    public function jsonSerialize()
    {
        $products = [];
        foreach ($this->products as $product) {
            $products[] = $product->jsonSerialize();
        }

        $categories = [];
        foreach ($this->categories as $category) {
            $categories[] = $category->jsonSerialize();
        }

        return [
            'id' => $this->id,
            'description' => $this->description,
            'products' => $products,
            'deliveryType' => $this->deliveryType,
            'distance' => $this->distance,
            'status' => $this->status,
            'categories' => $categories,
            'meetingTime' => $this->meetingTime,
            'user_id' => $this->user->getId(),
        ];
    }

    /**
     * @Id @Column(type="integer", name="id") @GeneratedValue
     * @var int $id
     */
    protected $id;

    /**
     * @var User $user
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Category[] $categories
     * @ManyToMany(targetEntity="Category",cascade={"persist"})
     * @JoinTable(name="offers_categories",
     *      joinColumns={@JoinColumn(name="offer_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id")}
     *      )
     */
    protected $categories;

    /** @Column(type="text") */
    protected $description;

    /** @Column(type="datetime", name="posted_at") */
    protected $createdAt;

    /**
     * @var Product[] $products
     * @OneToMany(targetEntity="Product", mappedBy="offer")
     */
    protected $products;

    /** @Column(type="datetime") */
    protected $meetingTime;

    /** @Column(type="string") */
    protected $deliveryType;

    /** @Column(type="integer") */
    protected $distance;

    /** @Column(type="string") */
    protected $status;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \KeineWaste\Dto\User
     */
    public function getUser()
    {
        return $this->user;
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
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
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

    /**
     * @param mixed $meetingTime
     */
    public function setMeetingTime($meetingTime)
    {
        $this->meetingTime = $meetingTime;
    }

    /**
     * @return mixed
     */
    public function getMeetingTime()
    {
        return $this->meetingTime;
    }

    /**
     * @param \KeineWaste\Dto\Product[] $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return \KeineWaste\Dto\Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }



}