<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 01:11
 */

namespace Juslintek\Supermetrics;

class TokenHandler {
	private static $token = ROOT . '/token.json';

	/**
	 * @return bool
	 */
	public static function delete() {
		return unlink(self::$token);
	}

	/**
	 * @return bool|mixed
	 */
	public static function read() {
		return file_exists(self::$token) ? json_decode(file_get_contents(self::$token), true) : null;
	}

	public static function save(array $data) {
		return file_put_contents(self::$token, json_encode($data)) !== false;
	}

	public static function update(array $data) {
		return self::delete() && self::save($data);
	}
}
