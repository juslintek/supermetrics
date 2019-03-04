<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 01:37
 */

namespace Juslintek\Supermetrics;


use GuzzleHttp\Client;

class Connector {
	private static $_instance = null;
	private static $_client = null;
	private static $_response = [];

	private function __construct() {
		self::$_client = new Client();
	}

	/**
	 * @return Connector
	 */
	private static function instance() {
		if (self::$_instance === null) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Adds run time cache to prevent repeated requests
	 * @param $method
	 * @param $path
	 * @param $params
	 * @param $response
	 */
	private static function cacheResponse($method, $path, $params, $response) {
		self::$_response[md5($method . $path . serialize($params))] = $response;
	}

	/**
	 * @param $method
	 * @param $path
	 * @param $params
	 *
	 * @return bool|mixed
	 */
	private static function getResponse($method, $path, $params) {
		$key = md5($method . $path . serialize($params));
		return isset(self::$_response[$key]) ? self::$_response[$key] : false;
	}

	/**
	 * @param $path
	 * @param $params
	 *
	 * @return bool|mixed|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface
	 */
	public static function get($path, $params) {
		$connector = Connector::instance();
		$client = $connector::$_client;
		$response = self::getResponse(INPUT_GET, $path, $params);
		if (!$response) {
			$response = $client->get( $path, [ 'query' => $params ] );
			$body = $response->getBody()->getContents();
			if ($response->getStatusCode() === 200) {
				self::cacheResponse(INPUT_GET, $path, $params, $response->getBody());
			}
			return $body;
		}

		return $response;
	}

	/**
	 * @param $path
	 * @param $params
	 *
	 * @return bool|mixed|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface
	 */
	public static function post($path, $params) {
		$connector = Connector::instance();
		$client    = $connector::$_client;
		$response  = self::getResponse( INPUT_POST, $path, $params );
		if ( ! $response ) {
			$response = $client->post( $path, [ 'form_params' => $params ] );
			$body     = $response->getBody();
			if ( $response->getStatusCode() === 200 ) {
				self::cacheResponse( INPUT_POST, $path, $params, $response->getBody() );
			}

			return $body;
		}

		return $response;
	}
}

