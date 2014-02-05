<?php
/** 
 * Admin Class
 * All admin features are in this class
 *
 * @package CodeIgniter
 * @subpackage PhotoCMS
 * @author Jônatan Fróes
 * @link http://themeforest.net/user/jonatanfroes/portfolio
 * @email jonatan.froes@yahoo.com.br
 */ 
class Admin extends Controller {	
	
	/** 
	 * Set the menus for admin section
	 * @access public
	*/
	public $admin_nav;
	
	function __construct()
	{
		parent::__construct();
		
		//check login
		$this->load->library('session');
		$this->_check_login();
		
		$this->load->model('gallerymodel', 'g');
		
		//admin nav
		$this->admin_nav = 	array( 'dashboard' => 'Home', 'galleries' => 'Galleries', 'pages' => 'Pages', 'config' => 'Config' );
	}
	
	/**
	 * show login form or redirect to dashboard
	 * 
 	 * @access public
	*/
	public function index()
	{
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	        redirect('admin/dashboard');
	    }
		$this->template->load('admin/template', 'admin/login', $data);
	}
	
	/**
	 * show dashboard page
	 * 
 	 * @access public
	*/
	public function dashboard()
	{
		//current nav
		$this->nav = 'Home';
		
		//galleries
		$data['galleries'] = $this->g->galleries();
		
		//pages
		$data['pages'] = $this->g->pages();
		
		$this->template->load('admin/template', 'admin/dashboard', $data);
	}
	
	/**
	 * Check login data and redirect
	 * 
 	 * @access public
	*/	
	public function do_login()
	{
		$login = $this->input->post('login');
		$pass = md5($this->input->post('pass'));
		
		//check data in db
		if($this->g->check_login($login, $pass) ) {
			$data = array(
				'login' => $login,
				'logged_in' => TRUE
			);
			
			//set session data & redirect
			$this->session->set_userdata($data);
	        redirect('admin/dashboard');
			
		} else {
			//show error data
			$this->session->set_flashdata('message', '<p class="error">It seems your username or password is incorrect, please try again.</p>');
			
	        redirect('admin/index');

		}
	}
	
	/**
	 * Unset session data and redirect
	 * 
 	 * @access public
	*/	
	public function logout()
	{
		$this->session->sess_destroy();
		unset($_SESSION['logged_in']);
		redirect('admin/index');
	}
	
	/**
	 * create, and save and send an email with a hash for password reset
	 * 
 	 * @access public
	*/	
	public function recover_password()
	{
		$post_email = $this->input->post('email');
		$info = $this->g->get_config();
		
		//if email is correct
		if( $info->admin_email == $post_email ) {
			$this->load->helper('string');
			$columns['temp_hash'] = random_string('unique');
			
			//save the hash and send an email
			if( $this->g->save('configuration', $columns, 1) ) {
				$this->load->library('email');
				
				$this->email->from($info->admin_email);
				$this->email->to($post_email);
				
				$this->email->subject('Recover your password');
				$message = "Access the following link to recover your password:\n\n"
							. site_url('admin/generate_password/' . $columns['temp_hash']);
							
				$this->email->message($message);
				
				if($this->email->send())
					echo '<div class="success">Check your email for more information</div>';
				else {
					//clear the hash if email wasn't sent
					$columns['temp_hash'] = '';
					$this->g->save('configuration', $columns, 1);
					echo '<div class="error">You request could not be completed!</div>';
				}
			} else
				echo '<div class="error">You request could not be completed!</div>';
		} else
			echo '<div class="error">Email not found!</div>';
	}
	
	/**
	 * generate a new password and send an email
	 * 
 	 * @access public
	 * @param string
	*/	
	public function generate_password($hash = '')
	{
		//get config info
		$info = $this->g->get_config();
		
		//if hash is correct
		if($info->temp_hash == $hash) {
			$this->load->helper('string');
			$new_pass = random_string('alnum', 6);
			
			//save anew password
			$columns['pass'] = md5($new_pass);
			if( $this->g->save('configuration', $columns, 1) ) {
				
				//send email
				$this->load->library('email');
				$this->email->from($info->admin_email);
				$this->email->to($post_email);
				$this->email->subject('Your new password');
				
				$message = "your password has been reseted:\n\n"
							. "login: " . $info->login . "\n"
							. "password: " . $new_pass . "\n\n"
							. "access " . site_url('admin') . "and mo log in.";
							
				$this->email->message($message);
				
				if($this->email->send())
					$this->session->set_flashdata('message', '<p class="success">You password has been reset. Check your email for more information.</p>');
				else
					$this->session->set_flashdata('message', '<p class="success">Your new password is: ' . $new_pass . '</p>');
			} else
				$this->session->set_flashdata('message', '<p class="error">Your passord could not be updated</p>');	
		//clear the hash
		} else {
			$columns['temp_hash'] = '';
			$this->g->save('configuration', $columns, 1);
			$this->session->set_flashdata('message', '<p class="error">Invalida hash!</p>');
		}
		
		$this->template->load('admin/template', 'generate_password');
	}
	

	/**
	 * List all pages
	 * 
 	 * @access public
	 * @param integer
	*/
	public function pages($current_page = FALSE)
	{
		//current nav
		$this->nav = 'Pages';
		
		//get data per page
		$pages = $this->g->pages(FALSE, $current_page, 20);
		$data['pages'] = $pages;
		$total_rows = $this->g->total_pages();
		
		//pagination
		$this->load->library('pagination');
		
		$config['base_url'] = site_url() . '/admin/pages/';
		$config['total_rows'] = $total_rows;
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config); 

		//load the view
		$this->template->load('admin/template', 'admin/pages', $data);
	}
	
	/**
	 * Show form to add a new page. If $id is not FALSE the form will be populated for editing purpouse
	 * 
 	 * @access public
	 * @param integer
	*/
	public function add_page($id = FALSE)
	{
		//current page
		$this->nav = 'Pages';
		
		if($id)
			$data['page'] = $this->g->current_page($id);
			$data['pages'] = $this->g->pages();
		
		//load view
		$this->template->load('admin/template', 'admin/add_page', $data);
	}
	
	
	/**
	 * Save page's data from form into bd. 
	 * If $id is passed as a parameter the function updates. If not, a new entry is saved
	 * 
 	 * @access public
	 * @param integer
	*/
	public function save_page($id = FALSE)
	{
		//check form error		
		if($this->form_validation->run('save_page') == FALSE)
			$error = validation_errors();
		else {
			//populate array to save
			$active = $this->input->post('active');
			$columns['active'] 	= ($active == 'Y') ? 'Y' : 'N';
			
			$columns['title'] 		= $this->input->post('title');
			$columns['content'] 	= $this->input->post('content');
			
			//try to save
			if( ! $this->g->save('pages', $columns, $id))
				$error = 'Could not save in db!';
		}
		//output
		if($error)
			echo '<div class="error">' . $error . '</div>';
		else
			echo '<div class="success">Database upadete succesfully! ' . anchor('admin/pages','My pages') . '</div>';
	}
	
	
	/**
	 * Delete selected page
	 * 
 	 * @access public
	 * @param integer
	*/
	public function delete_page($id)
	{
		//try to dalete
		if($this->g->delete('pages', $id) )
			$output =  '<div class="success">Page deleted succesfully!</div>';	
		else
			$output = '<div class="error">Your page could not be deleted!</div>';
		
		echo $output . anchor('admin/pages', 'close');

	}
		

	/**
	 * List all galleries
	 * 
 	 * @access public
	 * @param integer
	*/
	public function galleries($current_page = FALSE)
	{
		//current nav
		$this->nav = 'Galleries';
		
		//get data per page
		$entries = $this->g->galleries(FALSE, $current_page, 20);
		$data['total_rows'] = $this->g->total_entries();
		$data['entries'] = $entries;
		
		//pagination
		$this->load->library('pagination');
		
		$config['base_url'] = site_url() . '/admin/gallery/';
		$config['total_rows'] = $data['total_rows'];
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		
		$this->pagination->initialize($config); 

		//load the view
		$this->template->load('admin/template', 'admin/gallery', $data);
	}
	
	/**
	 * Save gallery's data from form into bd. 
	 * If $id is passed as a parameter the function updates. If not, a new entry is saved
	 * 
 	 * @access public
	 * @param integer
	*/
	public function save_gallery($id = FALSE)
	{
		//check form error		
		if($this->form_validation->run('save_entry') == FALSE)
			$error = validation_errors();
		else {
			//data from post
			$active					= $this->input->post('active');
			$columns['active']		= ($active == 'Y') ? 'Y' : 'N';
			$columns['title']		= $this->input->post('title');
			$columns['description']	= $this->input->post('description');
			
			$cover = $this->input->xss_clean($_FILES['cover']);
			
			//try to save/update
			if( ! $insert_id = $this->g->save('galleries', $columns, $id))
				$error = 'Could not save in db!';
			else {
				//create the folder for uploads...
				if( ! $id) {
					//...but only if is a new entry
					if( ! mkdir('./uploads/gallery/' . $insert_id, 0777) ) {
						$error = 'Could not create the dir in the server. Check the CMOD.';
						//delete inserted id in case of error
						$this->g->delete('galleries', $insert_id);
					} else {
						@mkdir('./uploads/gallery/' . $insert_id . '/original', 0777);
					}
				} else {
					$insert_id = $id;
				}
			}
		}
		if( ! $error AND ! empty($cover['tmp_name'])) {
			//create the gallery cover
			
			//change server config to work with big images.
			ini_set('memory_limit', '64M');
			ini_set('post_max_size','32');
			ini_set('upload_max_filesize','16');
	
			//do upload
			$upload_result = $this->_do_upload('cover', $insert_id);
			
			if( ! $upload_result['success'])
				$error =  $upload_result['error'];
			else
				$this->_resize_image($upload_result['success'], 'cover');
		}
		if($error)
			echo '<div class="error">' . $error . '</div>';
		else
			echo '<div class="success">Database upadete succesfully!</div>';
			
		echo anchor('admin/galleries','close');
	}

	/**
	 * Delete selected gallery from db and all file from server
	 * 
 	 * @access public
	 * @param integer
	*/
	public function delete_gallery($id)
	{
		
		//delete images and the gallery from db
		if( $this->g->delete_all_photos($id) AND $this->g->delete('galleries', $id) ) {
			$path = './uploads/gallery/' . $id . '/';
			
			//delete images from server
			$this->load->helper('file');
			delete_files($path, TRUE);
			
			//remove the dir
			@rmdir($path);			
			
			$output =  '<div class="success">Gallery deleted succesfully!</div>';	
		} else {
			$output = '<div class="error">The files could not be deleted!</div>';
		}
		
		echo $output . anchor('admin/galleries', 'close');
	}
	
	/**
	 * Show form to add a new photos. and list all photos from selected gallery
	 * 
 	 * @access public
	 * @param integer
	*/
	public function add_photo($gallery_id)
	{
		//current nav
		$this->nav = 'Galleries';
		
		//uploadify configuration
		$data['uploadify_multi'] 	= 'true';
		$data['uploadify_action'] 	= site_url("admin/save_photo/{$gallery_id}/" . md5('flash_data'));
		$data['custom_footer'] 		= 'custom_uploadify';
		
		//gallery data
		$data['gallery'] = $this->g->current_gallery($gallery_id);
		$data['photos'] = $this->g->get_photos($gallery_id);
		
		//load view
		$this->template->load('admin/template', 'admin/add_photo', $data);
	}
	
	/**
	 * Save upload and save a new photo into a selected category
	 * The images are uploaded by uploadify that uses flash for mutiply uploads
	 * flash doesn't send cookies or session. The hash is creted in the add_photo function and compared here.
	 * 
 	 * @access public
	 * @param integer
	 * @param string
	*/
	public function save_photo($gallery_id, $hash)
	{			
		//check hash
		if( $hash != md5('flash_data') )
			die('You are not logged in.');

		//change server config to work with big images.
		ini_set('memory_limit', '64M');
		ini_set('post_max_size','32');
		ini_set('upload_max_filesize','16');

		//do upload
		$upload_result = $this->_do_upload('Filedata', $gallery_id . '/original');
		
		if( ! $upload_result['success']) {
			$error =  $upload_result['error'];
		} else {
			//resize and crop image
			$file_info = $upload_result['success'];
			
			$resized_image = $this->_resize_image($file_info, 'gallery');
			
			//if ok, prepare to insert
			if( ! isset($resized_image['success']) ) {
				$error = $resized_image['error'];
			}
			
			//watermark
			$config_info = $this->g->get_config();
			if($config_info->watermark == 'Y') {
				$watermark = './uploads/watermark/' . $config_info->watermark_image;
				$source_image = './uploads/gallery/' . $gallery_id . '/' . $file_info['file_name'];
				
				if( file_exists($watermark) AND file_exists($source_image) )
					$this->_add_watermark($source_image, $watermark);
			}
		}
		
		//save in db
		if( ! $error ) {		
			$columns['galleries_id']	= $gallery_id;
			$columns['title']			= '';
			$columns['description']		= '';
			$columns['image']			= $file_info['file_name'];

			if( ! $this->g->save('photos', $columns) ) {
				$error = 'Could not save in db!';
			}
		}
		
		if($error)
			echo '<div class="error">Could not save in db!</div>';
		else
			echo '<div class="success">Database upadete succesfully!</div>';
			
        echo anchor('admin/add_photo/' . $gallery_id, 'close', array('class' => 'close'));
	}
	
	/**
	 * Show form to edit photo's info
	 * 
 	 * @access public
	 * @param integer
	*/
	public function edit_photo($id)
	{
		$data['photo'] = $this->g->photo($id);
		$this->load->view('admin/edit_photo', $data);
	}
	
	/**
	 * Save photo's info into bd. 
	 * 
 	 * @access public
	 * @param integer
	*/
	public function save_edit_photo($id)
	{
		//data from form
		$columns['title'] 		= $this->input->post('title');
		$columns['description'] = $this->input->post('description');
		
		//save
		if( ! $this->g->save('photos', $columns, $id) )
			echo '<div class="error">Could not save in db!</div>';
		else
			echo '<div class="success">Database upadete succesfully!</div>';
			
        echo anchor('admin/add_photo/' . $id, 'close', array('class' => 'nyroModalClose close'));
	}
	
	/**
	 * Delete selected photo from db and all files from server
	 * 
 	 * @access public
	 * @param integer
	*/
	public function delete_photo($id)
	{
		//photo info
		$photo_info = $this->g->photo($id);
		
		if($photo_info) {
			//path & name of image
			$upload_path 	= './uploads/gallery/' . $photo_info->galleries_id . '/';
			$orginal		= $upload_path . 'original/' . $photo_info->image;
			$main_image 	= $upload_path . $photo_info->image;
			$thumb 			= get_thumb($main_image);
	
			//try to delete
			if($this->g->delete('photos', $id)) {
				unlink($orginal);
				unlink($main_image);
				unlink($thumb);
				echo '<div class="success">Image deleted successfully!</div>';
			} else {
				echo '<div class="error">An error occurred. Contact the support.</div>';
			}
		} else {
			echo '<div class="error">Photo not found!</div>';
		}
		echo anchor('admin/add_photo/' . $photo_info->galleries_id, 'close', array('class' => 'close'));
		
	}

	
	
	/**
	 * Show form to edit site configuration
	 * 
 	 * @access public
	*/
	public function config()
	{
		//current nav
		$this->nav = 'Config';
		
		//data from db
		$data['configs'] = $this->g->get_config();
		
		//load view
		$this->template->load('admin/template', 'admin/config', $data);
	}
	
	/**
	 * Save config data into db
	 * 
 	 * @access public
	*/
	public function save_config()
	{
		//form validation
		if($this->form_validation->run('save_config') == FALSE)
			$error = validation_errors();
		else {
			
			//prapare to save
			$columns['admin_email'] 		= $this->input->post('admin_email');
			$columns['contact_email'] 		= $this->input->post('contact_email');
			$columns['login'] 				= $this->input->post('login');
			$columns['site_title'] 			= $this->input->post('site_title');
			$columns['site_description']	= $this->input->post('site_description');
			$columns['site_keywords'] 		= $this->input->post('site_keywords');
			$columns['watermark'] 			= ($this->input->post('watermark') == 'Y') ? 'Y' : 'N';
			
			$pass = trim($this->input->post('pass'));
			
			//check if password as posted
			if( ! empty($pass) )
				$columns['pass'] = md5($pass);
			
			if( ! $this->g->save('configuration', $columns, 1) )
				$msg = 'An error occurred and the db wasn\'t updated.';
		}
		
		//output
		if($error)
			echo '<div class="error">' . $error . '</div>';
		else
			echo '<div class="success">Database upadete succesfully! ' . anchor('admin','back') . '</div>';
			
		echo anchor('admin/config','close') . '</div>';
	}
	
	/**
	 * Upload and save the watermark
	 * 
 	 * @access public
	*/
	public function save_watermark()
	{
		//do upload
		$upload_result = $this->_do_upload('watermark');
		
		if( ! $upload_result['success'])
			$error =  $upload_result['error'];
		else {
			//get old data
			$config_info = $this->g->get_config();
			$old_watermark = $config_info->watermark_image;
			
			//update db
			$columns['watermark_image'] = $upload_result['success']['file_name'];
			
			if( $this->g->save('configuration', $columns, 1) ) {
				$path = './uploads/watermark/' . $old_watermark;
				unlink($path);
			} else
				$error = 'The db could\'t be updated!';
		}

		if($error)
			echo '<div class="error">' . $error . '</div>';
		else
			echo '<div class="success">Database upadete succesfully!</div>';
			
		echo anchor('admin/config','close');
	}
	
	
	/**
	 * Update the status in a selected table.
	 * The first parameter is the table name. The second is the situation (Active, Inative, etc.)
	 * and the third one is the id of the item.
	 * 
 	 * @access public
	 * @param string
	 * @param string
	 * @param integer
	*/
	public function update_status($table, $situation, $id)
	{
		//current nav
		$this->nav = 'My Galleries';
		
		// try to update
		$result = $this->g->update_status($table, $situation, $id);
		
		//show the message
		if($result)
			echo  '<div class="success">Database was updated successfully!</div>';
		else
			$msg = '<div class="error">Your request couldn\'t be completed</div>';

		//define page redirection
		switch($table) {
			case "galleries" :
				$redirect = site_url('admin/galleries/');
				break;
			case "pages" :
				$redirect = site_url('admin/pages/');
				break;
		}
		
		echo anchor($redirect, 'close', array('class' => 'close'));
	}
	
	
	/**
	 * Uploads an image to the server. 
	 * 
 	 * @access private
	 * @param string
	 * @param string
	 * @return array
	*/
	private function _do_upload($form_field, $folder = FALSE)
	{
		//define the path for the upload
		switch($form_field) {
			case 'Filedata' :
				$config['encrypt_name'] = TRUE;
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['upload_path'] = 'uploads/gallery/' . $folder;
				break;
				
			case 'cover' :
				//fix a small bug in the Upload class to save the image with 'cover' name.
				$file_name = $_FILES[$form_field]['name'];
				$file_ext = strchr($file_name,'.');
				$_FILES[$form_field]['name'] = $form_field . $file_ext;
				
				$config['encrypt_name'] = FALSE;
				$config['upload_path'] = './uploads/gallery/' . $folder;
				$config['overwrite'] = TRUE;
				$config['allowed_types'] = 'jpg|jpeg';
				break;
				
			case 'watermark' :
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['upload_path'] = './uploads/watermark/';
				break;
		}

		//load the library
		$this->load->library('upload', $config);
		
		//do upload
		if( ! $this->upload->do_upload($form_field) )
			$result['error'] = $this->upload->display_errors();
		else
			$result['success'] = $this->upload->data();

		return $result;
	}
	
	
	/**
	 * Resize an image.
	 * The width and height are setted in main.php file (into config folder)
	 * and the _do_upload($form_field) function returns an array that's passed to _resize_image function
	 * 
 	 * @access private
	 * @param string
	 * @param array
	 * @return array	 
	*/
	private function _resize_image($file_info, $source_image)
	{
		switch($source_image) {
			case 'gallery' :
				//image manipulation config
				$config['image_library'] = 'gd2';
				$config['source_image'] = $file_info['full_path'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$new_image = str_replace('original/', '', $file_info['file_path'] . $file_info['file_name']);
   				$config['new_image'] = $new_image;
				$config['width'] = $this->config->item('img_max_width');
				$config['height'] = $this->config->item('img_max_height');
				break;
				
			case 'cover' :
				//image manipulation config
				$config['image_library'] = 'gd2';
				$config['source_image'] = $file_info['full_path'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				
				//set image size
				$image_x = ($this->config->item('cover_width') * 100) / $file_info['image_width'];
				$image_y = ($this->config->item('cover_height') * 100) / $file_info['image_height'];
				
				$config['width'] = $this->config->item('cover_width');
				$config['height'] = $this->config->item('cover_height');
				$config['master_dim'] = ($image_x > $image_y) ? 'width' : 'height';
				break;	
		}
		
		//load the library
		$this->load->library('image_lib');
		$this->image_lib->initialize($config);
		
		//resize
		if( ! $this->image_lib->resize() ) {
			$result['error'] = $this->image_lib->display_errors();
			return $result;
		} else
			$result['success'] =  TRUE;

		//clear image lib
		$this->image_lib->clear();
		unset($config);
		
		//crop the cover
		if($source_image == 'cover') {
			//crop settings
			$config['image_library'] = 'gd2';
			$config['source_image'] = $file_info['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = FALSE;
			$config['width'] = $this->config->item('cover_width');
			$config['height'] = $this->config->item('cover_height');
			
			//start the library
			$this->image_lib->initialize($config);		
	
			//crop
			if( ! $this->image_lib->crop() ) {
				$result['error'] = $this->image_lib->display_errors();
				$result['success'] = FALSE;
			} else 
				$result['success'] = TRUE;

		//create the thumb
		} elseif($source_image == 'gallery') {
			$config['image_library'] = 'gd2';
			$config['source_image'] = $file_info['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			$config['new_image'] =  str_replace('original/', '', $file_info['file_path'])
									. $file_info['raw_name'] 
									. '_thumb' 
									. $file_info['file_ext'];
									
			//set image size
			
			$image_info = getimagesize($new_image);
			
			$image_x = ($this->config->item('thumb_width') * 100) / $image_info[0]; //$file_info['image_width'];
			$image_y = ($this->config->item('thumb_height') * 100) / $image_info[1]; //$file_info['image_height'];
			
			$config['width'] = $this->config->item('thumb_width');
			$config['height'] = $this->config->item('thumb_height');
			$config['master_dim'] = ($image_x > $image_y) ? 'width' : 'height';
			
			//start the library
			$this->image_lib->initialize($config);
			
			//resize
			if( ! $this->image_lib->resize() ) {
				$result['error'] = $this->image_lib->display_errors();
				return $result;
			} else {
				//clear image lib
				$this->image_lib->clear();
				unset($config);

				//crop the thumb
				$config['image_library'] = 'gd2';
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['width'] = $this->config->item('thumb_width');
				$config['height'] = $this->config->item('thumb_height');
				$config['source_image'] =  str_replace('original/', '', $file_info['file_path'])
										. $file_info['raw_name'] 
										. '_thumb' 
										. $file_info['file_ext'];

				//start the library
				$this->image_lib->initialize($config);		
		
				//crop
				if( ! $this->image_lib->crop() ) {
					$result['error'] = $this->image_lib->display_errors();
					$result['success'] = FALSE;
				} else 
					$result['success'] = TRUE;	
			}
		}
					
		return $result;
	}
	
	/**
	 * Add watermark in a selected image
	 * 
 	 * @access private
	 * @param string
	 * @param string
	 * @return array
	*/
	private function _add_watermark($source_image, $watermark)
	{	
		//ccnfig the image_lib class
		$this->image_lib->clear();
		$config['source_image'] = $source_image;
		$config['wm_type'] = 'overlay';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		$config['wm_padding'] = '-10';
		$config['wm_overlay_path'] = $watermark;
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'right';
		
		$this->image_lib->initialize($config);
		
		if($this->image_lib->watermark())
			$result['error'] = $this->image_lib->display_errors();
		else
			$result['success'] =  TRUE;

		return $result;	
	}
	
	/**
	 * check if the user is logged in.
	 * this function is called in the constructor, but some pages doesn't need this checked. (login_for, logout...)
	 * Thess pages are in the $public_access array
	 * 
 	 * @access private
	*/
	private function _check_login()
	{
		//these pages won't be checked
		$public_access = array('', 'index', 'do_login', 'logout', 'save_photo', 'generate_password', 'recover_password');
		
		//current controller
		$current_function = $this->uri->segment(2);
		
		//if not in public_access array we will check the data
		if( ! in_array($current_function, $public_access) ) {
			if($this->session->userdata('logged_in') != TRUE) {
				$this->session->set_flashdata('message', '<p class="error">You must login to view this page!</p>');
				redirect('admin/index');
			}
		}
	}
	
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */