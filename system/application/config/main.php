<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Template Folder
|--------------------------------------------------------------------------
|
| You can create how many tamplates you want to. Put all files of your templates in separeted folders in
| '.system/application/views/site/{your_template_folder}/', then you must set this config according with your template.
| CI will load the respective folder automatilly.
|
*/
$config['t_folder'] 	= 'themes/dark/';

/*
|--------------------------------------------------------------------------
| Main Template File
|--------------------------------------------------------------------------
|
| 
| This system uses a library that allow you to load a file inside a template. This way you only have to create a template 
| to wrap the dynamic content and then create files with the dynamic content. Put this file here.
|
*/
$config['t_default'] 	= 'template';

/*
|--------------------------------------------------------------------------
| Sub Template File
|--------------------------------------------------------------------------
|
| 
| The template for subpages.
|
*/
$config['t_pages'] 	= 'template_pages';

/*
|--------------------------------------------------------------------------
| My template
|--------------------------------------------------------------------------
|
| Union of configs above. You don't need to change it
|
*/
$config['my_template'] 	= $config['t_folder'] . $config['t_default'];
$config['sub_template'] = $config['t_folder'] . $config['t_pages'];


/*
|--------------------------------------------------------------------------
| Image max width/height
|--------------------------------------------------------------------------
|
| wen you upload an image to the gallery this script will resize it. Define here me max width and height.
| You must define according with your template. Keep 'img_max_height' big...
|
|
*/
$config['img_max_width'] 	= 930;
$config['img_max_height'] 	= 1200;


/*
|--------------------------------------------------------------------------
| Thumb width/height
|--------------------------------------------------------------------------
|
| The thumbnail is generate automatilly by cropping a piece of the uploaded image. Define here the exact width/height.
|
|
*/
$config['thumb_width'] 	= 140;
$config['thumb_height'] = 140;

/*
|--------------------------------------------------------------------------
| Cover width/height
|--------------------------------------------------------------------------
|
| The thumbnail is generate automatilly by cropping a piece of the uploaded image. Define here the exact width/height.
|
|
*/
$config['cover_width'] 	= 320;
$config['cover_height'] = 320;


/*
|--------------------------------------------------------------------------
| Receive emails on new submitions
|--------------------------------------------------------------------------
|
| You may (or not) receive an email when someone suggest an entry.
|
|
*/
$config['receive_email'] = FALSE;



/*
|--------------------------------------------------------------------------
| Choose how many itens will be shown in each page
|--------------------------------------------------------------------------
|
|
*/
$config['itens_per_page'] = 7;

/* End of file main.php */
/* Location: ./system/application/config/main.php */