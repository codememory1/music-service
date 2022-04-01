<?php

namespace App\DTO;

use App\Entity\AlbumCategory;
use App\Entity\TranslationKey;
use App\Enum\ApiResponseTypeEnum;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AlbumCategoryDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumCategoryDTO extends AbstractDTO
{

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

		$this->setEntity(AlbumCategory::class);

		$this->addExpectedRequestKey('title', 'title_translation_key');

	}

}