<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 00:50
 */

namespace Juslintek\Supermetrics;


class Config {
	/**
	 * @param $option
	 *
	 * @return array|false|string
	 */
	public static function get($option) {
		return getenv($option);
	}
}
