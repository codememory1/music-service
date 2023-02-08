<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Rest\Http\Request;
use App\Service\Translation;

final class CallbackWithTranslationHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    public function __construct(
        private readonly Translation $translation,
        private readonly Request $request
    ) {
    }

    /**
     * @param CallbackWithTranslation $constraint
     */
    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): mixed
    {
        $this->translation->setLocale($this->request->getRequest()->getLocale());

        $class = null === $constraint->class ? $responseData : new ($constraint->class)();

        return $class->{$constraint->methodName}($this->entityIteration, $value, $this->translation);
    }
}