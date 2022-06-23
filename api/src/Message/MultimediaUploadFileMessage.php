<?php

namespace App\Message;

/**
 * Class MultimediaUploadFileMessage.
 *
 * @package App\Message
 *
 * @author  Codememory
 */
class MultimediaUploadFileMessage
{
    /**
     * @var int
     */
    public readonly int $multimediaId;

    /**
     * @var array
     */
    private array $files = [];

    /**
     * @param int $multimediaId
     */
    public function __construct(int $multimediaId)
    {
        $this->multimediaId = $multimediaId;
    }

    /**
     * @param null|string $path
     * @param null|string $mimeType
     *
     * @return $this
     */
    public function setMultimediaFile(?string $path, ?string $mimeType): self
    {
        return $this->setFile('multimedia', $path, $mimeType);
    }

    /**
     * @param null|string $path
     * @param null|string $mimeType
     *
     * @return $this
     */
    public function setSubtitlesFile(?string $path, ?string $mimeType): self
    {
        return $this->setFile('subtitles', $path, $mimeType);
    }

    /**
     * @param null|string $path
     * @param null|string $mimeType
     *
     * @return $this
     */
    public function setImage(?string $path, ?string $mimeType): self
    {
        return $this->setFile('image', $path, $mimeType);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function getFile(string $name): array
    {
        return $this->files[$name] ?? [];
    }

    /**
     * @param string      $name
     * @param null|string $path
     * @param null|string $mimeType
     * @param array       $args
     *
     * @return $this
     */
    public function setFile(string $name, ?string $path, ?string $mimeType, array $args = []): self
    {
        if (false === empty($path) && false === empty($mimeType)) {
            $this->files[$name] = [
                'path' => base64_encode(file_get_contents($path)),
                'mimeType' => $mimeType,
                ...$args
            ];
        }

        return $this;
    }
}