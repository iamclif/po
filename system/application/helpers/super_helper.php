<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * alert($msg, $redirect = FALSE)
 * Generete an js alert
 * you must provide the message.
 * If you'd like to redirect after the alert, pass the new link in the second parameter 
 * (use site_url() function for internal redirections
 * For a simple history,.back() pass 'back' in your second parameter
 */
if ( ! function_exists('alert'))
{
	function alert($msg, $redirect = FALSE)
	{
		$html = '<script type="text/Javascript"> ';
		$html .= 'alert("'.$msg.'"); ';
		
		if($redirect) {
			if($redirect == "back")
				$html .= 'history.back(); ';
			else
				$html .= 'window.location = "'.$redirect.'" ';
		}
		
		$html .= '</script>';
		
		return $html;
	}
}

/**
 * get_thumb($source_image)
 * return the thumbnail name of an image
 * When you save a new entry this script upload an image and create a thumbnail.
 * the thumbnail name is something like myimage_thumb.jpg. In db we just sava myimage.jpg.
 * You can use this helper to add _thumb in the image name.
 */
if ( ! function_exists('get_thumb'))
{
	function get_thumb($source_image)
	{
		$ext = substr($source_image, -4, 4);
		$image_name = substr($source_image, 0, -4);
		$thumb = $image_name . '_thumb' . $ext;
		return $thumb;
	}
}

if ( ! function_exists('data_modal'))
{
	function data_modal($result, $gallery_name)
	{
		$html = '';
		$count_photos = 1;
		if($result) {
			foreach($result as $res) {
				if($count_photos == 1) {
					$cover = '<a href="' .  base_url() . 'uploads/gallery/' . $res->galleries_id . '/' . 
					$cover .= $res->image . '" title="' . $res->title . '" rel="prettyPhoto[' . $res->galleries_id . ']" ';
					$cover .= 'title="' . $res->title . '" >';
					$cover .= $gallery_name;
					$cover .= '</a>';
				} else {
					$html .= '<a class="link_modal "href="' . base_url() . 'uploads/gallery/';
					$html .= $res->galleries_id .'/' .  $res->image .'" ';
					$html .= 'title="'. $res->description .'" ';
					$html .= 'rel="prettyPhoto[' . $res->galleries_id . ']">';
					
					$html .= '<img src="' . base_url() . '/uploads/gallery/';
					$html .=  $res->galleries_id .'/' . get_thumb($res->image) . '" ';
					$html .= 'alt="'. $res->title .'" />';
					$html .= "</a>\n";
				}
				$count_photos++;
			}
		}
		$return['html'] = $html;
		$return['cover'] = $cover;
		return $return;
	}
}

/* End of file super_helper.php */
/* Location: ./system/application/helper/super_helper.php */