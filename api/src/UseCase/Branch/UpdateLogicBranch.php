<?php

namespace App\UseCase\Branch;

use App\Dto\Transfer\LogicBranchDto;
use App\Entity\LogicBranch;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateLogicBranch
{
    public function __construct(
        private readonly Validator $validator,
        private readonly Flusher $flusher
    ) {
    }

    public function process(LogicBranchDto $dto): LogicBranch
    {
        $this->validator->validate($dto);

        $logicBranch = $dto->getEntity();

        $this->flusher->save($logicBranch);

        return $logicBranch;
    }
}