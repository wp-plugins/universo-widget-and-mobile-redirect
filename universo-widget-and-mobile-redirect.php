<?php 
/* 
Plugin Name: Universo Mobile App Plugin
Description: Displays Universo's (http://universo.mobi) App link in the sidebar and add a Mobile Recognition tool to redirect your reader using mobile devices to your Universo App URL.
Version: 2.4.1
Author: Eduardo Russo
Author URI: http://universo.mobi/
Plugin URI: http://wordpress.org/extend/plugins/universo-widget-and-mobile-redirect/
License: GPL2
*/


$universo_options['widget_fields']['title'] = array('label'=>'Widget title:', 'type'=>'text', 'default'=>'Universo App', 'class'=>'widefat', 'size'=>'', 'help'=>'The title that appears before your widget');
$universo_options['widget_fields']['app_url'] = array('label'=>'Universo App URL:', 'type'=>'text', 'default'=>'http://universo.mobi/universo', 'class'=>'widefat', 'size'=>'', 'help'=>'example: http://universo.mobi/universo');
$universo_options['widget_fields']['app_icon'] = array('label'=>'Show App Icon:', 'type'=>'checkbox', 'default'=>false, 'class'=>'', 'size'=>'', 'help'=>'');
$universo_options['widget_fields']['icon_size'] = array('label'=>'Icon size:', 'type'=>'text', 'default'=>'76', 'class'=>'', 'size'=>'3', 'help'=>'The square size of your icon. Leave empty to use the real size.');
$universo_options['widget_fields']['icon_position'] = array('label'=>'Icon position:', 'type'=>'text', 'default'=>'1', 'class'=>'', 'size'=>'2', 'help'=>'The position the App icon should appear (order) in the sidebar');
$universo_options['widget_fields']['text'] = array('label'=>'Text:', 'type'=>'textarea', 'default'=>'Download our App and check us out on your Mobile Phone! Access <a href="http://universo.mobi/universo">this link</a> or use the QRCode! For iPhone, Android or feature phones!', 'class'=>'', 'rows'=>'6', 'cols'=>'61', 'help'=>'Insert a nice text (html tags allowed) about your App');
$universo_options['widget_fields']['text_position'] = array('label'=>'Text position:', 'type'=>'text', 'default'=>'2', 'class'=>'', 'size'=>'2', 'help'=>'The position the text should appear (order) in the sidebar');
$universo_options['widget_fields']['phone_icons'] = array('label'=>'Show Phone Icons:', 'type'=>'checkbox', 'default'=>false, 'class'=>'', 'size'=>'', 'help'=>'Show Universo\'s compatible phone icons (iPhone, Android and Java)');
$universo_options['widget_fields']['phone_position'] = array('label'=>'Phone Icons position:', 'type'=>'text', 'default'=>'3', 'class'=>'', 'size'=>'2', 'help'=>'The position the Phone Icons should appear (order) in the sidebar');
$universo_options['widget_fields']['app_qrcode'] = array('label'=>'Show App QRCode:', 'type'=>'checkbox', 'default'=>true, 'class'=>'', 'size'=>'', 'help'=>'');
$universo_options['widget_fields']['qrcode_size'] = array('label'=>'QRCode size:', 'type'=>'text', 'default'=>'', 'class'=>'', 'size'=>'3', 'help'=>'The square size of your QRCode. Leave empty to use the default size.');
$universo_options['widget_fields']['qrcode_position'] = array('label'=>'QRCode position:', 'type'=>'text', 'default'=>'4', 'class'=>'', 'size'=>'2', 'help'=>'The position the QRCode should appear (order) in the sidebar');
$universo_options['widget_fields']['mobile_redirect'] = array('label'=>'Redirect Mobile users:', 'type'=>'checkbox', 'default'=>true, 'class'=>'', 'size'=>'', 'help'=>'Redirect readers using mobile devices to your Universo App');

//Show the App icon
function get_app_icon($app_url, $icon_size){
	ob_start();
		ini_set('user_agent', 'Universo Wordpress Widget/1.0 (+http://universo.mobi)');
		$tags = get_meta_tags($app_url);
	ob_end_clean();
	
	if(!empty($tags)){
		if(isset($icon_size))
			echo "<img id='universo_app_icon' src='http://media.universo.mobi/image.php?url=$tags[image]&size=$icon_size" . "x" . "$icon_size' />";
		else
			echo "<img id='universo_app_icon' src='$tags[image]' />";
		}
	else
		echo "<p><b>ERROR: Universo App URL not found or size not defined</b></p>";
}

//Show the App QRCode
function get_app_qrcode($app_url, $qrcode_size){
	$app_name = explode("/", $app_url);
	if(isset($qrcode_size))
		echo "<img id='universo_app_qrcode' src='http://media.universo.mobi/qr?app_name=$app_name[3]&feature=wpwidget' width='$qrcode_size' height='$qrcode_size' />";
	else
		echo "<img id='universo_app_qrcode' src='http://media.universo.mobi/qr?app_name=$app_name[3]&feature=wpwidget' />";
}

//Show the compatible phones icons (iPhone, Android and Java)
function get_phone_icons(){
	echo "<img id='universo_phone_icons' src='" . plugins_url( '/res/phone_icons.png', __FILE__ ) . "' />";
}

//Redirect the blog to it's Universo App
function universo_redirect() {
	include("res/Mobile_Detect.php");
	$detect = new Mobile_Detect();
	global $universo_options; 
	$options = get_option('widget_universo');

	if ($options['mobile_redirect'] && $detect->isMobile()){
		wp_redirect($options['app_url']);
	}
}

function widget_universo_init(){
	
	if (!function_exists('register_sidebar_widget'))
		return;
	$check_options = get_option('widget_universo');

	//Languages
	load_plugin_textdomain( 'widget_universo', false, dirname(plugin_basename(__FILE__)) . "/lang/");

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
		$app_icon = $item['app_icon'] ? "true" : "false";
		$icon_size = $item['icon_size'];
		$icon_position = $item['icon_position'];
		$text = wpautop($item['text']);
		$text_position = $item['text_position'];
		$phone_icons = $item['phone_icons'] ? "true" : "false";
		$phone_position = $item['phone_position'];
		$app_qrcode = $item['app_qrcode'] ? "true" : "false";
		$qrcode_size = $item['qrcode_size'];
		$qrcode_position = $item['qrcode_position'];
		        
		//Remove the Wordpress Title if none was set
		echo $before_widget;
		if (!empty($title))
			echo $before_title . $title . $after_title;
		echo '<div class="textwidget">';
		
		//Insert the Widget elemments in the right order
		for ($count = 1; $count <= 4; $count++){
			// echo $app_qrcode;
			if($icon_position == $count){
				if($app_icon == "true")
					get_app_icon($app_url, $icon_size);
			}
			elseif($text_position == $count){
				echo $text;
			}
			elseif($phone_position == $count){
				if($phone_icons == "true")
					get_phone_icons();
			}
			elseif($qrcode_position == $count){
				if($app_qrcode == "true")
					get_app_qrcode($app_url, $qrcode_size);
			}
		}
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
			
			$field_class = $field['class'];
			$field_size = ($field['class'] != '') ? '' : 'size="' . $field['size'].'"';
			$field_help = ($field['help'] == '') ? '' : '<br/><small>' . __($field['help'], 'widget_universo') . '</small>';
			//Exclusive for textarea
			$field_rows = ($field['rows'] == '') ? '' : 'rows="' . $field['rows'] . '"';
			$field_cols = ($field['cols'] == '') ? '' : 'cols="' . $field['cols'] . '"';
			
			if ($field['type'] != 'textarea'){
				printf("<p class='universo_field'>".
						"<label for='$field_name'>" . __($field['label'], 'widget_universo') . "</label>&nbsp;".
						"<input id='$field_name' name='$field_name' type='" . $field['type'] . "' value='$field_value' class='$field_class' $field_size $field_checked />".
						"$field_help</p>");
			}
			else{
				printf("<p class='universo_field'>".
						"<label for='$field_name'>" . __($field['label'], 'widget_universo') . "</label>&nbsp;".
						"<textarea id='$field_name' name='$field_name' value='$field_value' class='$field_class' $field_rows $field_cols>$field_value</textarea>".
						"$field_help</p>");
			}
		}
		echo '<input type="hidden" id="universo-submit" name="universo-submit" value="1" />';
	}
	
	// Register the widget with WordPress
	function widget_universo_register(){	
		$title = __('Universo Mobile App Link', 'widget_universo');
		$description = __('Show your Universo App access with text, icon and QRCode', 'widget_universo');
		// Register widget for use
		wp_register_sidebar_widget('widget_universo', $title, 'widget_universo', array('description' => $description)); 
		// Register settings for use, 300x100 pixel form
		wp_register_widget_control('widget_universo', $title, 'widget_universo_control', array('width' => 400));
		
		wp_enqueue_style( 'universo-style', plugins_url( 'res/universo.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin
	}
	widget_universo_register();
}
add_action('wp_loaded','universo_redirect');
add_action('widgets_init', 'widget_universo_init');
?>