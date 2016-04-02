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
}