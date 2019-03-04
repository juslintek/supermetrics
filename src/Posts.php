<?php
/**
 * Created by PhpStorm.
 * User: Juslintek
 * Date: 2019-03-04
 * Time: 00:50
 */

namespace Juslintek\Supermetrics;


class Posts {
	/**
	 * @var mixed|null
	 */
	public $sl_token = null;

	/**
	 * Posts constructor.
	 */
	public function __construct() {
		if ( $this->sl_token === null ) {
			$this->sl_token = ( new Register() )->getToken();
		}
	}

	/**
	 * @param int $page
	 */
	public function getPage( int $page ) {
		$postsJson = Connector::get( Config::get( 'POSTS_ENDPOINT' ), [
			'sl_token' => $this->sl_token,
			'page'     => $page
		] );

		$postsData = (\GuzzleHttp\json_decode($postsJson))->data;

		$posts = $postsData->posts;

		return Template::render( 'posts', [
			'page_links' => ( function () {
				$html = '';
				$link_base = ( isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . '/?page=';
				foreach ( range( 1, 10 ) as $page ) {
					$html .= Template::render( 'parts/page_link', [
						'link'   => $link_base . $page,
						'number' => $page
					] );
				}

				return $html;
			} )(),
			'posts_grid' => (function($posts) {
				$html = '';
				foreach ($posts as $post) {
					$html .= Template::render( 'parts/post_grid_item', [
						'post_content'   => print_r($post, true)
					] );
				}
				return $html;
			})($posts)
		] );
	}
}
