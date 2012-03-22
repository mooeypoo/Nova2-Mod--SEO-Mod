<?php
/*
|---------------------------------------------------------------
| NovaSEO MODEL
|---------------------------------------------------------------
|
| File: models/novaseo_model.php
| System Version: 2.0
|
| Model used to create and manipulate xml maps and SEO features for Nova2
|
*/

class Seo_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}

	/********************/
	/***** SITEMAPS *****/
	/********************/
	public function get_all_sitemaps($display = 'y', $parent = 0, $type='sitemap') {
	
		$this->db->from('modseo_sitemaps');
		
		if ( ! empty($display)) {
			$this->db->where('active', $display);
		}
		if ( ! empty($type)) {
			$this->db->where('type', $type);
		}
		if ((int)($parent)>=0) {
			$this->db->where('map_parent', $parent);
		}
		
		$query = $this->db->get();
		
		return $query;
	}

	public function get_sitemap($id = '', $return = '') {
		$this->db->from('modseo_sitemaps');
		$this->db->where('id', $id);
		$query = $this->db->get();

		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}

	public function add_sitemap($data = '') {
		$query = $this->db->insert('modseo_sitemaps', $data);
		
		$this->dbutil->optimize_table('modseo_sitemaps');
		return $query;
	}
	
	public function update_sitemap($id = '', $data = '') {
		$this->db->where('id', $id);
		$query = $this->db->update('modseo_sitemaps', $data);
		
		$this->dbutil->optimize_table('modseo_sitemaps');
		
		return $query;
	}
	
	public function delete_sitemap($id = '') {
		$query = $this->db->delete('modseo_sitemaps', array('id' => $id));
		
		$this->dbutil->optimize_table('modseo_sitemaps');
		
		return $query;
	}

	
	/********************/
	/***** SECTIONS *****/
	/********************/
	
	public function get_all_sections($id = '') {
	
		$this->db->from('modseo_sections');
		if (!empty($id)) {
			$this->db->where('id', $id);
		}
				
		$query = $this->db->get();
		
		return $query;
	}

	public function get_section($id = '', $return = '') {
		$this->db->from('modseo_sections');
		$this->db->where('id', $id);
		$query = $this->db->get();

		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}

	public function add_section($data = '') {
		$query = $this->db->insert('modseo_sections', $data);
		
		$this->dbutil->optimize_table('modseo_sections');
		return $query;
	}

	public function update_section($id = '', $data = '') {
		$this->db->where('id', $id);
		$query = $this->db->update('modseo_sections', $data);
		
		$this->dbutil->optimize_table('modseo_sections');
		
		return $query;
	}
 	
	public function delete_section($id = '') {
		$query = $this->db->delete('modseo_sections', array('id' => $id));
		
		$this->dbutil->optimize_table('modseo_sections');
		
		return $query;
	}

	/*****************/
	/***** LINKS *****/
	/*****************/
	public function get_all_links($section_id = 0) {
	
		$this->db->from('modseo_custom_links');

		if ((!empty($section_id)) && ((int)($section_id) > 0)) {
			$this->db->where('section_id', $section_id);
		}
		
		$query = $this->db->get();
		
		return $query;
	}

	public function get_model_links($model = false) {
	
		if (!empty($model)) {
		
			switch ($model) {
				case "users":
					$this->db->from('users');
					$this->db->where('status', 'active');
					$urlpiece = 'personnel/user';

					$query = $this->db->get();
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $mod) {
							$arr[$mod->userid]['name'] = $mod->name;
							$arr[$mod->userid]['link'] = $urlpiece.'/'.$mod->userid;
						}
					}
					
					break;
				case "characters":
					$this->db->from('characters');
					$this->db->where('crew_type', 'active');
					$this->db->or_where('crew_type', 'npc');
					$urlpiece = 'personnel/character';

					$query = $this->db->get();
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $mod) {
							$arr[$mod->charid]['name'] = $mod->first_name.' '.$mod->middle_name.' '.$mod->last_name.' '.$mod->suffix;
							$arr[$mod->charid]['link'] = $urlpiece.'/'.$mod->charid;
						}
					}
					break;
				case "posts":
					break;
				case "logs":
					break;
				case "news":
					break;
			}			
			
			
			return $arr;
		}
	}


	public function get_link($id = '', $return = '') {
		$this->db->from('modseo_custom_links');
		$this->db->where('id', $id);
		$query = $this->db->get();

		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}

	public function add_link($data = '') {
		$query = $this->db->insert('modseo_custom_links', $data);
		
		$this->dbutil->optimize_table('modseo_custom_links');
		return $query;
	}

	public function update_link($id = '', $data = '') {
		$this->db->where('id', $id);
		$query = $this->db->update('modseo_custom_links', $data);
		
		$this->dbutil->optimize_table('modseo_custom_links');
		
		return $query;
	}
 	
	public function delete_link($id = '') {
		$query = $this->db->delete('modseo_custom_links', array('id' => $id));
		
		$this->dbutil->optimize_table('modseo_custom_links');
		
		return $query;
	}

	/******************/
	/***** ROBOTS *****/
	/******************/
	public function robots_read() {
		
	}
	
	
}