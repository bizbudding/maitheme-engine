<?php

add_action( 'genesis_before', function() {
	// d( genesis_get_image_sizes() );
	// d( genesis_get_option( 'layout_product' ) );
	// d( genesis_get_cpt_option( 'cpt_archive_layouts_break' ) );
	// $post_types = genesis_get_cpt_archive_types();
	// d( $post_types );
	// delete_option( 'genesis-settings' );
	// delete_option( GENESIS_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . 'product' );
	// wp_cache_delete( GENESIS_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . 'portfolio', 'options' );
	// d( get_option( GENESIS_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . 'portfolio' ) );
	// get_option( GENESIS_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . 'portfolio' );
	// get_option( GENESIS_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX . 'portfolio' );
	// d( get_option( 'genesis-settings' ) );
	// d( genesis_get_option( 'columns' ) );
	// $option = genesis_get_cpt_option( 'archives_featured_image_heading' );
	// d( isset( $option ) );
	// d( get_option( 'disable_banner_customizer_heading' ) );
	// d( genesis_get_cpt_option( 'posts_per_page' ) );
	// d( genesis_get_option( 'posts_per_page' ) );
});


add_filter( 'genesis_options', 'mai_genesis_options_defaults', 10, 2 );
function mai_genesis_options_defaults( $options, $setting ) {

	if ( GENESIS_SETTINGS_FIELD !== $setting ) {
		return $options;
	}

	// Default options.
	$all_options = mai_get_default_options();
	foreach ( $all_options as $key => $value ) {
		if ( ! isset( $options[$key] ) ) {
			$options[$key] = $value;
		}
	}

	// Return the modified options.
	return $options;
}

function mai_get_default_option( $key, $post_type = 'post' ) {
	$options = mai_get_default_options( $post_type );
	return $options[$key];
}

function mai_get_default_options() {

	$defaults = array(
		// Genesis (these need to match G defaults).
		'content_archive'              => 'full',
		'content_archive_limit'        => 120,
		'content_archive_thumbnail'    => 1,
		'image_size'                   => 'one-third',
		'image_alignment'              => '',
		'posts_nav'                    => 'numeric',
		// Mai General.
		'enable_sticky_header'      => 0,
		'enable_shrink_header'      => 0,
		'singular_image_page'       => 1,
		'singular_image_post'       => 1,
		'footer_widget_count'       => 2,
		'mobile_menu_style'         => 'standard',
		// Mai Banner.
		'enable_banner_area'        => 1,
		'banner_background_color'   => '#f1f1f1',
		'banner_id'                 => '',
		'banner_overlay'            => '',
		'banner_inner'              => '',
		'banner_content_width'      => 'auto',
		'banner_align_text'         => '',
		'banner_featured_image'     => 0,
		'banner_disable_post_types' => array(),
		'banner_disable_taxonomies' => array(),
		// Mai Archives.
		'columns'                   => 1,
		'image_location'            => 'before_title',
		'more_link'                 => 0,
		'more_link_text'            => '',
		'remove_meta'               => array(),
		'posts_per_page'            => get_option( 'posts_per_page' ),
		// Mai Singular.
		'singular_image_page'       => 1,
		'singular_image_post'       => 1,
		'remove_meta_post'          => array(),
		// Mai Layouts.
		'layout_page'               => '',
		'layout_post'               => '',
		'layout_archive'            => 'full-width-content',
	);

	/**
	 * Get post types.
	 * Applies apply_filters( 'genesis_cpt_archives_args', $args ); filter.
	 */
	$post_types = genesis_get_cpt_archive_types();

	if ( $post_types ) {
		// Loop through em.
		foreach ( $post_types as $post_type => $object ) {
			$defaults[ sprintf( 'banner_featured_image_%s', $post_type ) ]     = 0;
			$defaults[ sprintf( 'banner_disable_%s', $post_type ) ]            = 0;
			$defaults[ sprintf( 'banner_disable_taxonomies_%s', $post_type ) ] = array();
			$defaults[ sprintf( 'singular_image_%s', $post_type ) ]         = 1;
			$defaults[ sprintf( 'remove_meta_%s', $post_type ) ]            = array();
			$defaults[ sprintf( 'layout_%s', $post_type ) ]                    = '';
		}
	}
	return apply_filters( 'genesis_theme_settings_defaults', $defaults );
}

function mai_get_default_cpt_option( $key ) {
	$options = mai_get_default_cpt_options();
	return $options[$key];
}

function mai_get_default_cpt_options( $post_type ) {
	// Defaults.
	$defaults = array(
		'banner_id'                       => '',
		'hide_banner'                     => 0,
		'layout'                          => mai_get_default_option( 'layout_archive' ),
		'enable_content_archive_settings' => 0,
		'columns'                         => mai_get_default_option( 'columns' ),
		'content_archive'                 => mai_get_default_option( 'content_archive' ),
		'content_archive_limit'           => mai_get_default_option( 'content_archive_limit' ),
		'content_archive_thumbnail'       => mai_get_default_option( 'content_archive_thumbnail' ),
		'image_location'                  => mai_get_default_option( 'image_location' ),
		'image_size'                      => mai_get_default_option( 'image_size' ),
		'image_alignment'                 => mai_get_default_option( 'image_alignment' ),
		'more_link'                       => mai_get_default_option( 'more_link' ),
		'more_link_text'                  => mai_get_default_option( 'more_link_text' ),
		'remove_meta'                     => mai_get_default_option( 'remove_meta' ),
		'posts_per_page'                  => mai_get_default_option( 'posts_per_page' ),
		'posts_nav'                       => mai_get_default_option( 'posts_nav' ),
	);
	return apply_filters( 'genesis_cpt_archive_settings_defaults', $defaults, $post_type );
}
