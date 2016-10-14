<?php

namespace Twbot\Core;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;

final class Error extends \Slim\Handlers\Error
{
    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Error constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param \Exception $exception
     * @return Response
     */
    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        $this->logger->addCritical($exception->getMessage());

        return parent::__invoke($request, $response, $exception);
    }
}