<?php

namespace App\Action;

use App\Domain\Message\Service\MessageService;
use Psr\Http\Message\ResponseInterface as ServerResponse;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use App\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

final class MessageSendAction
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageService
     */
    private $message;

    public function __construct(LoggerFactory $logger, MessageService $message) {

        $this->logger = $logger
            ->addFileHandler('message_action.log')
            ->createInstance('message_action_process');

        $this->message = $message;
    }

    public function __invoke(ServerRequest $request, ServerResponse $response): ServerResponse
    {   

        $start              = microtime(true);
        $res                = $this->message->create((object)$request->getParsedBody());
        $time_elapsed_secs  = round(microtime(true) - $start);

        $this->logger->info(sprintf('Successful process ran at: %s', date('l jS \of F Y h:i:s A')));
        return $response->withJson(['response' => $res, 'efficiency' => 'Request took '.$time_elapsed_secs.' seconds.'], 200);

    }
}