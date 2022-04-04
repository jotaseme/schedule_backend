<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\CommandBus\Schedule\GetBlocksCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;

class BlockController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/blocks", requirements={"_format": "json"}, defaults={"_format"="json"})
     */
    public function getBlocksController(CommandBus $commandBus, Request $request)
    {
        return $commandBus->handle(
            new GetBlocksCommand($request->query->get('from'), $request->query->get('to'))
        );
    }
}
