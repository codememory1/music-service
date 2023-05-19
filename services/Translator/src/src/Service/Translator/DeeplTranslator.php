<?php

namespace App\Service\Translator;

use App\Entity\Language;
use App\Interfaces\TranslatorInterface;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class DeeplTranslator implements TranslatorInterface
{
    private ?Language $fromLanguage = null;
    private ?Language $toLanguage = null;
    private ?string $text = null;

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $host,
        private readonly int $version,
        private readonly string $authKey
    ) {
    }

    public function setFromLanguage(Language $language): TranslatorInterface
    {
        $this->fromLanguage = $language;

        return $this;
    }

    public function setToLanguage(Language $language): TranslatorInterface
    {
        $this->toLanguage = $language;

        return $this;
    }

    public function setText(string $text): TranslatorInterface
    {
        $this->text = $text;

        return $this;
    }

    public function translate(): ?string
    {
        if (null === $this->toLanguage) {
            throw new LogicException('The language into which you want to translate the text is required');
        }

        if (null === $this->text) {
            throw new LogicException('Required text to be translated');
        }

        try {
            $this->client->request(Request::METHOD_POST, $this->buildURL(), [
                'headers' => [
                    'Authorization' => "DeepL-Auth-Key $this->authKey"
                ],
                'json' => $this->buildFormData()
            ]);
        } catch (Throwable) {
            return null;
        }
    }

    private function buildURL(): string
    {
        return trim($this->host, '/')."/v{$this->version}/translate";
    }

    private function buildFormData(): array
    {
        $data = [
            'text' => $this->text
        ];

        if (null !== $this->fromLanguage) {
            $data['target_lang'] = $this->fromLanguage->getCode()
        }

        return $data;
    }
}