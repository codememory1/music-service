<?php

namespace App\DTO;

use App\Entity\TranslationKey;
use App\Rest\DTO\AbstractDTO;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TranslationKeyDTO
 *
 * @package App\Dto
 *
 * @author  Codememory
 */
class TranslationKeyDTO extends AbstractDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'translationKey@nameIsRequired')]
	#[Assert\Length(max: 255, maxMessage: 'translationKey@nameMaxLength')]
	public ?string $name = null;

	/**
	 * @inheritDoc
	 */
	protected function wrapper(): void
	{

		$this->setEntity(TranslationKey::class);

		$this->addExpectedRequestKey('name');

	}

}