<?php

namespace App\Constraints\DTO;

use Codememory\Dto\DataTransferControl;
use Codememory\Dto\Interfaces\ConstraintHandlerInterface;
use Codememory\Dto\Interfaces\ConstraintInterface;
use Codememory\Dto\Interfaces\DataTransferInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class DtoMapperHandler implements ConstraintHandlerInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    ) {
    }

    /**
     * @param DtoMapper $constraint
     */
    public function handle(ConstraintInterface $constraint, DataTransferControl $dataTransferControl): void
    {
        $values = [];

        foreach ($dataTransferControl->getDataTransferValue() as $item) {
            if (is_array($item) && array_key_exists($constraint->byKey, $item) && array_key_exists($item[$constraint->byKey], $constraint->map)) {
                /** @var DataTransferInterface $dto */
                $dto = $this->container->get($constraint->map[$item[$constraint->byKey]]);

                $dataTransferControl->dataTransfer->addDataTransferCollection(
                    $dto::class,
                    $dto->getListDataTransferCollection()
                );

                $values[] = $dto->collect($item);
            }
        }
        
        $dataTransferControl->setValue($values);
    }
}