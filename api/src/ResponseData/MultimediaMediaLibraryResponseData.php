<?php

namespace App\ResponseData;

use App\Entity\Multimedia;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class MultimediaMediaLibraryResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MultimediaMediaLibraryResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\Callback('handleMultimedia')]
    public array $multimedia = [];

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    public function handleMultimedia(Multimedia $multimedia): array
    {
        $multimediaResponseData = new MultimediaResponseData($this->container);

        $multimediaResponseData->setEntities($multimedia);
        $multimediaResponseData->setIgnoreProperty('album');

        return $multimediaResponseData->collect()->getResponse(true);
    }
}