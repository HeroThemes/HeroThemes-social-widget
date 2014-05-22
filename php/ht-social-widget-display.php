<?php

if(!class_exists('HT_Social_Widget_Display')){


  class HT_Social_Widget_Display extends WP_Widget {
  /*--------------------------------------------------*/
  /* Constructor
  /*--------------------------------------------------*/

  /**
  * Specifies the classname and description, instantiates the widget,
  * loads localization files, and includes necessary stylesheets and JavaScript.
  */
  public function __construct() {

  parent::__construct(
    'ht-social-widget',
    __( 'Heroic Social Widget', 'ht-social-widget' ),
    array(
      'classname' =>  'HT_Social_Widget_Display',
      'description' =>  __( 'A widget for displaying the social media links', 'ht-social-widget' )
    )
  );

  } // end constructor


  /*-----------------------------------------------------------------------------------*/
  /*  Display Widget
  /*-----------------------------------------------------------------------------------*/
  public function widget( $args, $instance ) {

  	include_once('ht-social-widget-common-functions.php');

    //extract arguments into symbol table
    extract( $args, EXTR_SKIP );

    //title
    $title = $instance['title'];

    //get social items
    $social_items = get_option('ht_social_widget_options');

    
    echo $before_widget;

    if ( $title )
    	echo $before_title . $title . $after_title; 

    ?>

    <ul class="ht-social-media-list clearfix">
    <?php
    	if( is_array($social_items) ){
    		//sort by order
    		//usort($social_items, array('HT_Social_Widget_Common_Functions', 'sort_social_items'));
    		foreach ($social_items as $key => $social_item) {
    			if($social_item['enabled']){
    				$provider_id = $social_item['provider_id'];
    				$color = $social_item['color'];
    				$background = $social_item['background'];
    				$url = $social_item['url'];
    				echo "<li>";
	    				echo "<a href='".$url."'>";
	    					HT_Social_Widget_Common_Functions::render_icon($provider_id, $color, $background, '');
	    				echo "</a>";
    				echo "</li>";
    			}
    		}
    	}
     ?>
    </ul>

    <?php 
    echo $after_widget;

  } // end widget

  /*-----------------------------------------------------------------------------------*/
  /*  Update Widget
  /*-----------------------------------------------------------------------------------*/
  public function update( $new_instance, $old_instance ) {
     
 	$instance = $old_instance;
    //update  widget's old values with the new, incoming values
    $instance['title'] = strip_tags( $new_instance['title'] );

    return $instance;
  } // end widget

  /*-----------------------------------------------------------------------------------*/
  /*  Widget Settings
  /*-----------------------------------------------------------------------------------*/
  public function form( $instance ) {

    //Define default values for variables
    $defaults = array(
      'title' => __('Social', 'ht-social-widget'),
    );
    $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <p>
    <label for="<?php echo $this->get_field_id("title"); ?>">
      <?php _e( 'Title', 'ht-social-widget' ); ?>
      :
      <input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
    </label>
    <label for="ht-social-widget-info">
      <?php printf(__('You can control what icons are displayed and the urls on the %ssettings page%s', 'ht-social-widget'), '<a href="'.admin_url( 'options-general.php?page=ht-social-widget-admin' ).'">', '</a>'); ?>
    </label>
    </p>
    <?php 
  } // end form


  } // end class

  add_action( 'widgets_init', create_function( '', 'register_widget("HT_Social_Widget_Display");' ) );


}
