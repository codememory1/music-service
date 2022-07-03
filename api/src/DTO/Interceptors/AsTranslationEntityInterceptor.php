<?php

namespace App\DTO\Interceptors;

use App\DTO\Interfaces\ValueInterceptorInterface;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Rest\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

/**
 * Class AsTranslationEntityInterceptor.
 *
 * @package App\DTO\Interceptors
 *
 * @author  Codememory
 */
final class AsTranslationEntityInterceptor implements ValueInterceptorInterface
{
    private EntityManagerInterface $em;
    private string $locale;

    #[Pure]
    public function __construct(EntityManagerInterface $manager, Request $request)
    {
        $this->em = $manager;
        $this->locale = $request->request->getLocale();
    }

    /**
     * @inheritDoc
     */
    public function handle(string $key, mixed $value): ?Translation
    {
        $languageRepository = $this->em->getRepository(Language::class);
        $translationKeyRepository = $this->em->getRepository(TranslationKey::class);
        $translationRepository = $this->em->getRepository(Translation::class);

        return $translationRepository->findOneBy([
            'language' => $languageRepository->findOneBy(['code' => $this->locale]),
            'translationKey' => $translationKeyRepository->findOneBy(['key' => $value])
        ]);
    }
}