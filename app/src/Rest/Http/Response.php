<?php

namespace App\Rest\Http;

use App\Interfaces\ResponseSchemaInterface;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Response
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class Response
{

	/**
	 * @var ResponseSchemaInterface
	 */
	private ResponseSchemaInterface $responseSchema;

	/**
	 * @var string
	 */
	private string $status;

	/**
	 * @var int
	 */
	private int $code;

	/**
	 * @param ResponseSchemaInterface $responseSchema
	 * @param string                  $status
	 * @param int                     $code
	 */
	public function __construct(ResponseSchemaInterface $responseSchema, string $status, int $code)
	{

		$this->responseSchema = $responseSchema;
		$this->status = $status;
		$this->code = $code;
		$this->responseSchema->add('code', $this->code, true);
		$this->responseSchema->add('status', $this->status, true);

	}

	/**
	 * @param array $headers
	 *
	 * @return void
	 */
	#[NoReturn]
	public function send(array $headers = []): void
	{

		exit($this->make($headers));

	}

	/**
	 * @param array $headers
	 *
	 * @return JsonResponse
	 */
	public function make(array $headers = []): JsonResponse
	{

		$schema = $this->responseSchema->getSchema();

		return (new JsonResponse($schema, $this->code, $headers))->send();

	}

}