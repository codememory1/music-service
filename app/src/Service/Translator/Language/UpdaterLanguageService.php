<?php

namespace App\Service\Translator\Language;

use App\DTO\LanguageDTO;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterLanguageService
 *
 * @package App\Service\Translator\Language
 *
 * @author  Codememory
 */
class UpdaterLanguageService extends UpdaterCRUD
{

	/**
	 * @param LanguageDTO $languageDTO
	 * @param int         $id
	 *
	 * @return Response
	 */
	public function update(LanguageDTO $languageDTO, int $id): Response
	{

		$this->validateEntity = true;
		$this->translationKeyNotExist = 'lang@langNotExist';

		$updatedEntity = $this->make($languageDTO, ['id' => $id]);

		if ($updatedEntity instanceof Response) {
			return $updatedEntity;
		}

		return $this->manager->update($updatedEntity, 'lang@successUpdate');

	}

}