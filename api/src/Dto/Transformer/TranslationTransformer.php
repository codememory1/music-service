<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\TranslationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Translation;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class SubscriptionTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<TranslationDto>
 *
 * @author  Codememory
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
        return $this->translationDto
            ->setEntity($entity ?: new Translation())
            ->collect($this->request->all());
    }
}