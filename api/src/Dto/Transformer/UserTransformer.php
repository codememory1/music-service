<?php

namespace App\Dto\Transformer;

use App\Infrastucture\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;
use App\Infrastucture\Dto\AbstractDataTransformer;

/**
 * @template-extends AbstractDataTransformer<UserDto>
 */
final class UserTransformer extends AbstractDataTransformer
{
    #[Pure]
    public function __construct(
        Request $request,
        private readonly UserDto $userDto
    ) {
        parent::__construct($request);
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->userDto->collect([
            'ip' => $this->request->getRequest()?->getClientIp()
        ]);
    }

    public function transformFromArray(array $data, ?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->userDto->collect($data);
    }
}