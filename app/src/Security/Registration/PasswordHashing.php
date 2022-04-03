<?php

namespace App\Security\Registration;

use App\Rest\DTO\AbstractPasswordDTO;
use App\Service\HashingService;

/**
 * Class PasswordHashing.
 *
 * @package App\Security\Registration
 *
 * @author  Codememory
 */
class PasswordHashing
{
    /**
     * @param AbstractPasswordDTO $passwordDTO
     *
     * @return string
     */
    public function encode(AbstractPasswordDTO $passwordDTO): string
    {
        return (new HashingService())->encode($passwordDTO->password);
    }
}