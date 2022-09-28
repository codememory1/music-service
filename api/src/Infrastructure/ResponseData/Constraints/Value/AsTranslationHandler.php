<?php

namespace App\Infrastructure\ResponseData\Constraints\Value;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintValueHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ResponseDataInterface;
use App\Rest\Http\Request;
use App\Service\TranslationService;
use Symfony\Contracts\Service\Attribute\Required;

final class AsTranslationHandler extends AbstractConstraintHandler implements ConstraintValueHandlerInterface
{
    #[Required]
    public ?TranslationService $translationService = null;

    #[Required]
    public ?Request $request = null;

    public function handle(ConstraintInterface $constraint, ResponseDataInterface $responseData, mixed $value): ?string
    {
        if (null === $value) {
            return null;
        }

        $this->translationService->setLocale($this->request->getRequest()->getLocale());

        return $this->translationService->get($value);
    }
}