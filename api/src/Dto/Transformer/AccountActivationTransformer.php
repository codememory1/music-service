<?php

namespace App\Dto\Transformer;

use App\Dto\Interfaces\DataTransferInterface;
use App\Dto\Transfer\AccountActivationDto;
use App\Entity\Interfaces\EntityInterface;
use App\Rest\Http\Request;
use JetBrains\PhpStorm\Pure;

/**
 * Class AccountActivationTransformer.
 *
 * @package App\Dto\Transformer
 * @template-extends AbstractDataTransformer<AccountActivationDto>
 *
 * @author  Codememory
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
        return $this->accountActivationDto->collect($this->request->all());
    }
}