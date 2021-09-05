<?php
/**
 * Blank Canvas functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Blank Canvas
 * @since 1.0
 */


// Post Types
require get_theme_file_path('/inc/events-posttype.php');

if ( ! function_exists( 'blank_canvas_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function blank_canvas_setup() {

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'variables.css' );

		


		// Editor color palette.
		$colors_theme_mod = get_theme_mod( 'custom_colors_active' );
		$primary          = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'seedlet_--global--color-primary' ) ) ) ? '#000000' : get_theme_mod( 'seedlet_--global--color-primary' );
		$secondary        = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'seedlet_--global--color-secondary' ) ) ) ? '#007cba' : get_theme_mod( 'seedlet_--global--color-secondary' );
		$foreground       = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'seedlet_--global--color-foreground' ) ) ) ? '#333333' : get_theme_mod( 'seedlet_--global--color-foreground' );
		$tertiary         = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'seedlet_--global--color-tertiary' ) ) ) ? '#FAFAFA' : get_theme_mod( 'seedlet_--global--color-tertiary' );
		$background       = ( ! empty( $colors_theme_mod ) && 'default' === $colors_theme_mod || empty( get_theme_mod( 'seedlet_--global--color-background' ) ) ) ? '#FFFFFF' : get_theme_mod( 'seedlet_--global--color-background' );

		add_theme_support(
			'editor-color-palette',
			array(
				array(
					'name'  => __( 'Primary', 'blank-canvas' ),
					'slug'  => 'primary',
					'color' => $primary,
				),
				array(
					'name'  => __( 'Secondary', 'blank-canvas' ),
					'slug'  => 'secondary',
					'color' => $secondary,
				),
				array(
					'name'  => __( 'Foreground', 'blank-canvas' ),
					'slug'  => 'foreground',
					'color' => $foreground,
				),
				array(
					'name'  => __( 'Tertiary', 'blank-canvas' ),
					'slug'  => 'tertiary',
					'color' => $tertiary,
				),
				array(
					'name'  => __( 'Background', 'blank-canvas' ),
					'slug'  => 'background',
					'color' => $background,
				),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'blank_canvas_setup', 11 );


/*Author: AMMAR
Begin
*/

// expire offer posts on date field.
if (!wp_next_scheduled('expire_posts')){
  wp_schedule_event(time(), 'hourly', 'expire_posts'); // this can be hourly, twicedaily, or daily
}

add_action('expire_posts', 'expire_events_function');

function expire_events_function() {
	$today = date('Y-m-d H:i:s');
	$args = array(
		'post_type' => array('events'), // post types you want to check
		'posts_per_page' => -1 
	);
	$posts = get_posts($args);
	foreach($posts as $p){
		$expiredate = get_field('timestamp', $p->ID, false, false); // get the raw date from the db
		if ($expiredate) {
			if($expiredate < $today){
				$postdata = array(
					'ID' => $p->ID,
					'post_status' => 'draft'
				);
				wp_update_post($postdata);
			}
		}
	}
}
/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 */
function prefix_get_endpoint_events() {
	$args = array(
	        'post_type' => 'events',
	        'posts_per_page' => -1,
	        'post_status' => 'any',
	        'orderby' => 'meta_value ',     
    		'meta_key' => 'timestamp', 
    		'order' => 'ASC',
	    );

	    $query = new WP_Query( $args );
	    $events = array();

	    while( $query->have_posts() ) : $query->the_post();
	    	$id = get_field('id');
	    	$about = get_the_content();
	    	$organizer = get_field('organizer');
	    	$time_stamp = get_field('timestamp');
	    	$email = get_field('email');
	    	$address = get_field('address');
	    	$latitude = get_field('latitude');
	    	$longitude = get_field('longitude');
	    	$tags_array = get_the_tags();
	    	$tags_name = array();
	    	if ($tags_array) {
			  foreach($tags_array as $tag) {
			    $tags_name[] = $tag->name; 
			  }
			}

		    $events[] = array(
		    	 'id' => $id,
		         'title' => get_the_title(),
				 'about' => $about,
				 'organizer' => $organizer,
				 'timestamp' => $time_stamp,
				 'email' => $email,
				 'address' => $address,
				 'latitude' => $latitude,
				 'longitude' => $longitude,
				 'tags' => $tags_name,
		    );

	    endwhile;

	    wp_reset_query();
    // rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
    return rest_ensure_response( $events );
}
 
/**
 * This function is where we register our routes for our example endpoint.
 */
function prefix_register_events_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'api/v1', '/events', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        'methods'  => WP_REST_Server::READABLE,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'prefix_get_endpoint_events',
    ) );
}
 
add_action( 'rest_api_init', 'prefix_register_events_routes' );

/*Author: AMMAR
End
*/

/**
 * Filter the colors for Blank Canvas
 */
function blank_canvas_colors() {
	return array(
		array( '--global--color-background', '#FFFFFF', __( 'Background Color', 'blank-canvas' ) ),
		array( '--global--color-foreground', '#333333', __( 'Foreground Color', 'blank-canvas' ) ),
		array( '--global--color-primary', '#000000', __( 'Primary Color', 'blank-canvas' ) ),
		array( '--global--color-secondary', '#007cba', __( 'Secondary Color', 'blank-canvas' ) ),
		array( '--global--color-tertiary', '#FAFAFA', __( 'Tertiary Color', 'blank-canvas' ) ),
	);
}
add_filter( 'seedlet_colors', 'blank_canvas_colors' );

/**
 * Remove Seedlet theme features.
 */
function blank_canvas_remove_parent_theme_features() {
	// Theme Support.
	remove_theme_support( 'custom-header' );
	remove_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'blank_canvas_remove_parent_theme_features', 11 );

/**
 * Dequeue Seedlet scripts.
 */
function blank_canvas_dequeue_parent_scripts() {
	if ( false === get_theme_mod( 'show_site_header', false ) ) {
		// Naviation assets.
		wp_dequeue_script( 'seedlet-primary-navigation-script' );
		wp_dequeue_style( 'seedlet-style-navigation' );
	}
}
add_action( 'wp_enqueue_scripts', 'blank_canvas_dequeue_parent_scripts', 11 );

/**
 * Remove unused custmizer settings.
 */
function blank_canvas_remove_customizer_settings( $wp_customize ) {

	// Remove Jetpack's Author Bio setting.
	if ( function_exists( 'jetpack_author_bio' ) ) {
		$wp_customize->remove_control( 'jetpack_content_author_bio_title' );
		$wp_customize->remove_control( 'jetpack_content_author_bio' );
	}

	// Remove Seedlet's header and footer hide options,
	// since they're already hidden by default.
	$wp_customize->remove_control( 'hide_site_header' );
	$wp_customize->remove_control( 'hide_site_footer' );
}
add_action( 'customize_register', 'blank_canvas_remove_customizer_settings', 11 );

/**
 * Add custmizer settings.
 */
function blank_canvas_add_customizer_settings( $wp_customize ) {

	// Cast the widgets panel as an object.
	$customizer_widgets_panel = (object) $wp_customize->get_panel( 'widgets' );

	// Add a Customizer message about the site title & tagline options.
	$wp_customize->get_section( 'title_tagline' )->description  = __( 'The site logo, title, and tagline will only appear on single posts and pages if the “Site header and top menu" option is enabled in the Content Options section.', 'blank-canvas' );
	$wp_customize->get_section( 'menu_locations' )->description = __( 'This theme will only display Menus if they are enabled in the Content Options section.', 'blank-canvas' );
	$wp_customize->get_panel( 'nav_menus' )->description        = __( 'This theme will only display Menus if they are enabled in the Content Options section.', 'blank-canvas' );
	$customizer_widgets_panel->description                      = __( 'This theme will only display Widgets if they are enabled in the Content Options section.', 'blank-canvas' );
}
add_action( 'customize_register', 'blank_canvas_add_customizer_settings', 11 );

/**
 * Remove Meta Footer Items.
 */
if ( ! function_exists( 'seedlet_entry_meta_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function seedlet_entry_meta_footer() {

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'blank-canvas' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . seedlet_get_icon_svg( 'edit', 16 ),
			'</span>'
		);
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function blank_canvas_enqueue() {
	wp_enqueue_style( 'blank-canvas-styles', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'blank_canvas_enqueue', 11 );

/**
 * Block Patterns.
 */
require get_stylesheet_directory() . '/inc/block-patterns.php';

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function blank_canvas_body_classes( $classes ) {

	if ( false === get_theme_mod( 'show_post_and_page_titles', false ) ) {
		$classes[] = 'hide-post-and-page-titles';
	}

	if ( false === get_theme_mod( 'show_site_footer', false ) ) {
		$classes[] = 'hide-site-footer';
	}

	if ( false === get_theme_mod( 'show_comments', false ) ) {
		$classes[] = 'hide-comments';
	}

	return $classes;
}
add_filter( 'body_class', 'blank_canvas_body_classes' );
