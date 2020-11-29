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
        
        if($this->repository->exists($request->channel_hash)) {

            // Create channel
            $this->message->channelHash = $request->channel_hash;
            $this->message->messageBody = $request->message_body;

            // Save message in memory under the channel. Reset TTL to 60 seconds
            $this->repository->rpush($this->message->channelHash, $this->message->messageBody, 60);

            // Respond with channel info
            $this->response = $this->message;
            return $this->response;

        } else {

            $this->response = 'Error: Channel no longer exists';
            return  $this->response;

        }
    }

}