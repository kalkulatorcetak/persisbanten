<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Podcast_model extends CI_Model {
		
		public $vars;
		private $table = 't_penceramah';
		
		public function __construct()
		{
			parent::__construct();
		}
		
		public function index_penceramah($batas, $posisi)
		{
			$query = $this->db
			->select('
			t_penceramah.id        AS  category_id,
			t_penceramah.title     AS  category_title,
			t_penceramah.link_seo  AS  category_seotitle,
			t_penceramah.gambar
			')
			->from('t_penceramah')
			->where('t_penceramah.active', 'Y')
			->order_by('t_penceramah.id', 'DESC')
			->limit($batas, $posisi)
			->get()
			->result_array();
			
			return $query;
		}
		public function index_post($batas, $posisi)
		{
			$query = $this->db
			->select('
			t_podcast.id           AS  post_id,
			t_podcast.title        AS  post_title,
			t_podcast.title_seo     AS  post_seotitle,
			t_podcast.active       AS  post_active,
			t_podcast.link_audio,
			t_podcast.tanggal,
			t_penceramah.id        AS  category_id,
			t_penceramah.title     AS  category_title,
			t_penceramah.link_seo  AS  category_seotitle,
			')
			->from('t_podcast')
			->join('t_penceramah', 't_penceramah.id = t_podcast.id_penceramah', 'left')
			->where('t_podcast.active', 'Y')
			->order_by('t_podcast.id', 'DESC')
			->limit($batas, $posisi)
			->get()
			->result_array();
			
			return $query;
		}
		public function check_seotitle($seotitle)
		{
			$result = FALSE;
			
			$query = $this->db
			->select('link_seo')
			->where("BINARY link_seo = '$seotitle'", NULL, FALSE)
			->where('active','Y')
			->get($this->table);
			
			$result = $query->num_rows();
			
			if ( $result >= 1 )
			{
				$result = TRUE;
			}
			
			return $result;
		}	
		
		public function check_seopodcast($seotitle)
		{
			$result = FALSE;
			
			$query = $this->db
			->select('title_seo')
			->where("BINARY title_seo = '$seotitle'", NULL, FALSE)
			->where('active','Y')
			->get('t_podcast');
			
			$result = $query->num_rows();
			
			if ( $result >= 1 )
			{
				$result = TRUE;
			}
			
			return $result;
		}	
		
		
		public function get_data($seotitle) 
		{
			$query = $this->db
			->where("BINARY link_seo = '$seotitle'", NULL, FALSE)
			->where('active', 'Y')
			->get($this->table);
			
			return $query->row_array();
		}
		
		public function get_podcast($seotitle) 
		{
			$query = $this->db
			->where("BINARY title_seo = '$seotitle'", NULL, FALSE)
			->where('active', 'Y')
			->get('t_podcast');
			
			return $query->row_array();
		}
		
		public function get_penceramah($id) 
		{
			$query = $this->db
			->select('*')
			->where('id', $id)
			->get('t_penceramah');
			return $query->row_array();
		}
		
		
		public function get_post($id, $batas, $posisi)
		{
			$id_category = $this->db
			->select('id')
			->where('id', $id)
			->get($this->table)
			->result_array();
			
			// arrays_to_string() is function from helper.
			$range_id = explode(',', arrays_to_string($id_category, ','));
			// dump($id_category);
			$query = $this->db
			->select('
			t_podcast.id           AS  post_id,
			t_podcast.title        AS  judul,
			t_podcast.title_seo     AS  post_seotitle,
			t_podcast.count,
			t_podcast.active       AS  post_active,
			t_podcast.link_audio,
			t_podcast.tanggal,
			t_penceramah.id        AS  category_id,
			t_penceramah.title     AS  category_title,
			t_penceramah.link_seo  AS  category_seotitle
			')
			->from('t_podcast')
			->join('t_penceramah', 't_penceramah.id = t_podcast.id_penceramah', 'left')
			->where('t_podcast.active', 'Y')
			->where_in('t_podcast.id_penceramah', $range_id)
			->order_by('t_podcast.position', 'ASC')
			->limit($batas, $posisi)
			->get()
			->result_array();
			
			return $query;
		}
		 
		public function total_category_post($id_category)
		{
		 
			$query = $this->db
			->select('id')
			->where('active', 'Y')
			->where('id_penceramah', $id_category)
			->get('t_podcast')
			->num_rows();
			
			return $query;
		}
		
		public function total_post_penceramah()
		{
			$query = $this->db->select('id');
			$query = $this->db->where('active', 'Y');
			$query = $this->db->get('t_penceramah');
			return $query->num_rows();
		}
	} // End class.		