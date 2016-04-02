<?php
namespace KeineWaste\Dto;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="keinewaste.users")
 **/
class User extends Dto implements \JsonSerializable
{
    function __construct($createdAt, $name, $offers = null)
    {
        $this->createdAt = $createdAt;
        $this->name = $name;
        $this->offers = $offers ? $offers : new ArrayCollection();
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
     * @OneToMany(targetEntity="Offer", mappedBy="user")
     */
    protected $offers;

    /** @Column(type="string") */
    protected $name;

    /** @Column(type="datetime", name="posted_at") */
    protected $createdAt;
}