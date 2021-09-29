<?php

namespace App\Services\Tokens;

use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\DateTime\Time;
use Exception;
use Firebase\JWT\JWT;

/**
 * Class SessionTokenService
 *
 * @package App\Services\Tokens
 *
 * @author  Danil
 */
class SessionTokenService
{

    /**
     * @var Time
     */
    private Time $time;

    /**
     * @param Time $time
     */
    public function __construct(Time $time)
    {

        $this->time = $time;

    }

    /**
     * @param array $userData
     *
     * @return string[]
     * @throws InvalidTimezoneException
     */
    final public function generateTokens(array $userData): array
    {

        // Generation of two tokens for a certain period of life in minutes
        $access = $this->generate(env('jwt.life-access'), $userData, env('jwt.secret-access'));
        $refresh = $this->generate(env('jwt.life-refresh'), $userData, env('jwt.secret-refresh'));

        return [$access, $refresh];

    }

    /**
     * @param string $token
     *
     * @return bool
     */
    final public function verifyAccess(string $token): bool
    {

        return $this->verificationToken($token, env('jwt.secret-access'));

    }

    /**
     * @param string $token
     *
     * @return bool
     */
    final public function verifyRefresh(string $token): bool
    {

        return $this->verificationToken($token, env('jwt.secret-refresh'));

    }

    /**
     * @param string $token
     *
     * @return object
     */
    final public function decodeAccess(string $token): object
    {

        return JWT::decode($token, env('jwt.secret-access'), ['HS256']);

    }

    /**
     * @param string $token
     *
     * @return object
     */
    final public function decodeRefresh(string $token): object
    {

        return JWT::decode($token, env('jwt.secret-refresh'), ['HS256']);

    }

    /**
     * The main method of generating a token for a specific lifetime
     *
     * @param int    $lifeInMinutes
     * @param array  $data
     * @param string $secret
     *
     * @return string
     * @throws InvalidTimezoneException
     */
    private function generate(int $lifeInMinutes, array $data, string $secret): string
    {

        return JWT::encode(array_merge($data, [
            'exp' => $this->getTimeToUnix($lifeInMinutes)
        ]), $secret);

    }

    /**
     * Main token verification method
     *
     * @param string $token
     * @param string $secret
     *
     * @return bool
     */
    private function verificationToken(string $token, string $secret): bool
    {

        try {
            JWT::decode($token, $secret, ['HS256']);

            return true;
        } catch (Exception) {
            return false;
        }

    }

    /**
     * @param int $minutes
     *
     * @return int
     * @throws InvalidTimezoneException
     */
    private function getTimeToUnix(int $minutes): int
    {

        return $this->time->now() + ($minutes * 60);

    }

}