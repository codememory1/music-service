<?php

namespace App\DTO;

use App\DTO\Interceptor\AlbumInputCategoryInterceptor;
use App\DTO\Interceptor\AlbumInputTagsInterceptor;
use App\DTO\Interceptor\AlbumInputTypeInterceptor;
use App\Entity\Album;
use App\Entity\AlbumCategory;
use App\Entity\AlbumType;
use App\Rest\DTO\AbstractDTO;
use App\Validator\Constraints as AppAssert;
use ReflectionException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

/**
 * Class AlbumDTO
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class AlbumDTO extends AbstractDTO
{

	/**
	 * @var string|null
	 */
	#[Assert\NotBlank(message: 'album@titleIsRequired')]
	#[Assert\Length(max: 255, maxMessage: 'album@titleMaxLength')]
	public ?string $title = null;

	/**
	 * @var AlbumType|null
	 */
	#[Assert\NotBlank(
		message: 'album@typeNotExistOrNotEntered',
		payload: 'type_not_exist_or_not_entered'
	)]
	public ?AlbumType $type = null;

	/**
	 * @var AlbumCategory|null
	 */
	#[Assert\NotBlank(
		message: 'album@categoryNotExistOrNotEntered',
		payload: 'category_not_exist_or_not_entered'
	)]
	public ?AlbumCategory $category = null;

	/**
	 * @var File|null
	 */
	#[Assert\NotBlank(message: 'album@photoIsRequired')]
	#[Assert\File(
		maxSize: '1024k',
		mimeTypes: ['image/png', 'image/jpg', 'image/jpeg'],
		maxSizeMessage: 'album@photoMaxSize',
		mimeTypesMessage: 'album@photoMimeTypes'
	)]
	public ?File $photo = null;

	/**
	 * @var array
	 */
	#[Assert\NotBlank(message: 'album@tagsIsRequired')]
	#[AppAssert\QuantityByDelimiter(
		',',
		max: 255,
		maxMessage: 'album@maxTags',
		payload: 'number_of_tags'
	)]
	public array $tags = [];

	/**
	 * @return void
	 * @throws ReflectionException
	 * @throws ClassNotFoundException
	 */
	protected function wrapper(): void
	{

		$this->setEntity(Album::class);

		$this
			->addExpectedRequestKey('title')
			->addExpectedRequestKey('type')
			->addExpectedRequestKey('category')
			->addExpectedRequestKey('tags');

		$this
			->addInterceptor('type', AlbumInputTypeInterceptor::class)
			->addInterceptor('category', AlbumInputCategoryInterceptor::class)
			->addInterceptor('tags', AlbumInputTagsInterceptor::class);

		$this->photo = $this->request->request->files->get('photo');

	}

}