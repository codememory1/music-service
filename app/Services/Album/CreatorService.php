<?php

namespace App\Services\Album;

use App\Orm\Entities\UserEntity;
use App\Services\AbstractCrudService;
use Codememory\Components\Validator\Manager;

/**
 * Class CreatorService
 *
 * @package App\Services\Album
 *
 * @author  Danil
 */
class CreatorService extends AbstractCrudService
{

    public function make(Manager $manager, UserEntity $userEntity): static
    {

    }

}