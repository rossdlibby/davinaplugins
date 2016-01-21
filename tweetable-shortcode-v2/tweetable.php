<?php
/*
Plugin Name: Tweetable shortcode v2
Plugin URI: http://tweetable.handypress.io
Description: Shortcode make tweetable sentence
Version: 2.0
Author: Yannick Armspach
Author Email: Yannick Armspach <yannick.armspach@gmail.com>
*/

/**
*
* CONSTANT VAR
*
**/
define( 'TWEETABLE_FILE', __FILE__ );
define( 'TWEETABLE_DIR', plugin_dir_path( TWEETABLE_FILE ) );
define( 'TWEETABLE_URL', plugin_dir_url( TWEETABLE_FILE ) );
		
/**
*
* REQUIRE CLASS
*
**/
if ( !class_exists('TWEETABLE_handyField')) {
require_once( TWEETABLE_DIR . 'inc/fields/fields.class.php' );
}

/**
*
* TWEETABLE CLASS
*
**/

class TWEETABLE {

/**
*
* CONSTRUCT
*
* @desc wordpress action and filter
*
**/
function __construct() {
	
	//Init options	
	add_action( 'init', array( $this, 'initOptions' ), 999999 );
	
	//Get options	
	add_action( 'init', array( $this, 'getOptions' ), 999999 );
	
	//create settings page
	add_action( 'init', array( $this, 'createOptionsPage' ), 999999 );
	
	//script and style
	add_action("wp_head", array( $this, 'loadScriptAndStyle' ), 999999 );
	
	//add custom style
	add_action( 'wp_head', array( $this, 'addCustomStyle' ), 999999 );

	//tinymce
	add_action('init',  array( $this, 'tweetable_shortcode_button_init'));
	
	//shortcode	
	add_shortcode("tweetable", array( $this, 'tweetable_handler' ));

	//textdomain	
	add_action( 'init', array( $this, 'textDomain' ), 999999 );
	
	//activation
	register_activation_hook( TWEETABLE_FILE, array( $this, 'activate' ) );
	
	//deactivate
	register_deactivation_hook( TWEETABLE_FILE, array( $this, 'deactivate' ) );
	
	//uninstall
	//register_uninstall_hook( TWEETABLE_FILE, array( $this, 'uninstall' ) );
	
}

/**
*
* ADD CUSTOM STYLE
*
* @desc get all the option for the plugin
*
**/
public function addCustomStyle(){

	echo '<style id="tweetable-custom-style" type="text/css">' . '.tweetable{' . $this->TWEETABLE_css . '}.tweetable:hover{' . $this->TWEETABLE_css_hover . '}</style>';
	
}

/**
*
* GET OPTIONS
*
* @desc get all the option for the plugin
*
**/
public function getOptions(){
	
	require_once( TWEETABLE_DIR . 'options/general.php' );

	//TWEETABLE_admin_access
	$TWEETABLE_admin_access = get_option('TWEETABLE_admin_access');
	if ( ! $TWEETABLE_admin_access ) $TWEETABLE_admin_access = 'level_10';
	if ( current_user_can($TWEETABLE_admin_access) ) {
	$this->TWEETABLE_admin_access = true;
	}else{
	$this->TWEETABLE_admin_access = false;
	}

	//TWEETABLE_username
	$TWEETABLE_username = get_option('TWEETABLE_username');
	if ( $TWEETABLE_username ) {
	$this->TWEETABLE_username = $TWEETABLE_username;
	} else {
	$this->TWEETABLE_username = '';	
	}
	
	//TWEETABLE_add_postlink
	$TWEETABLE_add_postlink = get_option('TWEETABLE_add_postlink');
	if ( $TWEETABLE_add_postlink ) {
	$this->TWEETABLE_add_postlink = $TWEETABLE_add_postlink;
	} else {
	$this->TWEETABLE_add_postlink = '';	
	}

	//TWEETABLE_content_shorturl
	$TWEETABLE_content_shorturl = get_option('TWEETABLE_content_shorturl');
	if ( $TWEETABLE_content_shorturl ) {
	$this->TWEETABLE_content_shorturl = $TWEETABLE_content_shorturl;
	} else {
	$this->TWEETABLE_content_shorturl = '';	
	}
	
	//TWEETABLE_bitly_username
	$TWEETABLE_bitly_username = get_option('TWEETABLE_bitly_username');
	if ( $TWEETABLE_bitly_username ) {
	$this->TWEETABLE_bitly_username = $TWEETABLE_bitly_username;
	} else {
	$this->TWEETABLE_bitly_username = '';	
	}
	
	//TWEETABLE_bitly_api
	$TWEETABLE_bitly_api = get_option('TWEETABLE_bitly_api');
	if ( $TWEETABLE_bitly_api ) {
	$this->TWEETABLE_bitly_api = $TWEETABLE_bitly_api;
	} else {
	$this->TWEETABLE_bitly_api = '';	
	}

	//TWEETABLE_css
	$TWEETABLE_css = get_option('TWEETABLE_css');
	if ( $TWEETABLE_css ) {
	$this->TWEETABLE_css = $TWEETABLE_css;
	} else {
	$this->TWEETABLE_css = '';	
	}
	
	//TWEETABLE_css_hover
	$TWEETABLE_css_hover = get_option('TWEETABLE_css_hover');
	if ( $TWEETABLE_css_hover ) {
	$this->TWEETABLE_css_hover = $TWEETABLE_css_hover;
	} else {
	$this->TWEETABLE_css_hover = '';	
	}
	
	
}


/**
*
* CREATE OPTIONS PAGE
*
* @desc create the settings page
*
**/
public function createOptionsPage(){
	
	//Options : General
	if ( $this->TWEETABLE_admin_access ) $this->TWEETABLE_settings = new TWEETABLE_handyField( $this->TWEETABLE_settings_arg );
	
}

/**
*
* tweetable_handler
*
* @desc shortcode handler
*
**/
public function tweetable_get_shortURL( $id, $url ) {

	if ( ! $id || ! $url ) return; 

	global $post;
	
	$format = 'json';
	$version = '2.0.1';
	
	$bitly_login = $this->TWEETABLE_bitly_username;
	$bitly_api = $this->TWEETABLE_bitly_api;
	
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$bitly_login.'&apiKey='.$bitly_api.'&format='.$format;

	$response = file_get_contents($bitly);

	if ( strtolower($format) == 'json' ) {

		$json = @json_decode($response,true);
		$short_url =  $json['results'][$url]['shortUrl'];

	} else {

		$xml = simplexml_load_string($response);
		$short_url =  'bit.ly/'.$xml->results->nodeKeyVal->hash;

	}

	add_post_meta($post->ID, $id, $short_url, true);
	//echo $url;
	return $short_url;

}

/**
*
* tweetable_handler
*
* @desc shortcode handler
*
**/
public function tweetable_handler($atts, $content="" ) {
	
	global $post;
	
	//Alternate content only for the tweet
	if ( !empty($atts['alt']) ) { 
	
		$data_tweetable = $atts['alt'];
	
	} else {
		
		$data_tweetable = $content;
		
	}

	
	if ( $this->TWEETABLE_add_postlink == 'short' ) {

		$post_link_bitly = get_post_meta( $post->ID, "short_url", true );
		if ( ! $post_link_bitly ) $post_link_bitly = $this->tweetable_get_shortURL( 'short_url', get_permalink($post->ID) );
		
		$post_link = $post_link_bitly;

	} else if ( $this->TWEETABLE_add_postlink == 'full' ) {

		$post_link = str_replace( array( 'http://', 'wwww.' ), array( '', '' ), get_permalink($post->ID) );

	} else {

		$post_link = '';

	}

	
	if ( $this->TWEETABLE_content_shorturl != '' ) {

		//get content short URL
	  	preg_match_all('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $data_tweetable, $link_tweetable);

	  	$match_link = array_unique( $link_tweetable[0] );

	  	$link_arr = array();
	  	$link_bitly_arr = array();

	  	foreach ( $match_link as $key => $link ) {
	  		
	  		$link_id = str_replace('-', '_', sanitize_title($link) );

	  		$link_bitly = get_post_meta( $post->ID, $link_id, true );
			if ( ! $link_bitly ) $link_bitly = $this->tweetable_get_shortURL( $link_id, $link );
			
			array_push( $link_arr, $link );
			
			$link_bitly = str_replace( array( 'http://', 'wwww.' ), array( '', '' ), $link_bitly );
			array_push( $link_bitly_arr, $link_bitly );

	  	}

	  	if ( $link_bitly ) { 

	  		if ( $this->TWEETABLE_content_shorturl == 'tweet' ) {

	  			$data_tweetable = str_replace($link_arr, $link_bitly_arr, $data_tweetable);

	  		} else if ( $this->TWEETABLE_content_shorturl == 'both' ) {
	  			
	  			$data_tweetable = str_replace($link_arr, $link_bitly_arr, $data_tweetable);
	  		
	  			$content = str_replace($link_arr, $link_bitly_arr, $content);

	  		}
	  		

	  	}

  	}

  	$data_tweetable = strip_tags($data_tweetable);

  	//output
  	$output = '<span data-tweetable="'.$data_tweetable.'" data-shorturl="'.$post_link.'">' . $content . '</span>';  
  	
  	return $output;

}


/**
*
* tweetable_shortcode_button_init 
*
* @desc tinymce button
*
**/
public function tweetable_shortcode_button_init() {

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
    	return;
 
    add_filter("mce_external_plugins", array( $this, "tweetable_register_tinymce_plugin")); 

    add_filter('mce_buttons', array( $this, 'tweetable_add_tinymce_button'));

}


/**
*
* tweetable_register_tinymce_plugin
*
* @desc tinymce plugin
*
**/
public function tweetable_register_tinymce_plugin($plugin_array) {

    $plugin_array['tweetable_button'] = TWEETABLE_URL . 'inc/tinymce-tweetable/tinymce-tweetable.js';
   
    return $plugin_array;
    
}


/**
*
* tweetable_add_tinymce_button
*
* @desc adding tweetable buton to tinymce editor
*
**/
public function tweetable_add_tinymce_button($buttons) {
    
    $buttons[] = "tweetable_button";
    
    return $buttons;
    
}


/**
**
** TEXT DOMAINE
**
** Set language
**
*/
public function textDomain() {

	$domain = 'TWEETABLE';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    
    load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
    
    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( TWEETABLE_FILE ) ) . '/lang/' );

}

/**
*
* LOAD TWEETABLE SCRIPT
*
* @desc Load the script and style
*
*
**/
public function loadScriptAndStyle(){
	
	if( !is_admin() ) {
		
		//wp_enqueue_style( 'TWEETABLE', TWEETABLE_URL . 'css/tweetable.css', false, false, 'screen' ); 
			
		wp_enqueue_script('TWEETABLE', TWEETABLE_URL . 'js/jquery.tweetable.js', array('jquery'), '1.0', true );
		
		wp_localize_script( 'TWEETABLE', 'TWEETABLE', array( 
			
			'via' => $this->TWEETABLE_username,
				
		));
		
	}
	
}

/**
**
** ACTIVATE
**
** @desc Check Wordpress version on plugin activation
**
*/
public function activate( $network_wide ) {
	 
	if ( version_compare( get_bloginfo( 'version' ), '3.0', '<' ) ) {
   	 	
   	 	deactivate_plugins( TWEETABLE_FILE  );
    	
    	wp_die( __('WordPress 3.0 and higher required. The plugin has now disabled itself. Upgrade!','TWEETABLE') );
	
	} 
	
}

/**
*
* INIT OPTIONS
*
* @desc Init option
*
**/
public function initOptions(){
	
	if( is_admin() ) {
	
		if( get_option( 'TWEETABLE_first_activate' ) !== 'v2.0.0' ) {
			
			update_option( 'TWEETABLE_css', 'padding-left:5px;padding-right:23px;padding-top:3px;padding-bottom:3px;background-image:url('. TWEETABLE_URL .'img/bird.png);background-color:#e9ebe4;background-position-x:right;background-position-y:4px;background-repeat:no-repeat;border-top-left-radius:3px;border-top-right-radius:3px;border-bottom-left-radius:3px;border-bottom-right-radius:3px;color:#000;text-decoration:none;');
			update_option( 'TWEETABLE_css_hover', 'background-color:#e2f1f9;background-position-y:-25px;' );
			
			update_option( 'TWEETABLE_first_activate', 'v2.0.0' );
			
		}
	
	}
	
}

/**
*
* DESACTIVATE PLUGIN
*
**/
public function deactivate( $network_wide ) {

}

/**
*
* UNINSTALL PLUGIN
*
**/
public function uninstall( $network_wide ) {

} 

}

$TWEETABLE = new TWEETABLE();

?>