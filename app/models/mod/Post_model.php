<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Post_model extends CI_Model {
		
		public $vars;
		private $session_level;
		private $session_key;
		private $_table = 't_post';
		private $_column_order = array(null, 't_post.id', 't_post.title', 't_category.seotitle', 't_post.datepost', 't_post.active', null);
		private $_column_search = array('t_post.id', 't_post.title', 't_category.title', 't_category.seotitle', 't_post.datepost', 't_user.name');
		
		public function __construct()
		{
			parent::__construct();
			$this->session_group = group_active('group');
			$this->session_key = decrypt(login_key());
		}
		
		
		public function datatable($method, $type = 'data')
		{
			$result = NULL;
			
			if ($type === 'count')
			{
				$this->$method();
				$result =  $this->db->get()->num_rows();
			}
			
			if ($type === 'data')
			{
				$this->$method();
				if ($this->input->post('length') != -1) 
				{
					$this->db->limit($this->input->post('length'), $this->input->post('start'));
					$query = $this->db->get();
				}
				else
				{
					$query = $this->db->get();
				}
				
				$result =  $query->result_array();
			}
			
			return $result;
		}
		
		
		private function _all_post()
		{
			$this->db->select('
			t_post.id        AS post_id,
			t_post.title     AS post_title,
			t_post.seotitle  AS post_seotitle,
			t_post.headline  AS post_headline,
			t_post.hits      AS post_hits,
			t_post.datepost  AS post_datepost,
			t_post.timepost  AS post_timepost,
			t_post.active    AS post_active,
			t_post.tag       AS post_tag,
			t_post.is_deleted,
			t_category.title AS category_title,
			t_user.id        AS user_id,
			t_user.name      AS user_name,
			t_user.key_group AS user_group,
			COUNT(t_comment.id_post) AS comments
			');
			
			$this->db->from($this->_table);
			$this->db->join('t_comment', 't_comment.id_post = t_post.id', 'left');
			$this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
			$this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
			
			// Filter by user if not admin/root
			if (!in_array($this->session_group, ['root', 'admin'])) {
				$this->db->where('t_post.id_user', decrypt(login_key()));
			}
			
			// --- FILTER STATUS ---
			$status = $this->input->post('id_status');
			if ($status !== null && $status !== '') {
				if ($status === '1') {
					$this->db->where('is_deleted', 1);
					} else {
					$this->db->where('t_post.active', $status);
					$this->db->where('is_deleted', 0);
				}
				} else {
				$this->db->where('is_deleted', 0); // default filter
			}
			
			// Searching
			$i = 0;
			foreach ($this->_column_search as $item) {
				if ($this->input->post('search')['value']) {
					$search = trim(xss_filter($this->input->post('search')['value'], 'xss'));
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $search);
						} else {
						$this->db->or_like($item, $search);
					}
					if (count($this->_column_search) - 1 == $i) {
						$this->db->group_end();
					}
				}
				$i++;
			}
			
			// Ordering
			if (!empty($this->input->post('order'))) {
				$colIndex = $this->input->post('order')[0]['column'];
				$dir = $this->input->post('order')[0]['dir'];
				$this->db->order_by($this->_column_order[$colIndex], $dir);
				} else {
				$this->db->order_by('t_post.id', 'DESC');
			}
			
			$this->db->group_by('t_post.id');
		}
		
		
		
		public function ajax_tags($input = '')
		{
			$q = clean_tag($input);
			$query = $this->db
			->select('title')
			->like('title',$q)
			->order_by('title','ASC')
			->get('t_tag');
			$query = $query->result_array();
			if (!$query)
			{
				$result = [[ 'title' => $q ]];
			}
			else
			{
				$result = $query;
			}
			return $result;
		}
		
		
		public function insert_post($data)
		{
			$this->db->insert($this->_table,$data);
		}
		
		
		public function insert_tag($data)
		{
			$tagtitle = $data;
			$tagseo = seotitle($data);
			$cek_tag = $this->db->where("BINARY seotitle='$tagseo'", NULL, FALSE)->get('t_tag')->num_rows();
			
			if ( $cek_tag == 0 && !empty($tagtitle) )
			{
				$data_tag = array(
				'title' => $tagtitle,
				'seotitle' => $tagseo
				);
				$this->db->insert('t_tag', $data_tag);
			}
		}
		
		
		public function update_post($id_post, array $data)
		{
			if ( $this->cek_id($id_post) == 1 )
			{
				$this->db->where('id', $id_post)->update($this->_table, $data);
				return TRUE;
			}
			else
			return FALSE;
		}
		
		
		public function soft_delete($id)
		{
			if ( $this->cek_id($id) == 1 ) 
			{
				$this->db->where('id', $id);
				$this->db->update('t_post', ['active' => 'T','is_deleted' => 1]);
				$respon = TRUE;
			}
			else
			{
				$respon = FALSE;
			}
			
			return $respon;
		}
		
		public function delete($id)
		{
			if ( $this->cek_id($id) == 1 ) 
			{
				$this->db->where('id', $id)->delete($this->_table);
				$respon = TRUE;
			}
			else
			{
				$respon = FALSE;
			}
			
			return $respon;
		}
		
		
		public function get_post($id_post)
		{
			$query = $this->db->select('*,
			t_post.id            AS post_id,
			t_post.title         AS post_title,
			t_post.seotitle      AS post_seotitle,
			t_post.content       AS post_content,
			t_post.caption,
			t_post.penulis,
			t_post.headline      AS post_headline,
			t_post.active        AS post_active,
			t_post.tag           AS post_tag,
			t_post.picture       AS post_picture,
			t_post.image_caption AS image_caption,
			t_category.id        AS category_id,
			t_category.title     AS category_title,
			t_category.seotitle  AS category_seotitle,
			t_user.id            AS user_id,
			t_user.name          AS user_name,
			t_user.key_group     AS user_group
			');
			$query = $this->db->join('t_category', 't_category.id = t_post.id_category', 'left');
			$query = $this->db->join('t_user', 't_user.id = t_post.id_user', 'left');
			$query = $this->db->where('t_post.id', $id_post);
			$query = $this->db->get('t_post');
			$result = $query->row_array();
			return $result;
		}
		
		
		public function get_detail($id_post) 
		{
			$query_post = $this->db
			->select('
			t_post.id             AS  post_id,
			t_post.title          AS  post_title,
			t_post.seotitle       AS  post_seotitle,
			t_post.active         AS  post_active,
			t_post.content,
			t_post.caption,
			t_post.penulis,
			t_post.picture,
			t_post.image_caption,
			t_post.datepost,
			t_post.timepost,
			t_post.tag,
			t_post.hits,
			t_post.comment        AS  post_comment,
			t_category.id         AS  category_id,
			t_category.title      AS  category_title,
			t_category.seotitle   AS  category_seotitle,
			t_user.name           AS  user_name
			')
			->join('t_category', 't_category.id = t_post.id_category', 'left')
			->join('t_user', 't_user.id = t_post.id_user', 'left')
			->where('t_post.id', $id_post)
			->get('t_post');
			
			$post = $query_post->row_array();
			
			$query_comment = $this->db
			->where('id_post', $id_post)
			->where("active != 'N'", NULL, FALSE)
			->get('t_comment')
			->num_rows();
			
			$count_comment = array('comment' => $query_comment);
			$result = array_merge($post, $count_comment);
			
			return $result;
		}
		
		
		public function num_comment($id)
		{
			$query = $this->db->where('id_post', $id);
			$query = $this->db->get('t_comment');
			$result = $query->num_rows();
			return $result;
		}
		
		public function get_all_category()
		{
			$this->db->select('id, id_parent, title');
			$this->db->order_by('id_parent ASC, title ASC');
			$query = $this->db->get('t_category');
			$result = $query->result_array();
			
			return $result;
		}
		
		// susun jadi tree
		public function build_tree($elements, $parentId = 0) {
			$branch = [];
			
			foreach ($elements as $element) {
				if ((int)$element['id_parent'] === (int)$parentId) {
					$children = $this->build_tree($elements, $element['id']);
					if ($children) {
						$element['children'] = $children;
					}
					$branch[] = $element;
				}
			}
			
			return $branch;
		}
		
		
		
		public function get_all_categorys()
		{
			$query = $this->db->select('id,id_parent,title')
			->order_by('title', 'ASC')
			->get('t_category');
			
			$result = $query->result_array();
			
			// susun jadi parent → child
			$categories = [];
			foreach ($result as $row) {
				if ($row['id_parent'] == 0) {
					$categories[$row['id']] = $row;
					$categories[$row['id']]['children'] = [];
				}
			}
			
			foreach ($result as $row) {
				if ($row['id_parent'] != 0 && isset($categories[$row['id_parent']])) {
					$categories[$row['id_parent']]['children'][] = $row;
				}
			}
			
			return $categories;
		}
		
		
		
		
		public function val_cat($id)
		{
			$query = $this->db->where('id', $id);
			$query = $this->db->get('t_category');
			$result = $query->row_array();
			return $result;
		}
		
		
		public function get_all_tag() 
		{
			$query = $this->db->order_by('title', 'ASC');
			$query = $this->db->get('t_tag');
			$result = $query->result_array();
			return $result;
		}
		
		
		public function valtag($tags = '')
		{
			$tag = '';
			if ( !empty($tags) )
			{
				$arrtags = explode(',', $tags);
				foreach ($arrtags as $key) 
				{
					$query = $this->db->select('title');
					$query = $this->db->where('seotitle', $key);
					$query = $this->db->get('t_tag');
					
					if ( $query->num_rows() > 0 ) 
					$tag .= $query->row_array()['title'].',';
				}
			}
			return rtrim($tag,',');
		}
		
		
		public function get_all_user() 
		{
			$query = $this->db->select('id,name');
			$query = $this->db->where('active', 'Y');
			$query = $this->db->get('t_user');
			$result = $query->result_array();
			return $result;
		}
		
		
		public function cek_id($id)
		{
			$num_rows = 0;
			
			if ( $this->session_group == 'root' || $this->session_group == 'admin' )
			{
				$num_rows = $this->db->select('id');
				$num_rows = $this->db->where('id', $id);
				$num_rows = $this->db->get($this->_table);
				$num_rows = $num_rows->num_rows();
			}
			else
			{
				$num_rows = $this->db->select('id');
				$num_rows = $this->db->where('id_user', $this->session_key);
				$num_rows = $this->db->where('id', $id);
				$num_rows = $this->db->get($this->_table);
				$num_rows = $num_rows->num_rows();
			}
			
			return $num_rows;
		}
		
		
		public function cek_seotitle($seotitle)
		{
			$query = $this->db->where("BINARY seotitle = '$seotitle'", NULL, FALSE);
			$query = $this->db->get($this->_table);
			$result = $query->num_rows();
			
			if ( $result == 0 )
			return TRUE;
			else 
			return FALSE;
		}
		
		
		public function cek_seotitle2($id, $seotitle)
		{
			$cek = $this->db->where("BINARY seotitle = '$seotitle'", NULL, FALSE)->get($this->_table);
			if (
			$cek->num_rows() == 1 && 
			$cek->row_array()['id'] == $id || 
			$cek->num_rows() != 1
			) 
			{
				return TRUE;
			}
			else 
			{
				return FALSE;
			}
		}	
	} // End class.									