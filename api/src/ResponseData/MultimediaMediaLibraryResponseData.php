<?php

namespace App\ResponseData;

use App\Entity\Multimedia;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class MultimediaMediaLibraryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];
    public ?string $title = null;
    public ?string $image = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    public function handleMultimedia(Multimedia $multimedia): array
    {
        $multimediaResponseData = new MultimediaResponseData($this->container);

        $multimediaResponseData->setIgnoreProperty('album');
        
        return $multimediaResponseData->setEntities($multimedia)->getResponse();
    }
}