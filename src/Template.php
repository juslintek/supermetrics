<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 03:11
 */

namespace Juslintek\Supermetrics;


class Template {
	private static $templatePath = __DIR__ . '/templates/';

	public static function render($template, $args) {
		$html = file_get_contents(self::$templatePath . $template . '.html');

		foreach ($args as $placeholder => $value) {
			$html = str_replace('[' . $placeholder . ']', $value, $html);
		}

		return $html;
	}
}
