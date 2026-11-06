<?php
/**
 * Theme setup and editable team content.
 *
 * @package MyPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Set up theme features and menus. */
function myportfolio_theme_setup() {
	load_theme_textdomain( 'myportfolio', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'myportfolio' ),
		)
	);
}
add_action( 'after_setup_theme', 'myportfolio_theme_setup' );

/** Load theme assets. */
function myportfolio_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$theme_path    = get_template_directory();

	wp_enqueue_style(
		'myportfolio-style',
		get_stylesheet_uri(),
		array(),
		file_exists( $theme_path . '/style.css' ) ? (string) filemtime( $theme_path . '/style.css' ) : $theme_version
	);

	$script_path = $theme_path . '/assets/js/navigation.js';
	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'myportfolio-navigation',
			get_template_directory_uri() . '/assets/js/navigation.js',
			array(),
			(string) filemtime( $script_path ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'myportfolio_enqueue_assets' );

/**
 * Team entries. Keep unconfirmed profile details visibly marked for editing.
 * Names and roles were supplied by the site owner.
 *
 * @return array<int, array<string, string>>
 */
function myportfolio_team_members() {
	return array(
		array(
			'name'        => 'Christian Angelo Tantoy',
			'role'        => 'Programmer',
			'initials'    => 'CT',
			'photo'       => 'ChristianAngeloTantoy.png',
			'bio'         => __( 'Bio placeholder: add a verified introduction for Christian.', 'myportfolio' ),
			'skills'      => __( 'Skills placeholder: add verified skills.', 'myportfolio' ),
			'accent'      => 'coral',
		),
		array(
			'name'        => 'Jhonicar Alpuerto',
			'role'        => 'Project Manager',
			'initials'    => 'JA',
			'photo'       => 'JhonicarAlpuerto.png',
			'bio'         => __( 'Bio placeholder: add a verified introduction for Jhonicar.', 'myportfolio' ),
			'skills'      => __( 'Skills placeholder: add verified skills.', 'myportfolio' ),
			'accent'      => 'blue',
		),
		array(
			'name'        => 'Noel Ocolares',
			'role'        => 'System Analyst',
			'initials'    => 'NO',
			'photo'       => 'NoelOculares.png',
			'bio'         => __( 'Bio placeholder: add a verified introduction for Noel.', 'myportfolio' ),
			'skills'      => __( 'Skills placeholder: add verified skills.', 'myportfolio' ),
			'accent'      => 'lime',
		),
		array(
			'name'        => 'Edejon Loquias',
			'role'        => 'Technical Writer',
			'initials'    => 'EL',
			'photo'       => 'EdejonLoquias.png',
			'bio'         => __( 'Bio placeholder: add a verified introduction for Edejon.', 'myportfolio' ),
			'skills'      => __( 'Skills placeholder: add verified skills.', 'myportfolio' ),
			'accent'      => 'lavender',
		),
	);
}

/** Theme menu fallback for a fresh local install. */
function myportfolio_primary_menu_fallback() {
	?>
	<ul class="site-nav__list">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#team"><?php esc_html_e( 'The team', 'myportfolio' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#work"><?php esc_html_e( 'Selected work', 'myportfolio' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#contact"><?php esc_html_e( 'Contact', 'myportfolio' ); ?></a></li>
	</ul>
	<?php
}
