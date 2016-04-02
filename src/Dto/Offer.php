<?php
namespace KeineWaste\Dto;

/**
 * @Entity
 * @Table(name="keinewaste.offers")
 **/
class Offer extends Dto implements \JsonSerializable
{

    function __construct($createdAt, $deliveryType, $description, $distance, $products, $meetingTime, $status, $user)
    {
        $this->user = $user;
        $this->createdAt = $createdAt;
        $this->deliveryType = $deliveryType;
        $this->description = $description;
        $this->distance = $distance;
        $this->products = $products;
        $this->meetingTime = $meetingTime;
        $this->status = $status;
    }

    //@todo: __toString()

    public function jsonSerialize()
    {
        $products = [];
        foreach ($this->products as $product) {
            $products[] = $product->jsonSerialize();
        }

        return [
            'id' => $this->id,
            'description' => $this->description,
            'products' => $products,
            'deliveryType' => $this->deliveryType,
            'distance' => $this->distance,
            'status' => $this->status,
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
}