<?php

if(!class_exists('HT_Social_Widget_Common_Functions')){
	class HT_Social_Widget_Common_Functions {
		
		/**
		* static function to render the social icon
		*/
		public static function render_icon($provider_id, $style, $color, $background, $title){
			if($color||$background){
				$inline = "style='color:".$color.";background-color:".$background.";'";
			} else {
				$inline = "";
			}
				
			echo '<span class="symbol" '.$inline.' title="'.$title.'">'.$style.$provider_id.'</span>';
			
		}

		public static function sort_social_items($a, $b){
			//not yet required
		}
	}


}


