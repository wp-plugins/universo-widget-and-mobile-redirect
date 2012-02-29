<?php 
/* 
Plugin Name: Universo Mobile App Plugin
Description: This plugin has a Widget that displays Universo's (http://universo.mobi) App link in the sidebar, so your blog readers can access your Universo Mobile App via QRCode or Link. It also have  Mobile Recognition tool to redirect your reader to your Universo App URL.
Version: 0.1
Author: Eduardo Russo
Author URI: http://universo.mobi/
Plugin URI: http://wordpress.org/extend/plugins/universo-widget-and-mobile-redirect
License: GPL2
*/

$universo_options['widget_fields']['title'] = array('label'=>'Widget title:', 'type'=>'text', 'default'=>'Facebook', 'class'=>'widefat', 'size'=>'', 'help'=>'The title before your widget');
$universo_options['widget_fields']['app_url'] = array('label'=>'Universo App URL:', 'type'=>'text', 'default'=>'http://universo.mobi/universo', 'class'=>'widefat', 'size'=>'', 'help'=>'Your Universo App URL');
$universo_options['widget_fields']['app_qrcode'] = array('label'=>'Show App QRCode:', 'type'=>'checkbox', 'default'=>true, 'class'=>'', 'size'=>'', 'help'=>'Show App QRCode');
$universo_options['widget_fields']['qrcode_size'] = array('label'=>'QRCode size:', 'type'=>'text', 'default'=>'', 'class'=>'', 'size'=>'3', 'help'=>'The square size of your QRCode. Leave empty to use the real size.');
$universo_options['widget_fields']['app_icon'] = array('label'=>'Show App Icon:', 'type'=>'checkbox', 'default'=>false, 'class'=>'', 'size'=>'', 'help'=>'Show App Icon');
$universo_options['widget_fields']['icon_size'] = array('label'=>'Icon size:', 'type'=>'text', 'default'=>'76', 'class'=>'', 'size'=>'3', 'help'=>'The square size of your icon. Leave empty to use the real size.');
// $universo_options['widget_fields']['order'] = array('label'=>'Elements order:', 'type'=>'dropdown', 'default'=>'1', 'class'=>'', 'size'=>'', 'help'=>'Select the order you want the page elements to be displayed');
$universo_options['widget_fields']['text'] = array('label'=>'Text:', 'type'=>'textarea', 'default'=>'Download our App and check us out on your Mobile Phone! Access <a href="http://universo.mobi/universo">this link</a> or use the QRCode! For iPhone, Android or feature phones!', 'class'=>'', 'rows'=>'6', 'cols'=>'31', 'help'=>'Insert a nice text (html tags allowed) about your App');
//$universo_options['widget_fields']['app_text'] = array('label'=>'Show App Text:', 'type'=>'checkbox', 'default'=>false, 'class'=>'', 'size'=>'', 'help'=>'Show App Text from Universo Page');

function get_app_icon($app_url, $icon_size){
	ob_start();
	$tags = get_meta_tags($app_url);
	ob_end_clean();
	echo (!empty($tags)) ? "<img id='universo_app_icon' src='http://media.universo.mobi/image.php?url=$tags[image]&size=$icon_size' />" : "<p><b>ERROR: Universo App URL not found or size not defined</b></p>";
}

function get_app_qrcode($app_url, $qrcode_size){
	// http://portal.universo.mobi/images/qr/http://universo.mobi/universo
	echo "<img id='universo_app_qrcode' src='http://media.universo.mobi/image.php?url=http://portal.universo.mobi/images/qr/$app_url&size=$qrcode_size' />";
}

function widget_universo_init(){ 
	if (!function_exists('register_sidebar_widget'))
		return;
	$check_options = get_option('widget_universo');


	// Output the widget
	function widget_universo($args){

		global $universo_options; 
		extract($args);
		$options = get_option('widget_universo');
		
		// Fill options with default values if value is not set
		$item = $options;
		foreach($universo_options['widget_fields'] as $key => $field){
			if (! isset($item[$key])){
				$item[$key] = $field['default'];
			}
		} 
		
		$title = $item['title']; 
		$app_url = $item['app_url'];
		$app_qrcode = $item['app_qrcode'] ? "true" : "false";
		$qrcode_size = $item['qrcode_size'];
		$app_icon = $item['app_icon'] ? "true" : "false";
		$icon_size = $item['icon_size'];
		$text = wpautop($item['text']);

		//Remove the Wordpress Title if none was set
		echo $before_widget;
		if (!empty($title))
			echo $before_title . $title . $after_title;
		echo '<div class="textwidget">';
		if($app_icon == "true")
			get_app_icon($app_url, $icon_size);
		echo $text;
		if($app_qrcode == "true")
			get_app_qrcode($app_url, $qrcode_size);
		echo '</div>';
 		echo $after_widget;
	}
	
	// Output the Widget form and Saves it if a post is set
	function widget_universo_control(){
		global $universo_options;
		$options = get_option('widget_universo');
		
		//Saves the Widget data
		if (isset($_POST['universo-submit'])){
			foreach($universo_options['widget_fields'] as $key => $field){
				$options[$key] = $field['default'];
				$field_name = sprintf('%s', $key); 
				if ($field['type'] == 'text'){
					$options[$key] = strip_tags(stripslashes($_POST[$field_name]));
				}
				elseif ($field['type'] == 'checkbox'){
					$options[$key] = isset($_POST[$field_name]);
				}
				elseif ($field['type'] == 'textarea'){
					$options[$key] = stripslashes(wp_filter_post_kses( addslashes($_POST[$field_name])));
				}
			}
			update_option('widget_universo', $options);
		}
 
		//Shows the Widget Form
		foreach($universo_options['widget_fields'] as $key => $field){
			$field_name = sprintf('%s', $key);
			$field_checked = '';
			if ($field['type'] == 'text'){
				$field_value = (isset($options[$key])) ? htmlspecialchars($options[$key], ENT_QUOTES) : htmlspecialchars($field['default'], ENT_QUOTES);
			}
			elseif ($field['type'] == 'checkbox'){
				$field_value = (isset($options[$key])) ? $options[$key] : $field['default'] ;
				if ($field_value == 1){
					$field_checked = 'checked="checked"';
				}
			}
			elseif ($field['type'] == 'textarea'){
				$instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text']) ) );
				$field_value = (isset($options[$key])) ? $options[$key] : $field['default'];
				// $field_value = stripslashes(wp_filter_post_kses(addslashes($field_value)));
			}
			
			$jump = ($field['type'] != 'checkbox') ? '<br />' : '&nbsp;';
			$field_class = $field['class'];
			$field_size = ($field['class'] != '') ? '' : 'size="'.$field['size'].'"';
			$field_help = ($field['help'] == '') ? '' : '<small>'.$field['help'].'</small>';
			//Exclusive for textarea
			$field_rows = ($field['rows'] == '') ? '' : 'rows="'.$field['rows'].'"';
			$field_cols = ($field['cols'] == '') ? '' : 'cols="'.$field['cols'].'"';
			if ($field['type'] != 'textarea'){
				printf("<p class='universo_field'>".
						"<label for='$field_name'>" . __($field['label']) . "</label>$jump".
						"<input id='$field_name' name='$field_name' type='" . $field['type'] . "' value='$field_value' class='$field_class' $field_size $field_checked />".
						"<br/>$field_help</p>");
			}
			else{
				printf("<p class='universo_field'>".
						"<label for='$field_name'>" . __($field['label']) . "</label>$jump".
						"<textarea id='$field_name' name='$field_name' value='$field_value' class='$field_class' $field_rows $field_cols>$field_value</textarea>".
						"<br/>$field_help</p>");
			}
		}
		echo '<input type="hidden" id="universo-submit" name="universo-submit" value="1" />';
	}
	
	// Register the widget with WordPress
	function widget_universo_register(){		
		$title = 'Universo Mobile App Link';
		// Register widget for use
		register_sidebar_widget($title, 'widget_universo'); 
		// Register settings for use, 300x100 pixel form
		register_widget_control($title, 'widget_universo_control');
		
		wp_enqueue_style( 'universo-style', plugins_url( 'universo.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
	}
	widget_universo_register();
}
add_action('widgets_init', 'widget_universo_init');
?>