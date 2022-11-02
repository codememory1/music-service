<?php

namespace App\Service;

use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtTokenGenerator
{
    private readonly DateTimeImmutable $datetime;

    public function __construct(
        private readonly ParseCronTimeService $parseCronTime,
        private readonly ParameterBagInterface $parameterBag
    ) {
        $this->datetime = new DateTimeImmutable();
    }

    public function encode(array $data, string $privateKeyParameterName, string $ttlParameterName): string
    {
        return JWT::encode(
            $this->collectPayload($data, $this->parameterBag->get($ttlParameterName)),
            $this->getKey($privateKeyParameterName),
            'RS256'
        );
    }

    public function decode(string $token, string $publicKeyParameterName): object|bool
    {
        try {
            return JWT::decode($token, new Key($this->getKey($publicKeyParameterName), 'RS256'));
        } catch (Exception) {
            return false;
        }
    }

    public function getKey(string $parameterName): string
    {
        $kernelProjectDir = $this->parameterBag->get('kernel.project_dir');
        $pathToFile = $this->parameterBag->get($parameterName);

        return file_get_contents("${kernelProjectDir}/${pathToFile}");
    }

    private function generateSub(): string
    {
        return Uuid::uuid4()->toString();
    }

    private function makeExp(string $cronTime): int
    {
        return $this->datetime->getTimestamp() + $this->parseCronTime->setTime($cronTime)->toSecond();
    }

    #[ArrayShape([
        'sub' => 'string',
        'exp' => 'int',
        'iat' => 'int',
        2 => 'array'
    ])]
    private function collectPayload(array $payload, string $lifeInCronTimeFormat): array
    {
        return [
            'sub' => $this->generateSub(),
            'exp' => $this->makeExp($lifeInCronTimeFormat),
            'iat' => $this->datetime->getTimestamp(),
            ...$payload
        ];
    }
}