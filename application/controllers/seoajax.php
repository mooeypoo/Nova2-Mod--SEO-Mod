<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once MODPATH.'core/controllers/nova_ajax.php';

class Seoajax extends Nova_ajax {
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function del_sitemap($id = false) {
		// load the resources
		$this->load->model('seo_model', 'seo');
			$data['id'] = $this->uri->segment(3, 0, true);

			$data['header'] = "Delete Sitemap";
			$data['text'] = "<p><strong>This action is non reversable!</strong> Please be careful.</p><p>If you delete an index, all child sitemaps will be unassigned to it and will remain stand-alone maps.</p>";

			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);

				// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_del_sitemap', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
	}

	public function edit_sitemap() {
//		$allowed = Auth::check_access('seo/index', false);
		
		// load the resources
		$this->load->model('seo_model', 'seo');
			
			$head = "Edit Sitemap";
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;

			
			
			$map = $this->seo->get_sitemap($data['id']);
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'map_name',
					'id' => 'map_name',
					'value' => $map->name),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			$data['map_type'] = $map->map_type;
			
			//get the active sections:
			$map_sections = explode(',',$map->sections);

			$sections = $this->seo->get_all_sections();
			if ($sections->num_rows() > 0) {
				foreach ($sections->result() as $sec) {
					$chk = FALSE;
					if (in_array($sec->id, $map_sections)) {
						$chk = TRUE;
					}
					$data['inputs']['checkboxes'][$sec->id] = array(
					   'name' => "chkSections[]",
						'id' => "chkSections[]",
						'value' => $sec->id,
						'isLocked' => $sec->section_locked,
						'isTitle' => $sec->section_title,
						'checked' => $chk,
						'style' => 'margin-left:10px'				
					);
				}
			}
		
			
			
			$data['inputopts'] = array(
				'type' => array(
					'index' => 'Index Map',
					'sitemap' => 'Sitemap'
				)
			);
			
			$data['selval']['map_type'] = $map->type;
			$data['selval']['map_parent'] = $map->map_parent;
			
			// get all indeces
			$indexmaps = $this->seo->get_all_sitemaps('y',-1,'index');
			$data['inputopts']['parent'][0] = 'None'; 

			if ($indexmaps->num_rows() > 0) {
				foreach ($indexmaps->result() as $s) {
					if ($s->parent == 0) {
						$data['inputopts']['parent'][$s->id] = $s->name; 
					} else {
						$data['inputopts']['parent'][$s->id] = "-- ".$s->name; 
					}
				}
			}

			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_edit_sitemap', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();

	}

	public function edit_section() {
//		$allowed = Auth::check_access('seo/index', false);
		
		// load the resources
		$this->load->model('seo_model', 'seo');
			
			$head = "Edit Section";
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;

			
			
			$sec = $this->seo->get_section($data['id']);
			
			$data['inputs'] = array(
				'title' => array(
					'title' => 'sec_title',
					'id' => 'sec_title',
					'name' => 'sec_title',
					'value' => $sec->section_title),
				'desc' => $sec->section_description,
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_edit_section', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();

	}
	
	public function del_section($id = false) {
		// load the resources
		$this->load->model('seo_model', 'seo');
			$data['id'] = $this->uri->segment(3, 0, true);

			$data['header'] = "Delete Section";
			$data['text'] = "<p><strong>This action is non reversable!</strong> Please be careful.</p><p>Deleting a section will remove it from all associated sitemaps.</p>";

			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);

				// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_del_section', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
	}














	public function edit_link($id = false, $secid = false) {
//		$allowed = Auth::check_access('seo/index', false);
		
		// load the resources
		$this->load->model('seo_model', 'seo');
			
			$head = "Edit Link";
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['section']['id'] = $this->uri->segment(4, 0, true);

			
			
			$link = $this->seo->get_link($data['id']);
			
			$data['inputs'] = array(
				'title' => array(
					'id' => 'link_title',
					'name' => 'link_title',
					'value' => $link->title),
				'link' => array(
					'id' => 'link_url',
					'name' => 'link_url',
					'value' => $link->link),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_edit_link', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();

	}
	
	public function del_link($id = false, $secid = false) {
		// load the resources
		$this->load->model('seo_model', 'seo');

		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['section']['id'] = $this->uri->segment(4, 0, true);


			$data['header'] = "Delete Link";
			$data['text'] = "<p><strong>This action is non reversable!</strong> Please be careful.</p>";

			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);

				// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('seo_del_link', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
	}



	

}
