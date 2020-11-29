<?php

namespace App\Domain\Channel\Service;

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Domain\Channel\Repository\ChannelRepository;
use App\Domain\Channel\Data\Channel;

/**
 * ChannelCreateService
 * 
 * @category FinalClass
 * @package  ChannelService
 * @author   Dillon Lomnitzer <dillon.lomnitzer@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     github.com/DLzer/ripchat
 */
final class ChannelCreateService
{
    /**
     * Repository
     * 
     * @var ChannelRepository
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
     * @var Channel
     */
    private $channel;

    /**
     * Response onbject
     */
    public $response;

    /**
     * Class Constructor
     *
     * @param LoggerFactory $_logger
     * 
     * @param ChannelRepository $_repository
     */
    public function __construct(LoggerFactory $logger, ChannelRepository $repository, Channel $channel)
    {
        $this->repository           = $repository;
        $this->channel              = $channel;
        $this->logger               = $logger
            ->addFileHandler('site_approval_service.log')
            ->createInstance('site_approval_service_process');
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
        $this->channel->channelHash = 'c:'.md5(time());
        $this->channel->createdTime = time();

        // Save channel in memory
        $this->repository->set($this->channel->channelHash, $this->channel->createdTime, 30);

        // Respond with channel info
        $this->response = $this->channel;
        return $this->response;
    }

}