<?php

namespace App\Service;

use DateTime;
use DateTimeImmutable;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;

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
     * @var DateTime
     */
    private DateTimeImmutable $datetime;

    /**
     * @var ParseCronTimeService
     */
    private ParseCronTimeService $parseCronTime;

    public function __construct()
    {
        $this->datetime = new DateTimeImmutable();
        $this->parseCronTime = new ParseCronTimeService();
    }

    /**
     * @param array  $data
     * @param string $privateKey
     * @param string $lifeInCronTimeFormat
     *
     * @return string
     */
    public function encode(array $data, string $privateKey, string $lifeInCronTimeFormat): string
    {
        return JWT::encode(
            $this->collectPayload($data, $_ENV[$lifeInCronTimeFormat]),
            static::getKey($privateKey),
            'RS256'
        );
    }

    /**
     * @param string $token
     * @param string $publicKey
     *
     * @return bool|object
     */
    public function decode(string $token, string $publicKey): object|bool
    {
        try {
            return JWT::decode($token, new Key(static::getKey($publicKey), 'RS256'));
        } catch (Exception) {
            return false;
        }
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function getKey(string $name): string
    {
        return file_get_contents($_SERVER['PWD'] . '/' . $_ENV[$name]);
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