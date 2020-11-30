<?php

namespace App\Factory;

use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;
use predis;

final class RedisFactory
{

    /**
     * The Redis Instance
     * 
     * @var Redis
     */
    public $redis;

    /**
     * Logger Interface
     * 
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(array $settings, LoggerFactory $logger)
    {

        $this->logger = $logger
        ->addFileHandler('redis_factory.log')
        ->createInstance('redis_factory_process');

        if(file_exists(dirname(__DIR__, 2).'/vendor/predis/predis/autoload.php')) {
            require dirname(__DIR__, 2).'/vendor/predis/predis/autoload.php';
        } else {
            print_r('file not found');
            exit;
        }

        try {
            Predis\Autoloader::register();
        } catch( Exception $e ) {
            $this->logger->error('Redis Factory: '.$e->getMessage());
        }

        try {
            $this->redis = new \Predis\Client();
        } catch( Exception $e) {
            $this->logger->error('Redis Factory: '.$e->getMessage());
        }
    
    }

    public function createInstance()
    {
        return $this->redis;
    }

}