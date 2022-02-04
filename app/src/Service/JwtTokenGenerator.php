<?php

namespace App\Service;

use DateTime;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;

/**
 * Class JwtTokenGenerator
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
    private DateTime $datetime;

    /**
     * @var ParseCronTimeService
     */
    private ParseCronTimeService $parseCronTime;

    public function __construct()
    {

        $this->datetime = new DateTime();
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
            $this->collectPayload($data, $lifeInCronTimeFormat),
            base64_decode($privateKey),
            'RS256'
        );

    }

    /**
     * @param string $token
     * @param string $publicKey
     *
     * @return object|bool
     */
    public function decode(string $token, string $publicKey): object|bool
    {

        try {
            return JWT::decode($token, new Key(base64_decode($publicKey), 'RS256'));
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

        return base64_decode($_ENV[$name]);

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
        'sub' => "string",
        'exp' => "int",
        'iat' => "int",
        2     => "array"
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