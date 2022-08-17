<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\LanguageDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<LanguageDto>
 */
final class LanguageTransformer extends AbstractDataTransformer
{
    private LanguageDto $languageDto;

    #[Pure]
    public function __construct(Request $request, LanguageDto $languageDto)
    {
        parent::__construct($request);

        $this->languageDto = $languageDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->languageDto, $entity ?: new Language());
    }
}