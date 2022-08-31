<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\UserDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<UserDto>
 */
final class UserTransformer extends AbstractDataTransformer
{
    private UserDto $userDto;

    #[Pure]
    public function __construct(Request $request, UserDto $userDto)
    {
        parent::__construct($request);

        $this->userDto = $userDto;
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