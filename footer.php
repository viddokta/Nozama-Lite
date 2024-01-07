	<?php if ( is_active_sidebar( 'prefooter' ) ) : ?>
		<div class="widget-sections-footer">
			<?php dynamic_sidebar( 'prefooter' ); ?>
		</div>
	<?php endif; ?>

	<?php nozama_lite_footer(); ?>

</div>

<div class="navigation-mobile-wrap">
	<a href="#nav-dismiss" class="navigation-mobile-dismiss">
	<?php esc_html_e( 'Close Menu', 'nozama-lite' ); ?>
	</a>
	<ul class="navigation-mobile"></ul>
</div>

<?php wp_footer(); ?>

</body>
</html>
