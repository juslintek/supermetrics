<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 00:53
 */

namespace Juslintek\Supermetrics;


class App {
	public function __invoke() {
		$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

		if (is_null($page)) {
			$page = 1;
		}

		echo (new Posts())->getPage($page);
	}
}
