<?php

namespace App\Service\Translator;

use App\Entity\Language;
use App\Service\Translator\Interfaces\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class DeeplTranslator implements TranslatorInterface
{
    private array $httpOptions = [];
    private ?ResponseInterface $response = null;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $deeplTranslatePath,
        private readonly string $deeplAuthKey
    ) {
        $this->httpOptions['headers']['Authorization'] = "DeepL-Auth-Key {$this->deeplAuthKey}";
    }

    public function setLanguage(Language $language): self
    {
        $this->httpOptions['body']['target_lang'] = $language->getCode();

        return $this;
    }

    public function setText(string $text): self
    {
        $this->httpOptions['body']['text'] = $text;

        return $this;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(): void
    {
        $this->response = $this->client->request(Request::METHOD_POST, $this->deeplTranslatePath, $this->httpOptions);
    }

    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getTranslation(): string
    {
        if (200 === $this->response->getStatusCode()) {
            $data = json_decode($this->response->getContent(), true);

            if (array_key_exists('translations', $data)) {
                $firstTranslationKey = array_key_first($data['translations']);

                return $data['translations'][$firstTranslationKey]['text'];
            }

            return $this->httpOptions['body']['text'];
        }

        return $this->httpOptions['body']['text'];
    }
}