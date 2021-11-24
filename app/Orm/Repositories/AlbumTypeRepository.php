<?php

namespace App\Orm\Repositories;

use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;

/**
 * Class AlbumTypeRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class AlbumTypeRepository extends AbstractEntityRepository
{

    public const DEMO = 'demo';
    public const DEBUT = 'debut';
    public const JOINT = 'joint';

}