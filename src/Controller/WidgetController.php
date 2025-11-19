<?php

namespace LechuGuziec\StatusStokuBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\InvalidArgumentException;
use LechuGuziec\StatusStokuBundle\Service\StatusStokuProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class WidgetController extends AbstractController
{
    public function __construct(
        private StatusStokuProvider $provider,
        #[Autowire(param: 'status_stoku.widget_template')] private string $widgetTemplate,
        #[Autowire(param: 'status_stoku.camera_url')] private ?string $cameraUrl = null,
        #[Autowire(param: 'status_stoku.cache_ttl')] private ?int $sharedCacheTtl = 60
    ) {}

    public function widget(): Response
    {
        try {
            $status = $this->provider->current();
        } catch (NonUniqueResultException|InvalidArgumentException) {
            $status = null;
        }

        $response = $this->render($this->widgetTemplate, [
            'status' => $status,
            'cameraUrl' => $this->cameraUrl,
        ]);

        $this->applyHttpCache($response);

        return $response;
    }

    public function api(): JsonResponse
    {
        try {
            $status = $this->provider->current();
        } catch (NonUniqueResultException|InvalidArgumentException) {
            $status = null;
        }

        $payload = $status ? [
            'wyciagi' => $status->getWyciagi()->value,
            'pokrywaCm' => $status->getPokrywa(),
            'warunki' => $status->getWarunki()->value,
            'updatedAt' => $status->getUpdatedAt()?->format(DATE_ATOM),
        ] : null;

        $response = new JsonResponse($payload, $payload ? Response::HTTP_OK : Response::HTTP_NO_CONTENT);
        $this->applyHttpCache($response);

        return $response;
    }

    private function applyHttpCache(Response $response): void
    {
        if ($this->sharedCacheTtl === null) {
            $response->setPrivate();

            return;
        }

        $response->setSharedMaxAge($this->sharedCacheTtl);
        $response->setPublic();
    }
}
