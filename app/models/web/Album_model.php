<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Album_model extends CI_Model {
		
		public $vars;
		
		public function __construct()
		{
			parent::__construct();
		}
		
		
		public function all_albums()
		{
			$query = $this->db->select();
			$query = $this->db->from('t_album');
			$query = $this->db->order_by('id','DESC');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}
		
		public function get_album($id='')
		{
			return $this->db->where('id', $id)->get('t_album')->row_array();
		}
		public function get_id_album_by_seo($seotitle='')
		{
			return $this->db->where('seotitle', $seotitle)->get('t_album')->row();
		}
		
		public function check_seotitle($seotitle)
		{
			$result = FALSE;
			
			$query = $this->db
			->select('seotitle')
			->where("BINARY seotitle = '$seotitle'", NULL, FALSE)
			->where('active','Y')
			->get('t_album');
			
			$result = $query->num_rows();
			
			if ( $result >= 1 )
			{
				$result = TRUE;
			}
			
			return $result;
		}	
		
		public function album_cover($id_album = '')
		{
			$result = '';
			if ( !empty($id_album) )
			{
				$query = $this->db->select('picture,title');
				$query = $this->db->from('t_gallery');
				$query = $this->db->where('id_album', $id_album);
				$query = $this->db->order_by('id','DESC');
				$query = $this->db->limit(1);
				$query = $this->db->get();
				$result = $query->row_array();
			}
			return $result;
		}
		
		
		public function get_gallery_images($id_album = '')
		{
			$result = [];
			if ( !empty($id_album) )
			{
				$query = $this->db->select('*');
				$query = $this->db->from('t_gallery');
				$query = $this->db->where('id_album', $id_album);
				$query = $this->db->order_by('id','DESC');
				$query = $this->db->get();
				$result = $query->result_array();
			}
			return $result;
		}
		
		public function all_album_image()
		{
			$query = $this->db->select('*');
			$query = $this->db->from('t_album');
			$query = $this->db->order_by('id','DESC');
			$query = $this->db->get();
			$result = $query->result_array();
			return $result;
		}
		
	} // End class.	