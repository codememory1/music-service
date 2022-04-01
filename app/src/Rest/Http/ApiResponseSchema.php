<?php

namespace App\Rest\Http;

use App\Enum\ApiResponseTypeEnum;
use App\Interfaces\ApiResponseSchemaInterface;
use App\Interfaces\ResponseSchemaInterface;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ApiResponseSchema
 *
 * @package App\Rest\Http
 *
 * @author  Codememory
 */
class ApiResponseSchema implements ApiResponseSchemaInterface, ResponseSchemaInterface
{

	/**
	 * @var array
	 */
	private array $schema = [
		'message' => [
			'type' => null,
			'text' => null
		],
		'data'    => []
	];

	/**
	 * @var array
	 */
	private array $message = [
		'type' => null,
		'text' => null
	];

	/**
	 * @var array
	 */
	private array $data = [];

	/**
	 * @inheritDoc
	 */
	public function setMessage(ApiResponseTypeEnum $type, string $text): ApiResponseSchemaInterface
	{

		$this->message = [
			'type' => $type->value,
			'text' => $text
		];

		return $this;

	}

	/**
	 * @inheritDoc
	 */
	public function setData(array $data): ApiResponseSchemaInterface
	{

		$this->data = $data;

		return $this;

	}

	/**
	 * @inheritDoc
	 */
	#[ArrayShape([
		'message' => "array",
		'data'    => "array"
	])]
	public function getSchema(): array
	{

		$this->schema['message']['type'] = $this->message['type'];
		$this->schema['message']['text'] = $this->message['text'];
		$this->schema['data'] = $this->data;

		return $this->schema;

	}

	/**
	 * @inheritDoc
	 */
	public function add(string $key, mixed $value, bool $unshift = false): ResponseSchemaInterface
	{

		if ($unshift) {
			$addedElement = [$key => $value];
			$this->schema = [
				...$addedElement,
				...$this->schema
			];
		} else {
			$this->schema[$key] = $value;
		}

		return $this;

	}

}