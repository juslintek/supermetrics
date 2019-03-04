<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 01:00
 */

namespace Juslintek\Supermetrics;


class Register {
	private $token = null;

	/**
	 * @return bool|mixed|\Psr\Http\Message\ResponseInterface|\Psr\Http\Message\StreamInterface
	 */
	private function fetchToken() {
		return Connector::post( Config::get( 'TOKEN_ENDPOINT' ), [
			'client_id' => Config::get( 'CLIENT_ID' ),
			'email'     => Config::get( 'EMAIL' ),
			'name'      => Config::get( 'NAME' ),
		] );
	}

	/**
	 * Register constructor.
	 */
	public function __construct() {
		$this->token = TokenHandler::read();
		if ( $this->token === null ) {
			$this->token = \GuzzleHttp\json_decode($this->fetchToken(), true);
			$this->token['created'] = time();
			TokenHandler::save($this->token);
		}
	}

	/**
	 * @return bool
	 */
	private function isTokenExpired() {
		return time() - $this->token['created'] >= 3600;
	}


	/**
	 * @return mixed
	 */
	public function getToken() {
		if ($this->isTokenExpired()) {
			$tokenData = \GuzzleHttp\json_decode($this->fetchToken(), true);
			$tokenData['created'] = time();
			$this->token = $tokenData;
			TokenHandler::save($tokenData);
		}

		return $this->token['data']['sl_token'];
	}
}
