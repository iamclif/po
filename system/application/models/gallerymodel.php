<?php
/** 
 * Gallerymodel Class
 * model for gallery/admin controllers
 *
 * @package CodeIgniter
 * @subpackage PhotoCMS
 * @author Jônatan Fróes
 * @link http://themeforest.net/user/jonatanfroes/portfolio
 * @email jonatan.froes@yahoo.com.br
 */ 
class Gallerymodel extends Model {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get admin/site configuration
	 * 
 	 * @access public
	 * @return array
	*/
	public function get_config()
	{
		$this->db->select('id, admin_email, contact_email, login, pass, site_title, 
						  site_description, site_keywords, watermark, watermark_image');
		$this->db->from('configuration');
		$this->db->limit(1);
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->row();
		else
			return FALSE;
	}
	
	/**
	 * check if login and pass are correct
	 * 
 	 * @access public
	 * @return boolean
	*/
	public function check_login($login, $pass)
	{
		$where = array(
				'login' => $login,
				'pass' => $pass
		);
		
		$this->db->select('COUNT(*) as total');
		$this->db->from('configuration');
		$this->db->where($where);
		
		return (bool) $this->db->get()->row()->total;
	}

	/**
	 * select galleries
	 * 
 	 * @access public
	 * @param string
	 * @param bollean
	 * @param boolean
	 * @param array
	 * @return array
	*/
	public function galleries($active = FALSE, $limit = FALSE, $offset = FALSE, $order_by = FALSE)
	{
		$this->db->select('galleries.id, title, description, active, main');
		$this->db->from('galleries');
		if($active)
			$this->db->where('active', $active);
			
		$this->db->limit($offset, $limit);
		
		if($order_by)
			$this->db->order_by($order_by[0], $order_by[1]);
		else
			$this->db->order_by('id', 'DESC');
		

		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return FALSE;
	}
	

	/**
	 * Get data from selected gallery
	 * 
 	 * @access public
	 * @param bollean
	 * @return array
	*/
	public function current_gallery($id)
	{
		$this->db->select('id, title, description, active, main');
		$this->db->from('galleries');
		$this->db->where('id', $id);
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->row();
		else
			return FALSE;
	}
	
	/**
	 * Delete all photos from a category
	 * 
 	 * @access public
	 * @param bollean
	 * @return bool
	*/
	public function delete_all_photos($gallery_id)
	{
		$res = $this->db->delete('photos', array('galleries_id' => $gallery_id));
		if($res)
			return TRUE;
		else
			return FALSE;
	}
	

	/**
	 * count the number os galleries
	 * 
 	 * @access public
	 * @param strinf
	 * @return integer
	*/
	public function total_entries($active = FALSE)
	{
		$this->db->select('COUNT(*) as sum');
		$this->db->from('galleries');
		
		if($active)
			$this->db->where('active', $active);
			
		return $this->db->get()->row()->sum;
	}
	
	/**
	 * Get all info from a selected photo
	 * 
 	 * @access public
	 * @param integer
	 * @return array
	*/
	public function photo($id)
	{
		$this->db->select('photos.id, galleries_id, photos.title, photos.description, image, 
						  galleries.title as g_title, galleries.description as g_desciption');
		
		$this->db->from('photos');
		$this->db->join('galleries', 'galleries.id=galleries_id');
		$this->db->group_by('photos.id');		
		$this->db->where('photos.id', $id);

		$this->db->limit(1);
		
		$result = $this->db->get();
		
		if($result->num_rows() > 0)
			return $result->row();
		else
			return FALSE;	
	}
	
	/**
	 * Get all photos. If gallery_id is passed as a parameter
	 * this function will return only photo from this category
	 * 
 	 * @access public
	 * @param integer
	 * @param integer
	 * @param integer
	 * @return array
	*/
	public function get_photos($gallery_id = FALSE, $limit = FALSE, $offset = FALSE)
	{
		$this->db->select('photos.id, galleries_id, photos.title, photos.description, image, 
						  galleries.title as g_title, galleries.description as g_desciption');
		$this->db->from('photos, galleries');
		
		$this->db->where('galleries.id', $gallery_id);
			
		if($gallery_id)
			$this->db->where('galleries_id', $gallery_id);
		
		$this->db->limit($limit, $offset);
		
		$this->db->order_by('id', 'DESC');
		
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return FALSE;	
	}
	
	/**
	 * Get prev photo
	 * 
 	 * @access public
	 * @param integer
	 * @return array
	*/
	public function get_prev_photo($photo_id, $gallery_id)
	{
		$this->db->select('id, title');
		$this->db->from('photos');
		$this->db->where('id >', $photo_id);
		$this->db->where('galleries_id', $gallery_id);
		$this->db->order_by('id', 'ASC');
		$this->db->limit(1);
		
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->row();
		else
			return FALSE;
	}
	
	/**
	 * Get nex photo
	 * 
 	 * @access public
	 * @param integer
	 * @return array
	*/
	public function get_next_photo($photo_id, $gallery_id)
	{
		$this->db->select('id, title');
		$this->db->from('photos');
		$this->db->where('id <', $photo_id);
		$this->db->where('galleries_id', $gallery_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->row();
		else
			return FALSE;
	}
	
	/**
	 * select pages
	 * Set the 1st parameter ($active) if you'd like to select only (in)active pages
	 * The 2nd and 3rd limits the number of items that will be returned.
	 * 
 	 * @access public
	 * @param string
	 * @param bollean
	 * @param boolean
	 * @return array
	*/
	public function pages($active = FALSE, $limit = FALSE, $offset = FALSE)
	{
		$this->db->select('id, title, content, active');
		$this->db->from('pages');
		
		if($active)
			$this->db->where('active', $active);
			
		$this->db->limit($offset, $limit);
		
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return FALSE;
	}
	
	/**
	 * Get all info from selected page
	 * 
 	 * @access public
	 * @param integer
	 * @return array
	*/
	public function current_page($id)
	{
		$this->db->select('id, title, content, active');
		$this->db->from('pages');
		$this->db->where('id', $id);
		$res = $this->db->get();
		
		if($res->num_rows() > 0)
			return $res->row();
		else
			return FALSE;
	}
	
	/**
	 * count the number of pages
	 * 
 	 * @access public
	 * @param string
	 * @return integer
	*/
	public function total_pages($situation = FALSE)
	{
		$this->db->select('COUNT(*) as total');
		$this->db->from('pages');
		
		if($situation)
			$this->db->where('situation', $situation);
		
		return $this->db->get()->row()->total;
	}

	/**
	 * A generic function to delete data from a selected table
	 * You just need to provide the table name and the item id
	 * 
 	 * @access public
	 * @param string
	 * @param integer
	 * @return boolean
	*/	
	public function delete($table, $id)
	{
		if( $this->db->delete($table, array('id' => $id) ) )
			return TRUE;
		else
			return FALSE;
	}
	
	
	/**
	 * this is a generic function to save data in db
	 * the 1st parameter is the table name
	 * the 2nd is an array with the data that will be saved
	 * the 3dt is optional. If you give an id the function will update the current id. 
	 * Without id a new entry will add into db
	 * 
 	 * @access public
	 * @param string
	 * @param array
	 * @param integer
	 * @return integer/boolean
	 */
	public function save($table, $columns = array(), $id = NULL)
	{
		if($id) {
			$this->db->where('id', $id);
			$result = $this->db->update($table, $columns);
		} else
			$result = $this->db->insert($table, $columns);
		
		if($result) {
			if(!$id) 
				return $this->db->insert_id();
			else
				return TRUE;
		} else
			return FALSE;
	}
	
	
	/**
	 * 
	 * This is a generic function that updates the status of an item
	 * the 1st parameter is the table name
	 * the 2nd is the new situantion. For example, to make inactive you must use 'I'
	 * the 3rd is id of the item that will be updated
	 * 
 	 * @access public
	 * @param string
	 * @param string
	 * @param integer
	 * @return boolean
	 */
	public function update_status($table, $situation, $id)
	{
		$set = array('active' => $situation);

		$this->db->where('id', $id);
		$this->db->limit(1);
		
		if($this->db->update($table, $set))
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * 
	 * This function creats an array with links/names of your menu
	 * If the 1st parameter is TRUE, the function returns an html like <ul id="galleryNav"><li><a ref="..."</a></li></ul>
	 * the 2nd is the current page. set it to add a 'class=active' to your current li.
	 * 
 	 * @access public
	 * @param boolean
	 * @param string
	 * @return array/string
	 */
	public function create_nav($html_output = FALSE, $nav = FALSE)
	{

		//add default pages
		$output[] = array('url' => '', 'title' => 'home' );
//		$output[] = array('url' => 'video', 'title' => 'video' );
//		$output[] = array('url' => 'biography', 'title' => 'biography' );
//		$output[] = array('url' => '', 'title' => 'galleries' );
//		$output[] = array('url' => 'contact', 'title' => 'contact' );


		//get active pages
		$pages = $this->pages('Y');
		if($pages) {
			foreach($pages as $res) {
				$output[] = array(  'url' => 'page/' . $res->id . '/' . url_title($res->title),
									'title' => $res->title
							);
			}
		}
		
		if( ! $html_output )
			return $output;
		else {
			$html = '<ul id="galleryNav">';
			foreach($output as $res) {
				$html .= "\n<li";
				
				if($res['url'] == $nav)
					$html .= ' class="active">';
				else
					$html .= '>';

				$html .= anchor($res['url'], $res['title']) . '</li>';
			}
			$html .= "\n</ul>";
			
			return $html;
			
			
		}
		
	}
}
/* end of the file gallery.php */
/* Location: ./system/application/models/gallerymodel.php */