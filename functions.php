<?php
/**
 * AKdesk functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package AKdesk
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'akdesk_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function akdesk_setup() {
	/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	* If you're building a theme based on AKdesk, use a find and replace
	* to change 'akdesk' to the name of your theme in all the template files.
	*/
	load_theme_textdomain( 'akdesk', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	* Let WordPress manage the document title.
	* By adding theme support, we declare that this theme does not use a
	* hard-coded <title> tag in the document head, and expect WordPress to
	* provide it for us.
	*/
	add_theme_support( 'title-tag' );

	/*
	* Enable support for Post Thumbnails on posts and pages.
	*
	* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'akdesk' ),
		)
	);

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'akdesk_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
 * Add support for core custom logo.
 *
 * @link https://codex.wordpress.org/Theme_Logo
 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
endif;
add_action( 'after_setup_theme', 'akdesk_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function akdesk_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'akdesk_content_width', 640 );
}
add_action( 'after_setup_theme', 'akdesk_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function akdesk_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'akdesk' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'akdesk' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'akdesk_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function akdesk_scripts() {
	wp_enqueue_style( 'akdesk-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'akdesk-style', 'rtl', 'replace' );

	wp_enqueue_script( 'akdesk-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'akdesk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
	$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($wp_cats, "Choose a category");

$options = array (
  
	array( "name" => $themename." Options",
		"type" => "title"),
	  
	 
	array( "name" => "General",
		"type" => "section"),
	array( "type" => "open"),
	  
	array( "name" => "Colour Scheme",
		"desc" => "Select the colour scheme for the theme",
		"id" => $shortname."_color_scheme",
		"type" => "select",
		"options" => array("blue", "red", "green"),
		"std" => "blue"),
		 
		 
		 
	array( "name" => "Custom CSS",
		"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
		"id" => $shortname."_custom_css",
		"type" => "textarea",
		"std" => ""),        
		 
	array( "type" => "close"),
	array( "name" => "Homepage",
		"type" => "section"),
	array( "type" => "open"),
	 
	array( "name" => "Homepage header image",
		"desc" => "Enter the link to an image used for the homepage header.",
		"id" => $shortname."_header_img",
		"type" => "text",
		"std" => ""),
		 
	 
	array( "type" => "close"),
	array( "name" => "Footer",
		"type" => "section"),
	array( "type" => "open"),
		 
	array( "name" => "Footer copyright text",
		"desc" => "Enter text used in the right side of the footer. It can be HTML",
		"id" => $shortname."_footer_text",
		"type" => "textarea",
		"std" => ""),
		 
	  
	array( "type" => "close")
	  
	);
$themename = "AKDesk";
$shortname = "AKD";
function akdtheme_add_admin() {

	global $themename, $shortname, $options;

	if ( $_GET['page'] == basename(__FILE__) ) {

		if ( 'save' == $_REQUEST['action'] ) {

			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

			foreach ($options as $value) {
				if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

			header("Location: admin.php?page=functions.php&saved=true");
			die;

		} 
		else if( 'reset' == $_REQUEST['action'] ) {

			foreach ($options as $value) {
				delete_option( $value['id'] ); }

			header("Location: admin.php?page=functions.php&reset=true");
			die;

		}
	}

	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'akdtheme_admin');
}
function akdtheme_admin() {

	global $themename, $shortname, $options;
	$i=0;

	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';

?>
<div class="wrap akd_wrap">
	<h2><span class="dashicons dashicons-admin-settings"></span> <?php echo $themename; ?> Settings</h2>
	<div class="akd_opts">
		<form method="post">
			<?php foreach ($options as $value) {
				switch ( $value['type'] ) {
					case "open":
					?>
					<?php break;
					case "close":
					?>
					</div>
			</div>
			<br />
			<?php break;
			case "title":
			?>
			<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>

	<?php break;
			case 'text':
	?>

	<div class="akd_input akd_text">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])  ); } else { echo $value['std']; } ?>" />
		<small><?php echo $value['desc']; ?></small>

	</div>
	<?php
				break;

			case 'textarea':
	?>

	<div class="akd_input akd_textarea">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
		<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea>
		<small><?php echo $value['desc']; ?></small>

	</div>

	<?php
				break;

			case 'select':
	?>

	<div class="akd_input akd_select">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

		<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
			<?php foreach ($value['options'] as $option) { ?>
			<option <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
		</select>

		<small><?php echo $value['desc']; ?></small>
	</div>
	<?php
				break;

			case "checkbox":
	?>

	<div class="akd_input akd_checkbox">
		<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>

		<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />


		<small><?php echo $value['desc']; ?></small>
	</div>
	<?php break;
			case "section":

				$i++;

	?>

	<div class="akd_section">
		<div class="akd_title"><h3><?php echo $value['name']; ?></h3><span class="submit"><input class="page-title-action" name="save<?php echo $i; ?>" type="submit" value="Save changes" />
			</span></div>
			<div class="akd_options">


			<?php break;

		}
	}
			?>

			<input type="hidden" name="action" value="save" />
			</form>
			<form method="post">
			<p class="submit">
			<input name="reset" type="submit" class="page-title-action" value="Reset" />
			<input type="hidden" name="action" value="reset" />
			</p>
			</form>
			</div> 


			<?php
}



add_action('admin_init', 'akdtheme_add_init');
add_action('admin_menu', 'akdtheme_add_admin');


function akdtheme_add_init() {
	$file_dir=get_bloginfo('template_directory');
	wp_enqueue_style("optionspanelcss", $file_dir."/themefunctions/options_panel.css", false, "1.0", "all");
	wp_enqueue_script("optionspanelcssjs", $file_dir."/themefunctions/options_panel.js", false, "1.0");
}