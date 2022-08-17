<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\TranslationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Translation;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<TranslationDto>
 */
final class TranslationTransformer extends AbstractDataTransformer
{
    private TranslationDto $translationDto;

    #[Pure]
    public function __construct(Request $request, TranslationDto $translationDto)
    {
        parent::__construct($request);

        $this->translationDto = $translationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->translationDto, $entity ?: new Translation());
    }
}