<?php

namespace App\Domain\Channel\Service;

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Domain\Channel\Repository\ChannelRepository;
use App\Domain\Channel\Data\Channel;

/**
 * ChannelDeleteService
 * 
 * @category FinalClass
 * @package  ChannelService
 * @author   Dillon Lomnitzer <dillon.lomnitzer@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     github.com/DLzer/ripchat
 */
final class ChannelDeleteService
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
            ->addFileHandler('channel_delete_service.log')
            ->createInstance('channel_delete_service_process');
        $this->response             = new \stdClass();
    }

    /**
     * Run will fire off the class function
     *
     * @param object $request
     * @return boolean
     */
    public function delete(object $request)
    {

        if($this->repository->exists($request->channel_hash)) {

            // Save channel in memory
            $channel = $this->repository->del($request->channel_hash);

            // Respond with channel info
            $this->response = 'Channel Destroyed';
            return $this->response;

        } else {

            $this->response->error = 'Error: Channel no longer exists';
            return  $this->response;

        }
    }

}