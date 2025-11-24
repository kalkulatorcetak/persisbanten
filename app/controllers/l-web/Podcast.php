<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Podcast extends Web_controller {
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('web/podcast_model');
		}
		
		public function index($get_seotitle = NULL, $get_page = 1)
		{
			
			
			$seotitle = xss_filter($get_seotitle ,'xss');
			$check_seotitle = $this->podcast_model->check_seotitle($seotitle);
		 
			if ( !empty($seotitle) && $check_seotitle == TRUE ) 
			{
				$result_category = $this->podcast_model->get_data($seotitle);
				$get_page = xss_filter($get_page, 'sql');
				$page     = ($get_page==0 ? 1 : $get_page);
				$batas    = get_setting('page_item');
				$posisi   = ($page-1) * $batas;
				
				$config['base_url']     = site_url('podcast/'.$seotitle.'/');
				$config['index_page']   = $page;
				$config['total_rows']   = $this->podcast_model->total_category_post($result_category['id']);
				
				$this->cifire_pagination->initialize($config);
				
				$this->vars['page_link']       = $this->cifire_pagination->create_links();
				$this->vars['result_category'] = $result_category;
				$this->vars['seotitle'] = $seotitle;
				$this->vars['data_post']   = $this->podcast_model->get_post($result_category['id'], $batas, $posisi);
				// dump($this->vars['data_post']);
				if ( $this->vars['data_post'] ) 
				{
					$this->meta_title($result_category['title'].' - '.get_setting('web_name'));
					$this->meta_keywords($result_category['title'].', '.get_setting('web_keyword'));
					$this->meta_description($result_category['description']);
					$this->meta_image(post_images($result_category['picture'],'medium',TRUE));
					$this->vars['penceramah']   =$result_category['title'];
					$this->render_view('podcast_detail');
				}
				else
				{
					$this->render_404();
				}
				}else{
				$get_page = xss_filter($this->input->get('page'),'sql');
				$page   = ($get_page==0 ? 1 : $get_page);
				$batas  = get_setting('page_item');
				$posisi = ($page-1) * $batas;
				
				$config['base_url']   = site_url($this->mod.'?page=');
				$config['index_page'] = $page;
				$config['total_rows'] = $this->podcast_model->total_post_penceramah();
				$this->cifire_pagination->initialize($config);
				$this->vars['page_link'] = $this->cifire_pagination->create_links();
				
				$data_post = $this->podcast_model->index_penceramah($batas, $posisi);
				// dump($data_post);
				if ($data_post)
				{
					$this->vars['data_post'] = $data_post;
					
					$this->meta_title('Podcast - '. get_setting('web_name'));
					// dump($this->vars['data_post']);
					$this->render_view('podcast');
				}
				else
				{
					$this->render_404();
				}
			}
		}
		
		public function detail($get_seotitle = NULL, $get_page = 1)
		{
			$getSegments = $this->uri->segment(count($this->uri->segments));
			$getSeotitle = seotitle($getSegments);
			$check_seotitle = $this->podcast_model->check_seopodcast($getSeotitle);
			if ( !empty($getSeotitle) && $check_seotitle == TRUE ) 
			{
				
				$result_pod = $this->podcast_model->get_podcast($getSeotitle);
				$this->vars['podcast']   = $result_pod;
				
				if ( $this->vars['podcast'] ) 
				{
					$this->vars['penceramah']   = $this->podcast_model->get_penceramah($result_pod['id_penceramah']);
					$this->meta_title($result_pod['title'].' - '.get_setting('web_name'));
					$this->meta_keywords($result_pod['title'].', '.get_setting('web_keyword'));
					$this->meta_description($result_pod['description']);
					$this->meta_image(post_images($result_pod['picture'],'medium',TRUE));
					$this->render_view('podcast_single');
				}
				else
				{
					$this->render_404();
				}
			}
			else
			{
				//$this->render_view('podcast');
			}
		}
		public function crud()
		{
			$id = $this->input->post('id');
			$exp = explode('-',$id);
			$id = xss_filter($exp[1], 'sql');
			// Cek apakah data dengan id_post ada
			$this->CI->db->select('count');
			$this->CI->db->where('id', $id);
			$query = $this->CI->db->get('t_podcast');
			
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$new_count = $row->count + 1;
				
				// Update count
				$this->CI->db->set('count', $new_count);
				$this->CI->db->where('id', $id);
				$updated = $this->CI->db->update('t_podcast');
				
				if ($updated) {
					$response = ['status'=>'ok','count'=>$new_count];
					} else {
					$response = array('error');
				}
				} else {
				$response = array('error');
			}
			$this->json_output($response);
		}
	} // End class.															