<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Album extends Web_controller {
		
		public function __construct()
		{
			parent::__construct();
			$this->load->model('web/album_model');
			$this->load->model('web/gallery_model');
		}
		
		public function index($get_seotitle = NULL, $get_page = 1)
		{
			$seotitle = xss_filter($get_seotitle ,'xss');
			$check_seotitle = $this->album_model->check_seotitle($seotitle);
			if ( !empty($seotitle) && $check_seotitle == TRUE ) 
			{
				$id_album = $this->album_model->get_id_album_by_seo($seotitle)->id; 
				$this->vars['album_title'] = $this->gallery_model->get_album($id_album);
				$this->vars['all_gallery_image'] = $this->album_model->get_gallery_images($id_album);
				$this->render_view('gallery');
				}else{
				$this->vars['all_album_image'] = $this->album_model->all_album_image();
				$this->meta_title('Album - '.get_setting('web_name'));
				$this->render_view('album');
			}
		}
	} // End class.				