<?php
namespace KeineWaste\Dto;

/**
 * @Entity
 * @Table(name="keinewaste.offers")
 **/
class Offer extends Dto implements \JsonSerializable
{

    function __construct($createdAt, $deliveryType, $description, $distance, $imageUrl, $meetingTime, $status, $title, $user)
    {
        $this->user = $user;
        $this->createdAt = $createdAt;
        $this->deliveryType = $deliveryType;
        $this->description = $description;
        $this->distance = $distance;
        $this->imageUrl = $imageUrl;
        $this->meetingTime = $meetingTime;
        $this->title = $title;
        $this->status = $status;
    }

    //@todo: __toString()

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
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
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /** @Column(type="string") */
    protected $title;

    /** @Column(type="text") */
    protected $description;

    /** @Column(type="datetime", name="posted_at") */
    protected $createdAt;

    /** @Column(type="string") */
    protected $imageUrl;

    /** @Column(type="datetime") */
    protected $meetingTime;

    /** @Column(type="string") */
    protected $deliveryType;

    /** @Column(type="integer") */
    protected $distance;

    /** @Column(type="string") */
    protected $status;
}