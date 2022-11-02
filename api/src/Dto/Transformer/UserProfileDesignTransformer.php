<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserProfileDesignDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\UserProfileDesign;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

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
            ->setEntity($entity ?: new UserProfileDesign())
            ->collect([
                ...$this->request->all(),
                'cover_image' => $this->request->getRequest()->files->get('cover_image')
            ]);
    }
}