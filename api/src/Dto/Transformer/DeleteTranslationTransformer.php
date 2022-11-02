<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\DeleteTranslationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<DeleteTranslationDto>
 */
final class DeleteTranslationTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly DeleteTranslationDto $deleteTranslationDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->deleteTranslationDto, $entity);
    }
}