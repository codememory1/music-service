<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\DeleteTranslationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class DeleteTranslationTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<DeleteTranslationDto>
 *
 * @author  Codememory
 */
final class DeleteTranslationTransformer extends AbstractDataTransformer
{
    private DeleteTranslationDto $deleteTranslationDto;

    #[Pure]
    public function __construct(Request $request, DeleteTranslationDto $deleteTranslationDto)
    {
        parent::__construct($request);

        $this->deleteTranslationDto = $deleteTranslationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->deleteTranslationDto->collect($this->request->all());
    }
}