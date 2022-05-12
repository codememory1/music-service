<?php

namespace App\Service;

use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class JwtTokenGenerator.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class JwtTokenGenerator
{
    /**
     * @var ParseCronTimeService
     */
    private ParseCronTimeService $parseCronTime;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBag;

    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $datetime;

    /**
     * @param ParseCronTimeService  $parseCronTimeService
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParseCronTimeService $parseCronTimeService, ParameterBagInterface $parameterBag)
    {
        $this->parseCronTime = $parseCronTimeService;
        $this->parameterBag = $parameterBag;
        $this->datetime = new DateTimeImmutable();
    }

    /**
     * @param array  $data
     * @param string $privateKeyParameterName
     * @param string $ttlParameterName
     *
     * @return string
     */
    public function encode(array $data, string $privateKeyParameterName, string $ttlParameterName): string
    {
        return JWT::encode(
            $this->collectPayload($data, $this->parameterBag->get($ttlParameterName)),
            $this->getKey($privateKeyParameterName),
            'RS256'
        );
    }

    /**
     * @param string $token
     * @param string $publicKeyParameterName
     *
     * @return object|bool
     */
    public function decode(string $token, string $publicKeyParameterName): object|bool
    {
        try {
            return JWT::decode($token, new Key($this->getKey($publicKeyParameterName), 'RS256'));
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @param string $parameterName
     *
     * @return string
     */
    public function getKey(string $parameterName): string
    {
        $kernelProjectDir = $this->parameterBag->get('kernel.project_dir');
        $pathToFile = $this->parameterBag->get($parameterName);

        return file_get_contents("$kernelProjectDir/$pathToFile");
    }

    /**
     * @return string
     */
    private function generateSub(): string
    {
        return Uuid::uuid4()->toString();
    }

    /**
     * @param string $cronTime
     *
     * @return int
     */
    private function makeExp(string $cronTime): int
    {
        return $this->datetime->getTimestamp() + $this->parseCronTime->setTime($cronTime)->toSecond();
    }

    /**
     * @param array  $payload
     * @param string $lifeInCronTimeFormat
     *
     * @return array
     */
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