<?php

namespace App\Infrastructure\Controller;

use App\Infrastructure\CommandBus\Schedule\CreateSlotsCommand;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\Request;

class SlotController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/slots", requirements={"_format": "json"}, defaults={"_format"="json"})
     */
    public function postSlotAction(CommandBus $commandBus, Request $request)
    {
        $command = new CreateSlotsCommand(
            $request->request->get('slots'),
        );
        return $commandBus->handle($command);
    }
}
