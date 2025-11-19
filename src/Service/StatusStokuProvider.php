<?php

namespace LechuGuziec\StatusStokuBundle\Service;

use Doctrine\ORM\NonUniqueResultException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use LechuGuziec\StatusStokuBundle\Entity\StatusStoku;
use LechuGuziec\StatusStokuBundle\Repository\StatusStokuRepository;

final class StatusStokuProvider
{
    public function __construct(
        private StatusStokuRepository $repository,
        private CacheItemPoolInterface $cache,
        private ?int $cacheTtl = 60
    ) {}

    /**
     * @throws NonUniqueResultException
     * @throws InvalidArgumentException
     */
    public function current(): ?StatusStoku
    {
        $item = $this->cache->getItem('status_stoku.current');
        if ($this->cacheTtl !== null && $item->isHit()) {
            return $item->get();
        }

        $status = $this->repository->findLatest();
        if ($this->cacheTtl !== null) {
            $item->set($status);
            $item->expiresAfter($this->cacheTtl);
            $this->cache->save($item);
        }

        return $status;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function invalidate(): void
    {
        if ($this->cacheTtl === null) {
            return;
        }

        $this->cache->deleteItem('status_stoku.current');
    }
}
