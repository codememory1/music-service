<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Rest\Http\Request;
use App\Service\TranslationService;

final class AsTranslationHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    public function __construct(
        private TranslationService $translationService,
        private Request $request
    ) {
    }

    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): ?string
    {
        if (null === $value) {
            return null;
        }

        $this->translationService->setLocale($this->request->getRequest()->getLocale());

        return $this->translationService->get($value);
    }
}