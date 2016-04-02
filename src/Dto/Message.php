<?php

namespace KeineWaste\Dto;

/**
 * @Entity @Table(name="keinewaste.messages")
 **/
class Message extends Dto implements \JsonSerializable
{
    public function jsonSerialize()
    {
        return [
            'id'       => $this->id,
            'sender'   => $this->sender,
            'receiver' => $this->receiver,
            'message'  => $this->message,
            'sent_at'  => $this->sentAt->format(DATE_ISO8601),
        ];
    }

    public function __construct()
    {
        $this->sentAt = new \DateTime();
    }

    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     * @var int $id
     */
    protected $id;


    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="sender", referencedColumnName="id")
     * @var User $sender
     */
    protected $sender;


    /**
     * @OneToOne(targetEntity="User")
     * @JoinColumn(name="receiver", referencedColumnName="id")
     * @var User $receiver
     */
    protected $receiver;

    /**
     * @Column(type="string", name="message")
     * @var string $message
     */
    protected $message;

    /**
     * @Column(type="datetime", name="sent_at")
     * @var \DateTime $sentAt
     */
    protected $sentAt;


}