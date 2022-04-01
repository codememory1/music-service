<?php

namespace App\Security;

use App\Rest\Translator;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AbstractSecurity
 *
 * @package App\Security
 *
 * @author  Codememory
 */
class AbstractSecurity
{

	/**
	 * @var ManagerRegistry
	 */
	protected readonly ManagerRegistry $managerRegistry;

	/**
	 * @var ObjectManager
	 */
	protected readonly ObjectManager $em;

	/**
	 * @var Translator
	 */
	protected readonly Translator $translator;

	/**
	 * @param ManagerRegistry $managerRegistry
	 * @param Translator      $translator
	 */
	public function __construct(ManagerRegistry $managerRegistry, Translator $translator)
	{

		$this->managerRegistry = $managerRegistry;
		$this->em = $managerRegistry->getManager();
		$this->translator = $translator;

	}

}