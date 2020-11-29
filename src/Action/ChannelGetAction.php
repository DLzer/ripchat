<?php

namespace App\Action;

use App\Domain\Channel\Service\ChannelGetService;
use Psr\Http\Message\ResponseInterface as ServerResponse;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class ChannelCreateAction
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ChannelGetService
     */
    private $channel;

    public function __construct(LoggerFactory $logger, ChannelGetService $channel) {

        $this->logger = $logger
            ->addFileHandler('channel_get_action.log')
            ->createInstance('channel_get_action_process');

        $this->channel = $channel;
    }

    public function __invoke(ServerRequest $request, ServerResponse $response): ServerResponse
    {   

        $start              = microtime(true);
        $res                = $this->channel->get((object)$request->getParsedBody());
        $time_elapsed_secs  = round(microtime(true) - $start);

        $this->logger->info(sprintf('Successful process ran at: %s', date('l jS \of F Y h:i:s A')));
        return $response->withJson(['response' => $res, 'efficiency' => 'Request took '.$time_elapsed_secs.' seconds.'], 200);

    }
}