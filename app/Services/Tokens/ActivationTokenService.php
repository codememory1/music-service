<?php

namespace App\Services\Tokens;

use Codememory\Components\DateTime\Exceptions\InvalidTimezoneException;
use Codememory\Components\DateTime\Time;
use Exception;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;

/**
 * Class ActivationTokenService
 *
 * @package App\Services\Tokens
 *
 * @author  Danil
 */
class ActivationTokenService
{

    /**
     * @return string
     * @throws InvalidTimezoneException
     */
    public function encode(): string
    {

        // Token lifetime in minutes
        $exp = (new Time())->now() + (env('jwt.life-activation') * 60);
        $jwtToken = JWT::encode([
            'sub' => Uuid::uuid4()->toString(),
            'exp' => $exp
        ], env('jwt.secret-activation'));

        return base64_encode($jwtToken);

    }

    /**
     * @param string $token
     *
     * @return object
     */
    public function decode(string $token): object
    {

        return JWT::decode(base64_decode($token), env('jwt.secret-activation'), ['HS256']);

    }

    /**
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool
    {

        try {
            $this->decode($token);

            return true;
        } catch (Exception) {
            return false;
        }

    }

}