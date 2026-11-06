<?php
/** Default fallback template. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content" class="content-shell">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="entry-content"><?php the_content(); ?></div>
			</article>
		<?php endwhile; ?>
		<nav class="pagination" aria-label="<?php esc_attr_e( 'Posts', 'myportfolio' ); ?>">
			<?php the_posts_pagination(); ?>
		</nav>
	<?php else : ?>
		<article>
			<h1><?php esc_html_e( 'Nothing here yet', 'myportfolio' ); ?></h1>
			<p><?php esc_html_e( 'Add a page or post in WordPress to get started.', 'myportfolio' ); ?></p>
		</article>
	<?php endif; ?>
</main>
<?php
get_footer();
