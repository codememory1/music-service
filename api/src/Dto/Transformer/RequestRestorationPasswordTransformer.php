<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\RequestRestorationPasswordDto;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PasswordReset;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class RequestRestorationPasswordTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<RequestRestorationPasswordDto>
 *
 * @author  Codememory
 */
final class RequestRestorationPasswordTransformer extends AbstractDataTransformer
{
    private RequestRestorationPasswordDto $requestRestorationPasswordDto;

    #[Pure]
    public function __construct(Request $request, RequestRestorationPasswordDto $requestRestorationPasswordDto)
    {
        parent::__construct($request);

        $this->requestRestorationPasswordDto = $requestRestorationPasswordDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->requestRestorationPasswordDto
            ->setEntity($entity ?: new PasswordReset())
            ->collect($this->request->all());
    }
}