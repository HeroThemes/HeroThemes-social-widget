<?php
/*
*	Plugin Name: Heroic Social Widget
*	Plugin URI:  http://wordpress.org/plugins/heroic-social-widget/
*	Description: Social Widget plugin for WordPress
*	Author: Hero Themes
*	Version: 1.0
*	Author URI: http://www.herothemes.com/
*	Text Domain: ht-social-widget
*/




if( !class_exists( 'HT_Social_Widget' ) ){
	class HT_Social_Widget {

		//Constructor
		function __construct(){

			add_action( 'wp_enqueue_scripts',  array( $this, 'ht_social_widget_enqueue_scripts_and_styles' ) );
			add_action( 'admin_init',  array( $this, 'ht_social_widget_enqueue_scripts_and_styles' ) );

			//social widget admin
			include_once('php/ht-social-widget-admin.php');

		}

		function ht_social_widget_enqueue_scripts_and_styles(){
			wp_enqueue_style( 'ht-social-widget-display-style', plugins_url( 'css/ht-social-widget-display-style.css', __FILE__ ));
		}


	} //end class

} //end class exists


if( class_exists( 'HT_Social_Widget' ) ){

	$ht_social_widget_init = new HT_Social_Widget();

}