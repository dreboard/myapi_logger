<?php
namespace MyApiCore\System;

/**
 * Interface ILogger
 * @package MyApiCore\System
 */
interface ILogger
{
	/**
	 * Log data
	 *
	 * @param string $text
	 * @return mixed
	 */
	public function log(string $text);
}