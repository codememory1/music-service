<?php

namespace App\DTO;

use App\Entity\User;
use App\Rest\Http\Request;

/**
 * Class UserDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<User>
 *
 * @author  Codememory
 */
class UserDTO extends AbstractDTO
{
    /**
     * @var null|string
     */
    public ?string $ip = null;

    public function __construct(Request $request, SetterCallRuleInEntity $setterCallRuleInEntity)
    {
        parent::__construct($request, $setterCallRuleInEntity);

        $this->ip = $this->request->request->getClientIp();
    }

    /**
     * @inheritDoc
     */
    protected function wrapper(): void
    {
    }
}