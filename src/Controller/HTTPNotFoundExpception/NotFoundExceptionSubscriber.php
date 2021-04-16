<?php

namespace App\Controller\HTTPNotFoundExpception;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class NotFoundExceptionSubscriber implements EventSubscriberInterface //l'évenement a écouter
{
    public static function getSubscribedEvents()
    {
        // Quand l'évenement se passe = méthode(s) à exécuter
        return [
            KernelEvents::EXCEPTION => 'httpNotFoundJsonOutput',
        ];
    }

    // La méthode exécuter lors du lancement de l'événement
    public function httpNotFoundJsonOutput(ExceptionEvent $event)
    {
        $exeption = $event->getThrowable();

        if ($exeption instanceof NotFoundHttpException) {
            $data = [
                'message' => $exeption->getMessage(),
                'statut' => Response::HTTP_NOT_FOUND,
            ];

            $response = new JsonResponse($data);

            $event->setResponse($response);
        }
    }
}
