<?php
	/**
		* - This file was created using CoGen
		* 
		* - Date created : 2025-08-04 | 12:11
		* - Author       : CiFireCMS
		* - License      : MIT License
	*/
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Penceramah_model extends CI_Model {
		
		public $vars;
		private $_table = 't_penceramah';
		private $_column_order = array(null, 'id','title','kategori','active','id');
		private $_column_search = array('id','title','kategori','active','id');
		
		public function __construct()
		{
			parent::__construct();
		}
		
		// Ambil semua data penceramah aktif (misal ada kolom active)
		public function get_all()
		{
			$this->db->select('id, title'); // sesuaikan kolom name
			$this->db->from($this->_table);
			$this->db->where('active', 'Y'); // jika ada filter active
			$this->db->order_by('title', 'ASC');
			$query = $this->db->get();
			
			return $query->result();
		}
		/**
			* Function datatable
			*
			* @param     string    $method (query method)
			* @param     string    $mode ('data' or 'count')
			* @return    void
		*/
		public function datatable($method, $mode = '')
		{
			if ($mode == 'count')
			{
				$this->$method();
				
				$result =  $this->db->get()->num_rows();
			}
			
			elseif (empty($mode) || $mode == 'data')
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
		
		
		private function _data()
		{
			$this->db->select('*');
			$this->db->from($this->_table);
			
			$i = 0;	
			foreach ($this->_column_search as $item) 
			{
				if ($this->input->post('search')['value'])
				{
					if ($i === 0)
					{
						$this->db->group_start();
						$this->db->like($item, $this->input->post('search')['value']);
					}
					else
					{
						$this->db->or_like($item, $this->input->post('search')['value']);
					}
					
					if (count($this->_column_search) - 1 == $i) 
					{
						$this->db->group_end(); 
					}
				}
				$i++;
			}
			
			if (!empty($this->input->post('order'))) 
			{
				$this->db->order_by(
				$this->_column_order[$this->input->post('order')['0']['column']], 
				$this->input->post('order')['0']['dir']
				);
			}
			else
			{
				$this->db->order_by('id', 'DESC');
			}
		}
		
		
		public function insert(array $data)
		{
			$query = $this->db->insert($this->_table, $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		
		public function update($key, $data)
		{
			$query = $this->db->where('id', $key);
			$query = $this->db->update($this->_table, $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		
		public function delete($val = 0)
		{
			if ($this->cek_id($val) == 1) 
			{
				$this->db->where('id', $val)->delete($this->_table);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		
		public function get_data_edit($val_id)
		{
			$query = $this->db->where('id', $val_id);
			$query = $this->db->get($this->_table);
			$result = $query->row_array();
			return $result;
		}
		
		
		public function cek_id($val = 0)
		{
			$query = $this->db->select('id');
			$query = $this->db->where('id', $val);
			$query = $this->db->get($this->_table);
			$query = $query->num_rows();
			$int = (int)$query;
			return $int;
		}
	} // End class.		