<?php

namespace App\Service\Translator\TranslationKey;

use App\Entity\TranslationKey;
use App\Rest\CRUD\DeleterCRUD;
use App\Rest\Http\Response;
use Exception;

/**
 * Class DeleterTranslationKeyService
 *
 * @package App\Service\Translator\TranslationKey
 *
 * @author  Codememory
 */
class DeleterTranslationKeyService extends DeleterCRUD
{

	/**
	 * @param int $id
	 *
	 * @return Response
	 * @throws Exception
	 */
	public function delete(int $id): Response
	{

		$this->translationKeyNotExist = 'translationKey@notExist';

		$deletedEntity = $this->make(TranslationKey::class, ['id' => $id]);

		if ($deletedEntity instanceof Response) {
			return $deletedEntity;
		}

		return $this->manager->remove($deletedEntity, 'translationKey@successDelete');

	}

}