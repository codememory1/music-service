<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\LanguageDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Infrastucture\Dto\AbstractDataTransformer;
use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<LanguageDto>
 */
final class LanguageTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly LanguageDto $languageDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->languageDto, $entity ?: new Language());
    }
}