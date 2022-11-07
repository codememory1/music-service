<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\TranslationKeyDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use App\Infrastructure\Dto\AbstractDataTransformer;
use App\Infrastructure\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

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