<?php
namespace KeineWaste\Dto;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="keinewaste.users")
 **/
class User extends Dto implements \JsonSerializable
{
    function __construct($createdAt, $name, $email, $offers = null)
    {
        $this->createdAt = $createdAt;
        $this->name      = $name;
        $this->email     = $email;
        $this->offers    = $offers ? $offers : new ArrayCollection();
    }

    public function jsonSerialize()
    {
        $offers = [];
        foreach ($this->offers as $offer) {
            $offers[] = $offer->jsonSerialize();
        }

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'offers'    => $offers,
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

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

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

}