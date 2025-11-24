<?php
	/**
		* - This file was created using CoGen
		* 
		* - Date created : 2025-08-04 | 12:23
		* - Author       : CiFireCMS
		* - License      : MIT License
	*/
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Podcast extends Backend_Controller {
		
		public $mod = 'podcast';
		
		public function __construct() 
		{
			parent::__construct();
			
			$this->load->model("mod/podcast_model");
			$this->meta_title("Podcast");
		}
		
		
		public function index()
		{
			if ($this->role->i('read'))
			{
				if ($this->input->is_ajax_request()) 
				{
					if ($this->input->post('act')=='delete') {
						return $this->_delete();
					}
					else
					{
						
						
						$data = array();
						// $this->db->order_by('position', 'ASC');
						foreach ($this->podcast_model->datatable('_data', 'data') as $val) 
						{
							// status
							 
							$row = [
							'id'       => $val['id'],        // diperlukan oleh rowReorder
							'position' => $val['position'],  // kolom urutan
							'checkbox' => '<div class="text-center"><input type="checkbox" class="row_data" value="'. encrypt($val['id']) .'"></div>',
							'title'    => $val['title'],
							'audio'    => $val['link_audio'],
							'tanggal'  => ltrim(ci_date($val['tanggal'],'d F Y'),'0').' <br/> <small>'.ltrim(ci_date($val['tanggal'],'H:i'),'0').'</small>',
							'status'   => ($val['active'] == 'Y' ? '<span class="badge badge-outline-success">'. lang_line('ui_publish') .'</span>' : '<span class="badge badge-outline-default">'. lang_line('ui_draft') .'</span>'),
							'action'   => '<div class="text-center"><div class="btn-group">
							<button type="button" onclick="location.href=\''. admin_url($this->mod."/edit/".$val['id']) .'\'" class="btn btn-xs btn-white" data-toggle="tooltip" data-placement="top" data-title="'. lang_line('button_edit') .'"><i class="cificon licon-edit"></i></button>
							<button type="button" class="btn btn-xs btn-white delete_single" data-toggle="tooltip" data-placement="top" data-title="'.lang_line('button_delete').'" data-pk="'. encrypt($val['id']) .'"><i class="cificon licon-trash-2"></i></button>
							</div></div>'
							];
							
							$data[] = $row;
						} // endforeach.
						
						$this->json_output(['data' => $data, 'recordsFiltered' => $this->podcast_model->datatable('_data', 'count')]);
					}
					
				}
				else
				{
					$this->vars['penceramah'] = $this->podcast_model->get_all_penceramah();
					$this->render_view('view_index');
				}
			}
			else
			{
				$this->render_403();
			}
		}
		
		
		public function add()
		{
			if ($this->role->i('write') ) 
			{
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules(array(array(
					'field' => 'id_penceramah',
					'label' => 'Id Penceramah',
					'rules' => 'trim'
					)));
					
					$this->form_validation->set_rules(array(array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'trim'
					)));
					
					$this->form_validation->set_rules(array(array(
					'field' => 'link_audio',
					'label' => 'Link Audio'
					)));
					
					$this->form_validation->set_rules(array(array(
					'field' => 'tanggal',
					'label' => 'Tanggal',
					'rules' => 'trim'
					)));
					
					$this->form_validation->set_rules(array(array(
					'field' => 'active',
					'label' => 'Active',
					'rules' => 'trim'
					)));
					
					if ($this->form_validation->run())
					{
						
						
						$input_category = decrypt($this->input->post('id_penceramah'));
						$id_penceramah = (!empty($input_category) ? $input_category : '1');
						
						$lastPosition = $this->db
						->select_max('position')
						->where('id_penceramah', $id_penceramah)
						->get('t_podcast')
						->row()
						->position;
						
						$position = ($lastPosition !== null) ? $lastPosition + 1 : 1;
						
						$data_isert = array(
						'id_penceramah' => $id_penceramah,
						'id_user' => decrypt(login_key()),
						'title' => xss_filter($this->input->post('title')),
						'title_seo' => seotitle($this->input->post('title', TRUE)),
						'link_audio' => xss_filter($this->input->post('link_audio')),
						'tanggal' => xss_filter($this->input->post('tanggal')),
						'position' => $position,
						'active' => xss_filter($this->input->post('active')),
						);
						
						if ($this->podcast_model->insert($data_isert))
						{
							$this->cifire_alert->set($this->mod, 'info', 'Data has been successfully added');
							redirect(admin_url($this->mod),'refresh');
						}
						else
						{
							$this->cifire_alert->set($this->mod, 'danger', "Oups..! Some error occurred.<br>Please complete the data correctly");
						}
					}
				}
				else
				{
					
					$this->vars['penceramah'] = $this->podcast_model->get_all_penceramah();
					$this->render_view('view_add');
				}
			}
			else
			{
				$this->render_403();
			}
		}
		
		
		public function edit($id_data = '')
		{
			if ($this->role->i('modify'))
			{
				$id_edit = xss_filter($id_data, 'sql');
				$cek_id = $this->podcast_model->cek_id($id_edit);
				
				if ($cek_id == 1) 
				{
					if ($this->input->method() == 'post')
					{
						$this->form_validation->set_rules(array(array(
						'field' => 'id_penceramah',
						'label' => 'Id Penceramah',
						'rules' => 'trim'
						)));
						
						$this->form_validation->set_rules(array(array(
						'field' => 'title',
						'label' => 'Title',
						'rules' => 'trim'
						)));
						
						$this->form_validation->set_rules(array(array(
						'field' => 'link_audio',
						'label' => 'Link Audio'
						)));
						
						$this->form_validation->set_rules(array(array(
						'field' => 'tanggal',
						'label' => 'Tanggal',
						'rules' => 'trim'
						)));
						
						$this->form_validation->set_rules(array(array(
						'field' => 'active',
						'label' => 'Active',
						'rules' => 'trim'
						)));
						
						if ( $this->form_validation->run() )
						{
							$input_category = decrypt($this->input->post('id_penceramah'));
							$id_penceramah = (!empty($input_category) ? $input_category : '1');
							$data_update = array(
							'id_penceramah' => $id_penceramah,
							'title' => xss_filter($this->input->post('title')),
							'title_seo' => seotitle($this->input->post('title', TRUE)),
							'link_audio' => xss_filter($this->input->post('link_audio')),
							'tanggal' => xss_filter($this->input->post('tanggal')),
							'active' => xss_filter($this->input->post('active')),
							);
							
							if ($this->podcast_model->update($id_edit, $data_update))
							{
								$this->cifire_alert->set($this->mod, 'info', 'Data has been successfully updated');
							}
							else
							{
								$this->cifire_alert->set($this->mod, 'danger', "Oups..! Some error occurred.<br>Please complete the data correctly");
							}
						}
					}
					$this->vars['penceramah'] = $this->podcast_model->get_all_penceramah();
					$data_edit = $this->podcast_model->get_data_edit($id_edit);
					$this->vars['data_row'] = $data_edit;
					$this->render_view('view_edit');
				}
				else
				{
					$this->render_404();
				}
			}
			else
			{
				$this->render_403();
			}
		}
		
		
		private function _delete()
		{
			if ($this->input->is_ajax_request())
			{
				if ($this->role->i('delete'))
				{
					$data = $this->input->post('data');
					
					foreach ($data as $key)
					{
						$pk = xss_filter(decrypt($key),'sql');
						$this->podcast_model->delete($pk);
					}
					
					$response['success'] = true;
					$this->json_output($response);
				}
				else
				{
					$response['success'] = false;
					$this->json_output($response);
				}
			}
			else
			{
				show_403();
			}
		}
		
		public function update_order()
		{
			$order = $this->input->post('order');
			// dump($_POST);
			if ($order && is_array($order)) {
				foreach ($order as $item) {
					$id = (int)$item['id'];
					$position = (int)$item['position'];
					$this->db->where('id', $id);
					$this->db->update('t_podcast', ['position' => $position]);
				}
				echo json_encode(['status' => true]);
				} else {
				echo json_encode(['status' => false, 'message' => 'Invalid input']);
			}
		}
		
	} // End Class.												