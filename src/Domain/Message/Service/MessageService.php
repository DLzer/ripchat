<?php

namespace App\Domain\Message\Service;

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Domain\Message\Repository\MessageRepository;
use App\Domain\Message\Data\Message;

/**
 * MessageService
 * 
 * @category FinalClass
 * @package  MessageService
 * @author   Dillon Lomnitzer <dillon.lomnitzer@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     github.com/DLzer/ripchat
 */
final class MessageService
{
    /**
     * Repository
     * 
     * @var MessageRepository
     */
    private $repository;

    /**
     * Logger
     * 
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Data model
     *
     * @var Message
     */
    private $message;

    /**
     * Response onbject
     */
    public $response;

    /**
     * Class Constructor
     *
     * @param LoggerFactory $_logger
     * 
     * @param MessageRepository $_repository
     */
    public function __construct(LoggerFactory $logger, MessageRepository $repository, Message $message)
    {
        $this->repository           = $repository;
        $this->message              = $message;
        $this->logger               = $logger
            ->addFileHandler('message_service.log')
            ->createInstance('messagel_service_process');
        $this->response             = new \stdClass();
    }

    /**
     * Run will fire off the class function
     *
     * @param object $request
     * @return boolean
     */
    public function create(object $request): object
    {

        // Create channel
        $this->message->messageHash = 'm:'.md5(time());
        $this->message->createdTime = time();

        // Save channel in memory
        $this->repository->set($this->message->messageHash, $this->message->createdTime, 30);

        // Respond with channel info
        $this->response = $this->message;
        return $this->response;
    }

}