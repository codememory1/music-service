<?php

namespace App\Rest\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Request
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class Request
{

	/**
	 * @var SymfonyRequest
	 */
	public readonly SymfonyRequest $request;

	/**
	 * @param RequestStack $requestStack
	 */
	public function __construct(RequestStack $requestStack)
	{

		$this->request = $requestStack->getCurrentRequest();

	}

	/**
	 * @param string $key
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public function get(string $key, mixed $default = ''): mixed
	{

		return $this->all()[$key] ?? $default;

	}

	/**
	 * @return array
	 */
	public function all(): array
	{

		if ($this->request->isXmlHttpRequest()) {
			return $this->request->toArray();
		}

		return $this->request->request->all();

	}

}