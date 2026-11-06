<?php
/** Site header. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'myportfolio' ); ?></a>
<header class="site-header">
	<div class="site-header__inner">
		<a class="site-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' — ' . __( 'home', 'myportfolio' ) ); ?>">
			<span class="site-brand__mark" aria-hidden="true">4</span>
			<span class="site-brand__name"><?php bloginfo( 'name' ); ?></span>
		</a>
		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">
			<span class="nav-toggle__label"><?php esc_html_e( 'Menu', 'myportfolio' ); ?></span>
		</button>
		<nav class="site-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'myportfolio' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'site-nav__list',
					'fallback_cb'    => 'myportfolio_primary_menu_fallback',
				)
			);
			?>
		</nav>
	</div>
</header>
