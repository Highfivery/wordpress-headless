<?php
/**
 * Headless functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Headless
 * @since Headless 1.0.0
 */

add_action( 'init', function() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
		)
	);
});

add_theme_support( 'post-thumbnails' );

/**
 * Register theme setting options
 */
add_action(
	'admin_init',
	function() {
		register_setting( 'wpheadless', 'wpheadless_options' );
		add_settings_section(
			'wpheadless_section_gutenberg',
			__( 'Gutenberg Settings' ),
			'wpheadless_settings_section',
			'wpheadless'
		);

		add_settings_field(
			'wpheadless_field_gutenberg_blocks',
			__( 'Enabled Gutenberg Blocks' ),
			'wpheadless_field_gutenberg_blocks',
			'wpheadless',
			'wpheadless_section_gutenberg',
			array(
				'label_for' => 'wpheadless_field_gutenberg_blocks'
			)
		);
	}
);

function wpheadless_settings_section( $args ) {
}

function wpheadless_field_gutenberg_blocks( $args ) {
	$options = get_option( 'wpheadless_options' );
	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	?>
	<fieldset style="display: flex; flex-wrap: wrap; gap: 10px;">
		<?php
		foreach ( $block_types as $key => $block ) :
			?>
			<div style="width: 20%">
				<legend class="screen-reader-text"><span><?php __( 'Enable' ); ?> <?php echo esc_html( $key ); ?></span></legend>
				<label>
					<input name="wpheadless_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr( $key ); ?>]" type="checkbox" value="1" <?php if ( array_key_exists( $key, $options[ $args['label_for'] ] ) ) : ?> checked="checked"<?php endif; ?> />
					<?php echo esc_html( $key ); ?>
				</label>
			</div>
			<?php
		endforeach;
		?>
	</fieldset>
	<?php
}

/**
 * Register the theme settings page
 */
add_action(
	'admin_menu',
	function() {
		add_submenu_page( 'options-general.php', __( 'Headless Theme' ), __( 'Headless Theme' ), 'manage_options', 'theme-options', 'wpheadless_settings_page');
	}
);

function wpheadless_settings_page() {
	settings_errors( 'wpheadless_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
		<?php
		settings_fields( 'wpheadless' );
		do_settings_sections( 'wpheadless' );
		submit_button( __( 'Save Settings' ) );
		?>
		</form>
	</div>
	<?php
}

/**
 * Controls which Gutenberg blocks are visible
 */
add_filter(
	'allowed_block_types_all',
	function( $allowed_blocks, $editor_context ) {
		$options = get_option( 'wpheadless_options' );

		return array_keys( $options["wpheadless_field_gutenberg_blocks"] );
	},
	25,
	2
);
