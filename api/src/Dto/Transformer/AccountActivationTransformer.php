<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\AccountActivationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * @template-extends AbstractDataTransformer<AccountActivationDto>
 */
final class AccountActivationTransformer extends AbstractDataTransformer
{
    private AccountActivationDto $accountActivationDto;

    #[Pure]
    public function __construct(Request $request, AccountActivationDto $accountActivationDto)
    {
        parent::__construct($request);

        $this->accountActivationDto = $accountActivationDto;
    }

    public function transformFromRequest(?EntityInterface $entity = null): DataTransferInterface
    {
        return $this->baseTransformFromRequest($this->accountActivationDto, $entity);
    }
}