<?php
namespace KeineWaste\Dto;

/**
 * @Entity
 * @Table(name="keinewaste.products")
 **/
class Product extends Dto implements \JsonSerializable
{
    function __construct($title, $imageUrl, $quantity, $offer)
    {
        $this->title = $title;
        $this->imageUrl = $imageUrl;
        $this->quantity = $quantity;
        $this->offer = $offer;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'imageUrl' => $this->imageUrl,
            'quantity' => $this->quantity,
        ];
    }

    /**
     * @var int $id
     * @Id @Column(type="integer", name="id") @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Offer")
     * @JoinColumn(name="offer_id", referencedColumnName="id")
     */
    protected $offer;

    /** @Column(type="string") */
    protected $title;

    /** @Column(type="string") */
    protected $imageUrl;

    /** @Column(type="string") */
    protected $quantity;

    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $offer
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return mixed
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

}