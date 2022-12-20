<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\UserSettingDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\UserSetting;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;

/**
 * @template-extends AbstractDataTransformer<UserSettingDto>
 */
final class UserSettingTransformer extends AbstractDataTransformer
{
    public function __construct(
        Request $request,
        private readonly UserSettingDto $userSettingDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->userSettingDto, $entity ?: new UserSetting());
    }
}