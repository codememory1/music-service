<?php

namespace App\MessageHandler;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Message\TranslationMessage;
use App\Repository\LanguageRepository;
use App\Service\Translator\Interfaces\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class MessageHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TranslatorInterface $translator,
        private readonly LanguageRepository $languageRepository
    ) {
    }

    private function createTranslationKey(TranslationMessage $message): TranslationKey
    {
        $translationKey = new TranslationKey();

        $translationKey->setKey($message->uuid);

        $this->em->persist($translationKey);

        return $translationKey;
    }

    private function createTranslation(TranslationKey $translationKey, Language $language): void
    {
        $translation = new Translation();

        $translation->setLanguage($language);
        $translation->setTranslationKey($translationKey);
        $translation->setTranslation($this->translator->getTranslation());

        $this->em->persist($translation);
    }

    public function __invoke(TranslationMessage $message): void
    {
        foreach ($this->languageRepository->findAll() as $language) {
            $this->translator->setLanguage($language);
            $this->translator->setText($message->text);
            $this->translator->send();

            $this->createTranslation($this->createTranslationKey($message), $language);
        }

        $this->em->flush();
    }
}