<?php

namespace App\Rest\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractPasswordDTO.
 *
 * @package App\Rest\DTO
 *
 * @author  Codememory
 */
abstract class AbstractPasswordDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    #[Assert\NotBlank(message: 'user@passwordIsRequired')]
    #[Assert\Length(min: 8, minMessage: 'user@passwordMinLength')]
    #[Assert\Regex('/^[a-z0-9\-_%\.\$\#]+$/i', message: 'user@passwordRegex')]
    public ?string $password = null;
}