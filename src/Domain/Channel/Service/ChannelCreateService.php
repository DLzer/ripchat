<?php

namespace App\Domain\Channel\Service;

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use App\Domain\Site\Repository\ChannelRepository;

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
     * Response onbject
     */
    public $response;

    /**
     * Class Constructor
     *
     * @param LoggerFactory $_logger
     * 
     * @param SiteApprovalRepository $_repository
     */
    public function __construct(LoggerFactory $logger, ChannelRepository $repository)
    {
        $this->repository           = $repository;
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

        return $this->response;
    }

}