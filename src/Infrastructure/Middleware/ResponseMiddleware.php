<?php /** @noinspection PhpUnused */


namespace App\Infrastructure\Middleware;

use FOS\RestBundle\View\View;
use League\Tactician\Middleware;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseMiddleware
 * @package Face\Infrastructure\Middleware\Rest
 */
class ResponseMiddleware implements Middleware
{
    /**
     * @param $command
     * @param callable $next
     *
     * @return View
     */
    public function execute($command, callable $next): View
    {
        $response = $next($command);
        return View::create($response, Response::HTTP_CREATED);
    }
}
