<?php

namespace App\Controller\HTTPcatchMethodNotAllowed;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HTTPcatchMethodNotAllowed implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Quand l'évenement se passe = méthode(s) à exécuter
        return [
            KernelEvents::EXCEPTION => 'httpMethodNotAllowedJsonOutput',
        ];
    }

    public function httpMethodNotAllowedJsonOutput(ExceptionEvent $event)
    {
        $exeption = $event->getThrowable();

        if ($exeption instanceof MethodNotAllowedHttpException) {
            $data = [
                'message' => $exeption->getMessage(),
                'statut' => Response::HTTP_METHOD_NOT_ALLOWED,
            ];

            $response = new JsonResponse($data);

            $event->setResponse($response);
        }
    }

}
