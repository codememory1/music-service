<?php

namespace App\Services\Album;

use App\Orm\Repositories\AlbumRepository;
use App\Services\AbstractCrudService;

/**
 * Class DeleterService
 *
 * @package App\Services\Album
 *
 * @author  Danil
 */
class DeleterService extends AbstractCrudService
{

    public function make(AlbumRepository $albumRepository, int $id): static
    {

    }

}