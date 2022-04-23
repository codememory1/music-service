<?php

namespace App\Utils;

/**
 * Class EmailUtil.
 *
 * @package App\Utils
 *
 * @author  Codememory
 */
class EmailUtil
{
    /**
     * @var string
     */
    private string $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return explode('@', $this->email)[0];
    }

    /**
     * @return null|string
     */
    public function getDomain(): ?string
    {
        return explode('@', $this->email)[1] ?? null;
    }
}