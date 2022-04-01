<?php

namespace App\Service\Translator\Translation;

use App\DTO\TranslationDTO;
use App\Rest\CRUD\UpdaterCRUD;
use App\Rest\Http\Response;

/**
 * Class UpdaterTranslationService
 *
 * @package App\Service\Translator\Translation
 *
 * @author  Codememory
 */
class UpdaterTranslationService extends UpdaterCRUD
{

	/**
	 * @param TranslationDTO $translationDTO
	 * @param int            $id
	 *
	 * @return Response
	 */
	public function update(TranslationDTO $translationDTO, int $id): Response
	{

		$this->validateEntity = true;
		$this->translationKeyNotExist = 'translation@notExist';

		$updatedEntity = $this->make($translationDTO, ['id' => $id]);

		if ($updatedEntity instanceof Response) {
			return $updatedEntity;
		}

		return $this->manager->update($updatedEntity, 'translation@successUpdate');

	}

}