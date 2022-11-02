<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\TranslationKeyDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<TranslationKeyDto>
 */
final class TranslationKeyTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly TranslationKeyDto $translationKeyDto
    ) {
        parent::__construct($request);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->translationKeyDto
            ->setEntity($entity ?: new TranslationKey())
            ->collect($data);
    }
}