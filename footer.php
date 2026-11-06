<?php
/** Site footer. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<p><?php echo esc_html( get_bloginfo( 'name' ) ); ?> · <?php echo esc_html( (string) gmdate( 'Y' ) ); ?></p>
		<p><?php esc_html_e( 'A four-person team portfolio.', 'myportfolio' ); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
