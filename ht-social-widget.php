<?php
/*
*	Plugin Name: Heroic Social Widget
*	Plugin URI:  http://wordpress.org/plugins/heroic-social-widget/
*	Description: Social Widget plugin for WordPress
*	Author: HeroThemes
*	Version: 2.1.1
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

			//social widget display
			include_once('php/ht-social-widget-display.php');

		}

		function ht_social_widget_enqueue_scripts_and_styles(){
			wp_enqueue_style( 'ht-social-widget-display-style', plugins_url( 'css/ht-social-widget-display-style.css', __FILE__ ));
			wp_enqueue_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ));
		}


	} //end class

} //end class exists

//load plugin
if( class_exists( 'HT_Social_Widget' ) ){
	$ht_social_widget_init = new HT_Social_Widget();
}