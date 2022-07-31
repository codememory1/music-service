<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\MultimediaDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Multimedia;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class MultimediaTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<MultimediaDto>
 *
 * @author  Codememory
 */
final class MultimediaTransformer extends AbstractDataTransformer
{
    private MultimediaDto $multimediaDto;

    #[Pure]
    public function __construct(Request $request, MultimediaDto $multimediaDto)
    {
        parent::__construct($request);

        $this->multimediaDto = $multimediaDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->multimediaDto
            ->setEntity($entity ?: new Multimedia())
            ->collect([
                ...$this->request->all(),
                'image' => $this->request?->request->files->get('image'),
                'multimedia' => $this?->request->request->files->get('multimedia'),
                'subtitles' => $this?->request->request->files->get('subtitles'),
            ]);
    }
}