<?php


namespace KeineWaste\Services;

use KeineWaste\Dto\Message;
use KeineWaste\Services\Repository\MessageRepository;
use Psr\Log\LoggerAwareTrait;
use KeineWaste\Dto\User;

class MessageService
{
    use LoggerAwareTrait;

    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @param User   $from
     * @param User   $to
     * @param string $message
     *
     * @return Message
     */
    public function sendMessage(User $from, User $to, $message)
    {
        $dtoMessage = new Message();
        $dtoMessage->setSender($from);
        $dtoMessage->setReceiver($to);
        $dtoMessage->setMessage($message);
        $this->messageRepository->save($dtoMessage);
        return $dtoMessage;

    }
}