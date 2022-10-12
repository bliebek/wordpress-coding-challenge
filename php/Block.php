<?php
/**
 * Block class.
 *
 * @package SiteCounts
 */

namespace XWP\SiteCounts;

use WP_Block;
use WP_Query;

/**
 * The Site Counts dynamic block.
 *
 * Registers and renders the dynamic block.
 */
class Block {

	/**
	 * The Plugin instance.
	 *
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * Instantiates the class.
	 *
	 * @param Plugin $plugin The plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Adds the action to register the block.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', [ $this, 'register_block' ] );
	}

	/**
	 * Registers the block.
	 */
	public function register_block() {
		register_block_type_from_metadata(
			$this->plugin->dir(),
			[
				'render_callback' => [ $this, 'render_callback' ],
			]
		);
	}

	/**
	 * Renders the block.
	 *
	 * @param array    $attributes The attributes for the block.
	 * @param string   $content    The block content, if any.
	 * @param WP_Block $block      The instance of this block.
	 * @return string The markup of the block.
	 */
	public function render_callback( $attributes, $content, $block ) {
		$post_id     = get_the_ID();
		$post_types  = get_post_types( [ 'public' => true ], 'objects' );
		$class_name  = isset( $attributes['className'] ) ? $attributes['className'] : '';
		$post_counts = [];
		foreach ( $post_types as $post_type ) {
			$post_counts[ $post_type->labels->name ] = wp_count_posts( $post_type->name );
		}

		$foo_baz_posts = new WP_Query(
			[
				'post_type'     => [ 'post', 'page' ],
				'post_status'   => 'any',
				'date_query'    => [
					[
						'hour'    => 9,
						'compare' => '>=',
					],
					[
						'hour'    => 17,
						'compare' => '<=',
					],
				],
				'tag'           => 'foo',
				'category_name' => 'baz',
				'post__not_in'  => [ $post_id ],
				'postperpage'   => 5,
			]
		);

		ob_start();
		require $this->plugin->dir() . '/template.php';
		return ob_get_clean();
	}
}
