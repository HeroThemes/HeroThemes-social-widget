<?php

if(!class_exists('HT_Social_Widget_Common_Functions')){
	class HT_Social_Widget_Common_Functions {
		
		/**
		* static function to render the social icon
		*/
		public static function render_icon($provider_id, $color, $background, $title){
			if($color||$background){
				$inline = "style='color:".$color.";background-color:".$background.";'";
			} else {
				$inline = "";
			}
				
			echo '<i class="fa '.$provider_id.'" '.$inline.' title="'.$title.'"></i>';
			
		}

		public static function sort_social_items($a, $b){
			//not yet required
		}
	}


}


