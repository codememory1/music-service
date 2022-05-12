<?php

namespace App\EventListener;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Repository\TranslationRepository;
use App\Rest\Http\Exceptions\ApiResponseException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

/**
 * Class ApiExceptionListener
 *
 * @package App\EventListener
 *
 * @author  Codememory
 */
class ApiExceptionListener
{
    /**
     * @var Request|null
     */
    private ?Request $request;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param RequestStack          $requestStack
     * @param TranslationRepository $translationRepository
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $entityManager;
    }

    /**
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof ApiResponseException) {
            $jsonResponse = new JsonResponse(
                [$this->getTranslation($throwable)?->getTranslation()],
                $throwable->statusCode,
                $throwable->headers
            );

            $jsonResponse->send();
        }
    }

    /**
     * @param ApiResponseException<Throwable> $throwable
     *
     * @return Translation|null
     */
    private function getTranslation(Throwable $throwable): ?Translation
    {
        $languageRepository = $this->em->getRepository(Language::class);
        $translationKeyRepository = $this->em->getRepository(TranslationKey::class);
        $translationRepository = $this->em->getRepository(Translation::class);

        return $translationRepository->findOneBy([
            'language' => $languageRepository->findOneBy(['code' => $this->request->getLocale()]),
            'translationKey' => $translationKeyRepository->findOneBy(['key' => $throwable->translationKey])
        ]);
    }
}