<?php

namespace App\Action;

use App\Domain\Channel\Service\ChannelCreateService;
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
     * @var ChannelCreateService
     */
    private $channel;

    public function __construct(LoggerFactory $logger, ChannelCreateService $channel) {

        $this->logger = $logger
            ->addFileHandler('site_approval_action.log')
            ->createInstance('site_approval_action_process');

        $this->channel = $channel;
    }

    public function __invoke(ServerRequest $request, ServerResponse $response): ServerResponse
    {   

        $start              = microtime(true);
        $res                = $this->channel->create((object)$request->getParsedBody());
        $time_elapsed_secs  = round(microtime(true) - $start);

        $this->logger->info(sprintf('Successful process ran at: %s', date('l jS \of F Y h:i:s A')));
        return $response->withJson(['response' => $res, 'efficiency' => 'Request took '.$time_elapsed_secs.' seconds.'], 200);

    }
}