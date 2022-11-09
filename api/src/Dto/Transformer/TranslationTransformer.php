<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\TranslationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Translation;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<TranslationDto>
 */
final class TranslationTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly TranslationDto $translationDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->translationDto, $entity ?: new Translation());
    }
}