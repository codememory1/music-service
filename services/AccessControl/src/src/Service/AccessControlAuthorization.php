<?php

namespace App\Service;

use App\Entity\AccessKey;
use App\Repository\AccessKeyRepository;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class AccessControlAuthorization
{
    public function __construct(
        private RequestStack $requestStack,
        private AccessKeyRepository $accessKeyRepository
    ) {
    }

    public function getHeader(): array|false
    {
        $request = $this->requestStack->getCurrentRequest();
        $accessKeyAuthorization = $request->headers->get('Access-Key-Authorization');
        $accessKeyParts = explode(' ', $accessKeyAuthorization, 2);

        if (count($accessKeyParts) < 2) {
            return false;
        }

        return $accessKeyParts;
    }

    public function getAccessKey(): ?AccessKey
    {
        $header = $this->getHeader();

        if (!$this->getHeader()) {
            return null;
        }

        return $this->accessKeyRepository->findByHeader($header[0], $header[1]);
    }
}