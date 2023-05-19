<?php

namespace App\Dto\Transformer;

use App\Dto\Transfer\UserProfileDesignDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\UserProfileDesign;
use App\Infrastructure\Dto\AbstractDataTransformer;
use Codememory\Dto\Interfaces\DataTransferInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<UserProfileDesignDto>
 */
final class UserProfileDesignTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly UserProfileDesignDto $userProfileDesignDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->userProfileDesignDto
            ->setObject($entity ?: new UserProfileDesign())
            ->collect([
                ...$this->request->all(),
                'cover_image' => $this->request->getRequest()->files->get('cover_image')
            ]);
    }
}