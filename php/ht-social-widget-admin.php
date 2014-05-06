<?php

if( !class_exists( 'HT_Social_Widget_Admin' ) ){
	class HT_Social_Widget_Admin{
		
		//constructor
		function __construct(){
			
			add_action('admin_menu', array( $this, 'ht_social_widget_admin_add_page' ) );

			add_action('admin_init', array( $this, 'ht_social_widget_admin_init' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'ht_social_widget_enqueue_scripts_and_styles' ) );

			$this->ht_social_defaults();

			$this->ht_style_dropdown_options();

		}

		function ht_social_defaults(){

			$this->defaults = array(
				0 	=> 	array( 'provider_id' => 'facebook',
							'enabled' => false,
							'name'	=> __('Facebook', 'ht-social-widget'),
							'style'	=> 'default',
							'color' => '#F0FFFF',
							'background' => '#3b5998',
					),
				1 	=> 	array( 'provider_id' => 'twitter',
							'enabled' => false,
							'name'	=> __('Twitter', 'ht-social-widget'),
							'style'	=> 'default',
							'color' => '#F0FFFF',
							'background' => '#00aced',
					),
				);

		}

		function ht_style_dropdown_options(){
			$this->style_options = array (
				'' => __('Default', 'ht-social-widget'),
				'rounded' => __('Rounded', 'ht-social-widget'),
				'circle' => __('Circle', 'ht-social-widget'),
			);
		}
		
		/**
		* Add the option page to wp menus
		*/
		function ht_social_widget_admin_add_page() {
			$menu_option_title = __('Heroic Social Widget Settings', 'ht-social-widget');
			$menu_option_name = __('Heroic Social Widget', 'ht-social-widget');
			add_options_page($menu_option_title, $menu_option_name, 'manage_options', 'ht-social-widget-admin', array( $this, 'ht_social_widget_options_page' ) );
		}

		/**
		* Render the options page
		*/
		function ht_social_widget_options_page() {
		?>
			<div>
			<h2><?php _e('Heroic Social Widget Settings', 'ht-social-widget') ?></h2>
			<form action="options.php" method="post">
			<?php settings_fields('ht_social_widget_options_group'); ?>
			<?php do_settings_sections('ht-social-widget-admin'); ?>
			<?php submit_button(); ?>
			</form></div>
			 
			<?php
		}

		/**
		* Register the options
		*/		
		function ht_social_widget_admin_init(){
			register_setting( 'ht_social_widget_options_group', 'ht_social_widget_options', array( $this, 'ht_social_widget_options_santize' ) );
			add_settings_section('ht_social_widget_options_main', __('Social Items', 'ht-social-widget'), array($this, 'ht_social_widget_options_group'), 'ht-social-widget-admin');
			add_settings_field( 'ht_social_widget_options_field1', __('Installed	', 'ht-social-widget'), array($this, 'ht_social_widget_options_field'), 'ht-social-widget-admin', 'ht_social_widget_options_main' );	
			
		}

		/**
		* Sanitize callback
		*/
		function ht_social_widget_options_santize($input){
			foreach ($input as $key => $options) {
				
				if( array_key_exists('enabled', $options) ) {
					$input[$key]['enabled'] = true;
				} else {
					$input[$key]['enabled'] = false;
				}
				

			}
				return $input;
		}

		/**
		* Render the options
		*/
		function ht_social_widget_options_group(){
			//nothing to display
			
		}



		/**
		* Render the options
		*/
		function ht_social_widget_options_field(){
			$settings = get_option( 'ht_social_widget_options' );
			echo '<ul id="ht-social-widget-list">';
			//var_dump($settings);

			foreach ($this->defaults as $key => $social_provider_default) {

					echo "<li>";

					$provider_id = $social_provider_default['provider_id'];

					//the user option
					$social_provider_option =  ($settings && is_array($settings) && array_key_exists($key, $settings)) ? $settings[$key] : null;

					//enabled
					$enabled = ($social_provider_option && array_key_exists('enabled', $social_provider_option)) ? $social_provider_option['enabled'] : $social_provider_default['enabled'] ;
					//style
					$style = ($social_provider_option && array_key_exists('style', $social_provider_option)) ? $social_provider_option['style'] : $social_provider_default['style'] ;
					$style = esc_attr( $style );
					//color
					$color = ($social_provider_option && array_key_exists('color', $social_provider_option)) ? $social_provider_option['color'] : $social_provider_default['color'] ;
					$color = esc_attr( $color );
					//background
					$background = ($social_provider_option && array_key_exists('background', $social_provider_option)) ? $social_provider_option['background'] : $social_provider_default['background'] ;
					$background = esc_attr( $background );
					//order
					$order = ($social_provider_option && array_key_exists('order', $social_provider_option)) ? $social_provider_option['order'] : $key;
					$oder = intval( $order );

					//render the icon
					$this->render_icon_preview($provider_id, $style, $color, $background);
					

					$checked = ($enabled) ? 'checked' : '';
   			 		echo "Enabled: <input type='checkbox' name='ht_social_widget_options[$key][enabled]' value='' $checked />";

					//name
					$name = esc_attr( $social_provider_default['name'] );
					echo "Name: " . $name;
					
					
					echo "<select name='ht_social_widget_options[$key][style]'>";
					foreach ($this->style_options as $option_key => $option) {
						$selected = ($option_key==$style) ? 'selected' : '';
						echo "<option value='$option_key' $selected>$option</option>";
					}
					echo "<select>";

					
					
					echo "Text Color: " . "<input class='ht-social-widget-color-picker' type='text' name='ht_social_widget_options[$key][color]' value='$color' />";
					
					echo "Background Color: " . "<input class='ht-social-widget-color-picker' type='text' name='ht_social_widget_options[$key][background]' value='$background' />";
					
					echo "Order: " . "<input type='text' name='ht_social_widget_options[$key][order]' value='$order' />";

					echo "<li/>";
				
			}	

			echo '<ul>';		
		}

		function render_icon_preview($id, $style, $color, $background){
			echo '<div class="ht-icon-preview">';
			$this->render_icon($id, $style, $color, $background);
			echo '</div>';

		}

		function render_icon($id, $style, $color, $background){
			$inline = "style='color:".$color.";background-color:".$background.";'";
			switch ($id) {
				case 'facebook':
					# code...
					echo '<span class="symbol" '.$inline.'>'.$style.'facebook</span>';
					break;
				case 'twitter':
					# code...
					echo '<span class="symbol" '.$inline.'>'.$style.'twitter</span>';
					break;
				
				default:
					break;
			}
		}

		function ht_social_widget_enqueue_scripts_and_styles( $hook_suffix ) {
		    wp_enqueue_style( 'wp-color-picker' );
		    wp_enqueue_script( 'ht-social-widget-script', plugins_url('js/ht-social-widget-script.js', dirname(__FILE__) ), array( 'wp-color-picker' ), false, true );
		}

	} //end class
} //end class test

//load the admin options
if(class_exists('HT_Social_Widget_Admin')){
	$ht_social_widget_init = new HT_Social_Widget_Admin();
}