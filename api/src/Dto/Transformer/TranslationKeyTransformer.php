<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\TranslationKeyDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<TranslationKeyDto>
 */
final class TranslationKeyTransformer extends AbstractDataTransformer
{
    private TranslationKeyDto $translationKeyDto;

    #[Pure]
    public function __construct(Request $request, TranslationKeyDto $translationKeyDto)
    {
        parent::__construct($request);

        $this->translationKeyDto = $translationKeyDto;
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->translationKeyDto
            ->setEntity($entity ?: new TranslationKey())
            ->collect($data);
    }
}