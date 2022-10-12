<?php
/**
 * A default template for the site-counts block
 *
 * @package @xwp/site-counts
 */

?>
<div class="<?php echo esc_attr( $class_name ); ?>">
	<h2><?php echo esc_html__( 'Post Counts', 'site-counts' ); ?></h2>
	<ul>
		<?php foreach ( $post_counts as $post_name => $post_count_object ) : ?>
			<?php /* translators: %1$d - no of found object instances, %2$s - object type */ ?>
			<li><?php echo sprintf( esc_html__( 'There are %1$d %2$s.', 'site-counts' ), esc_html( $post_count_object->publish ), esc_html( $post_name ) ); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php /* translators: %d - current post id */ ?>
	<p><?php echo sprintf( esc_html__( 'The current post ID is %d.', 'site-counts' ), esc_html( $post_id ) ); ?></p>
	<?php if ( $foo_baz_posts->have_posts() ) : ?>
		<h2><?php echo esc_html__( '5 posts with the tag of foo and the category of baz', 'site-counts' ); ?></h2>
		<ul>
			<?php foreach ( $foo_baz_posts->posts as $post_item ) : ?>
				<li><?php echo esc_html( $post_item->post_title ); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
