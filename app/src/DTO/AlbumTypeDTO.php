<?php

namespace App\DTO;

use App\Entity\AlbumType;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumTypeDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumTypeDTO extends AbstractDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'subscriptionPermissionName@keyIsRequired')]
	#[Assert\Length(
		max: 255,
		maxMessage: 'subscriptionPermissionName@keyMaxLength'
	)]
	public ?string $key = null;

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'common@titleIsRequired')]
	#[Assert\Length(
		max: 255,
		maxMessage: 'common@titleTranslationKeyMaxLength'
	)]
	#[AppAssert\Exist(
		TranslationKey::class,
		'name',
		'common@titleTranslationKeyNotExist',
		payload: ApiResponseTypeEnum::CHECK_EXIST
	)]
	public ?string $titleTranslationKey = null;

	/**
	 * @return void
	 */
	protected function wrapper(): void
	{

		$this->setEntity(AlbumType::class);

		$this
			->addExpectedRequestKey('key')
			->addExpectedRequestKey('title', 'title_translation_key');

	}

}