<?php

namespace App\Service\Parser\Interfaces;

use App\Entity\User;

interface MultimediaPerformerInterface
{
    public function getUser(): User;
}