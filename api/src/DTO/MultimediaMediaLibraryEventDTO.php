<?php

namespace App\DTO;

use App\DTO\Interceptors\AsArrayInterceptor;
use App\DTO\Interceptors\AsEnumInterceptor;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Enum\MultimediaMediaLibraryEventEnum;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class MultimediaMediaLibraryEventDTO.
 *
 * @package App\DTO
 * @template-extends AbstractDTO<MultimediaMediaLibraryEvent>
 *
 * @author  Codememory
 */
class MultimediaMediaLibraryEventDTO extends AbstractDTO
{
    protected EntityInterface|string|null $entity = MultimediaMediaLibraryEvent::class;

    #[Assert\NotBlank(message: 'event@keyIsRequired')]
    public ?MultimediaMediaLibraryEventEnum $key = null;
    public array $payload = [];

    protected function wrapper(): void
    {
        $this->addExpectKey('key');
        $this->addExpectKey('payload');

        $this->addInterceptor('key', new AsEnumInterceptor(MultimediaMediaLibraryEventEnum::class));
        $this->addInterceptor('payload', new AsArrayInterceptor());
    }

    #[Assert\Callback]
    public function callbackPayload(ExecutionContextInterface $context): void
    {
        if (null !== $this->key) {
            $context
                ->getValidator()
                ->inContext($context)
                ->atPath('payload')
                ->validate($this->payload, new AppAssert\JsonSchema($this->key->value, 'event@invalidPayload'));
        }
    }
}