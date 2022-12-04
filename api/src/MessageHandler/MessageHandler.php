<?php

namespace App\MessageHandler;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Message\TranslationMessage;
use App\Repository\LanguageRepository;
use App\Service\Deepl\Translator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final class MessageHandler
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly Translator $translator,
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

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function createTranslation(TranslationKey $translationKey, Language $language): void
    {
        $translation = new Translation();

        $translation->setLanguage($language);
        $translation->setTranslationKey($translationKey);
        $translation->setTranslation($this->translator->getTranslation());

        $this->em->persist($translation);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
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