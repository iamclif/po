<?php
/** 
 * Gallery Class
 * Everything that user will see in your website can be controlled from this file
 *
 * @package CodeIgniter
 * @subpackage PhotoCMS
 * @author Jônatan Fróes
 * @link http://themeforest.net/user/jonatanfroes/portfolio
 * @email jonatan.froes@yahoo.com.br
 */ 

class Gallery extends Controller {
	
	/** 
	 * Set the site menu
	 * @access public
	*/	 
	public $nav;
	
	/** 
	 * Get site config
	 * @access public
	*/
	public $site_config;
	 
	public function __construct()
	{
		parent::__construct();
		
		//load the gallery model as 'g'. You can typing $g->... instead $gallery->...
		$this->load->model('gallerymodel', 'g');
		
		$this->nav = '';
		$this->site_config = $this->g->get_config();
//		$this->output->enable_profiler(TRUE);
	}
	

	/**
	 * show site home page
	 * 
 	 * @access public
	*/
	public function index()
	{
		
		//curent nav
		$this->nav = '';	
		
		//get galleries
		$data['galleries'] = $this->g->galleries('Y');
			
		//load view		
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'home', $data);
	}

	
	/**
	 * Detail of each gallery
	 * 
 	 * @access public
	 * @param integer
	 * @param string
	*/
	public function detail($id, $title = '')
	{		
		//photos from current gallery
		$data['photos'] = $this->g->get_photos($id);
		
		//data from current gallery
		$curr_gal = $this->g->current_gallery($id);
		
		//site description
		if( ! empty($curr_gal->description) )
			$this->site_config->site_description = $curr_gal->description;
		
		

		//load view		
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'gallery', $data);
	}
	
	/**
	 * Detail of each photo
	 * 
 	 * @access public
	 * @param integer
	 * @param string
	*/
	public function photo($id, $title = '')
	{		
		//photos from current gallery
		$data['photo'] = $this->g->photo($id);
		
		//next and prev photos
		$data['prev_photo'] = $this->g->get_prev_photo($id, $data['photo']->galleries_id);
		$data['next_photo'] = $this->g->get_next_photo($id, $data['photo']->galleries_id);
		
		//site description
		if( ! empty($data['photo']->description) )
			$this->site_config->site_description = $data['photo']->description;
		

		//load view		
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'photo', $data);
	}

	/**
	 * Page detail
	 * 
 	 * @access public
	 * @param integer
	 * @param string
	*/
	public function page($id, $title = FALSE)
	{
		//get page data
		$data['current_page'] = $this->g->current_page($id);
		
		//curent nav
		$this->nav = 'page/' . $data['current_page']->id . '/' . url_title($data['current_page']->title);
		
		//load view
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'page', $data);
	
	}
	
	/**
	 * Contact form
	 * 
 	 * @access public
	*/
	public function contact()
	{
		
		//curent nav
		$this->nav = 'gallery/video/biography/contact';
		
		//load view
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'contact');
	}
	
	
	/**
	 * process the contact form
	 * 
 	 * @access public
	 */
	public function submit_form()
	{
		
		//curent nav
		$this->nav = 'gallery/video/biography/contact';
		
		//form validation
		if($this->form_validation->run('contact') == FALSE) {
			$result = validation_errors();
			$error = TRUE;
		} else {
			//get data from fomr
			$name		= $this->input->post('name');
			$email		= $this->input->post('email');
			$message	= $this->input->post('message');
			
			//load email library
			$this->load->library('email');
			
			$this->email->from($email, $name);
			$this->email->to( $this->site_config('contact_email') );
			
			$this->email->subject('Message sent from your site.');
			$this->email->message($message);
			
			//send email
			if($this->email->send() )
				$result = 'Your message has been sent successfully!';
			else { 
				$result = 'Sorry, but your message cound\'t be deliveried.';
				$error = TRUE;
			}
		}

		if($error) {
			$data['form_result'] = '<div class="error">' . $result . '</div>';
		} else
			$data['form_result'] = '<div class="success">' . $result . '</div>';
			
		$this->template->load($this->config->item('my_template'), $this->config->item('t_folder') . 'contact', $data);
			
	}

}

/* End of file gallery.php */
/* Location: ./system/application/controllers/gallery.php */