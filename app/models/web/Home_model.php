<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Home_model extends CI_Model {
		
		public $vars;
		
		public function __construct()
		{
			parent::__construct();
		}
		public function related_post_more($limit = '')
		{
			
			$query = $this->db->select('*');
			$query = $this->db->from('t_post');
			$query = $this->db->where('active', 'Y');
			$query = $this->db->where_not_in('id', $post_id);
			
			
			$query = $this->db->order_by('RAND()');
			$query = $this->db->limit($limit);
			$query = $this->db->get();
			
			if ( $query->num_rows() >= 2 )
			{
				$result = $query->result_array();
			}
			else
			{
				$query2 = $this->db->select('*');
				$query2 = $this->db->from('t_post');
				$query2 = $this->db->where('active', 'Y');
				$query2 = $this->db->order_by('id', 'RANDOM');
				$query2 = $this->db->limit($limit);
				$query2 = $this->db->get();
				$result = $query2->result_array();
			}
			
			return $result;
		}
	} // End class.	