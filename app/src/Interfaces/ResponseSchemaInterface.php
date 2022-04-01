<?php

namespace App\Interfaces;

/**
 * Interfaces ResponseSchemaInterface
 *
 * @package App\Interfaces
 *
 * @author  Codememory
 */
interface ResponseSchemaInterface
{

    /**
     * @return array
     */
    public function getSchema(): array;

	/**
	 * @param string $key
	 * @param mixed  $value
	 * @param bool   $unshift
	 *
	 * @return ResponseSchemaInterface
	 */
	public function add(string $key, mixed $value, bool $unshift = false): ResponseSchemaInterface;

}