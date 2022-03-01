<?php
/**
 * PostLoop.
 *
 * @package MadeByAura\WP
 * @author  MadeByAura.com
 */

namespace MadeByAura\WP;

defined( 'ABSPATH' ) || die();

/**
 * PostLoop.
 */
class PostLoop {
	/**
	 * Arguments.
	 *
	 * @access protected
	 * @var array
	 */
	protected $args = [];

	/**
	 * HTML attributes.
	 *
	 * @access protected
	 * @var array
	 */
	protected $attrs = [];

	/**
	 * Query.
	 *
	 * @access protected
	 * @var WP_Query
	 */
	protected $query = [];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @param  array $args  Arguments.
	 */
	public function __construct( $args ) {
		$this->args = array_replace_recursive( [
			'id'                 => '',
			'layout'             => 'post-list',
			'layout_args'        => [],
			'pagination'         => true,
			'pagination_slug'    => 'pagination',
			'pagination_args'    => [],
			'nothing_found'      => true,
			'nothing_found_slug' => 'nothing-found',
			'class'              => '',
			'attrs'              => [],
			'query_args'         => [
				'post_type' => 'post',
			],
		], $args );

		$this->set_attrs();
		$this->set_query();
	}

	/**
	 * Set HTML attributes.
	 *
	 * @access protected
	 */
	public function set_attrs() {
		$this->attrs = $this->args['attrs'];

		// Classes.
		$classes[] = $this->args['class'] ? $this->args['class'] : '';
		$classes[] = 'aura-posts';
		$classes[] = $this->args['layout'] ? "aura-posts--{$this->args['layout']}" : '';

		// Merge implicit classes with explicit classes.
		if ( ! empty( $this->attrs['class'] ) ) {
			$classes = Markup::merge_classes( $classes, $this->attrs['class'] );
		}

		$this->attrs['class'] = $classes;
	}

	/**
	 * Set query.
	 *
	 * @access protected
	 */
	protected function set_query() {
		$this->query = new \WP_Query( $this->args['query_args'] );
	}

	/**
	 * Have posts.
	 *
	 * @access public
	 * @return bool
	 */
	public function have_posts() {
		return $this->query->have_posts();
	}

	/**
	 * Render posts.
	 *
	 * @access public
	 */
	public function render_posts() {
		if ( ! $this->query->have_posts() ) :
		?>

			<div <?php Markup::echo_attrs( $this->attrs ); ?>>
				<?php while ( $this->query->have_posts() ) : ?>
					<?php $this->query->the_post(); ?>
					<?php Theme::get_template_part( "post-layouts/{$this->args['layout']}", $this->args['layout_args'] ); ?>
				<?php endwhile; ?>
			</div><!-- aura-posts -->

			<?php if ( true === $this->args['pagination'] ) : ?>
				<?php Theme::get_template_part( $this->args['pagination_slug'], $this->args['pagination_args'] ); ?>
			<?php endif; ?>

		<?php else : ?>

			<?php if ( true === $this->args['nothing_found'] ) : ?>
				<?php Theme::get_template_part( $this->args['nothing_found_slug'] ); ?>
			<?php endif; ?>

		<?php
		endif;

		// After looping through a custom query, this function restores the $post
		// global to the current post in the main query.
		wp_reset_postdata();
	}
}
