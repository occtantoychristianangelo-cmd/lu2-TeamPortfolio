<?php
/**
 * Front page for the four-person team portfolio.
 *
 * @package MyPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="main-content">
	<section class="hero" aria-labelledby="hero-title">
		<div class="hero__content">
			<p class="eyebrow"><?php esc_html_e( 'A four-person project team', 'myportfolio' ); ?></p>
			<h1 id="hero-title"><?php esc_html_e( 'Good work is', 'myportfolio' ); ?><br><em><?php esc_html_e( 'a team effort.', 'myportfolio' ); ?></em></h1>
			<div class="hero__bottom">
				<p class="hero__intro"><?php esc_html_e( 'Meet the four-person team behind Resto Freeno, a restaurant ordering and operations project.', 'myportfolio' ); ?></p>
				<a class="text-link" href="#team"><?php esc_html_e( 'Meet the team', 'myportfolio' ); ?><span aria-hidden="true">↓</span></a>
			</div>
		</div>
	</section>

	<?php if ( 'page' === get_option( 'show_on_front' ) && is_front_page() && have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( trim( wp_strip_all_tags( get_the_content() ) ) || has_blocks( get_the_content() ) ) : ?>
				<section class="page-content" aria-label="<?php esc_attr_e( 'Page introduction', 'myportfolio' ); ?>">
					<div class="content-shell">
						<?php the_content(); ?>
					</div>
				</section>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<section class="section section--team" id="team" aria-labelledby="team-title">
		<div class="section-shell">
			<div class="section-heading">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'The people', 'myportfolio' ); ?></p>
					<h2 id="team-title"><?php esc_html_e( 'Meet the team.', 'myportfolio' ); ?></h2>
				</div>
					<p class="section-heading__note"><?php esc_html_e( 'The people behind Resto Freeno. Add each member’s introduction, skills, and portrait in the theme team data.', 'myportfolio' ); ?></p>
			</div>

			<div class="team-grid">
				<?php foreach ( myportfolio_team_members() as $member ) : ?>
					<article class="member-card">
						<div class="member-card__portrait" style="--portrait-color: var(--<?php echo esc_attr( sanitize_html_class( $member['accent'] ) ); ?>);">
							<?php if ( ! empty( $member['photo'] ) && file_exists( get_template_directory() . '/assets/images/' . $member['photo'] ) ) : ?>
								<img class="member-card__photo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $member['photo'] ) ); ?>" alt="<?php echo esc_attr( sprintf( __( 'Portrait of %s', 'myportfolio' ), $member['name'] ) ); ?>">
							<?php else : ?>
								<span class="member-card__initials" aria-hidden="true"><?php echo esc_html( $member['initials'] ); ?></span>
								<span class="member-card__photo-note"><?php esc_html_e( 'Add portrait', 'myportfolio' ); ?></span>
							<?php endif; ?>
						</div>
						<div class="member-card__info">
							<p class="member-card__role"><?php echo esc_html( $member['role'] ); ?></p>
							<h3><?php echo esc_html( $member['name'] ); ?></h3>
							<p class="member-card__bio"><?php echo esc_html( $member['bio'] ); ?></p>
							<p class="member-card__skills"><?php echo esc_html( $member['skills'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="section" id="work" aria-labelledby="work-title">
		<div class="section-shell work-layout">
			<div class="work-copy">
				<p class="eyebrow"><?php esc_html_e( 'Featured project', 'myportfolio' ); ?></p>
				<h2 id="work-title"><?php esc_html_e( 'Resto Freeno.', 'myportfolio' ); ?></h2>
				<p><?php esc_html_e( 'Created by this four-person team, Resto Freeno is a restaurant ordering and operations platform. Its project code includes order handling, table sessions, reservations, inventory, and PayMongo payment flows.', 'myportfolio' ); ?></p>
			</div>
			<figure class="work-card">
				<img class="work-card__image" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/resto-freeno-preview.svg' ); ?>" alt="<?php esc_attr_e( 'Temporary concept graphic for the Resto Freeno restaurant platform; replace with a real project screenshot.', 'myportfolio' ); ?>">
				<figcaption class="work-card__caption"><?php esc_html_e( 'Temporary concept graphic · replace with a real project image', 'myportfolio' ); ?></figcaption>
			</figure>
		</div>
	</section>

	<section class="section section--contact" id="contact" aria-labelledby="contact-title">
		<div class="section-shell contact-layout">
			<div class="contact-copy">
				<p class="eyebrow"><?php esc_html_e( 'Get in touch', 'myportfolio' ); ?></p>
				<h2 id="contact-title"><?php esc_html_e( 'Let’s make something meaningful.', 'myportfolio' ); ?></h2>
				<p><?php esc_html_e( 'Contact placeholder: add a verified team email address or preferred contact link.', 'myportfolio' ); ?></p>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
