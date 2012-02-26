<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SEO controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Moriel Schottlender
 * @copyright	2012 Moriel Schottlender GNU
 */

require_once MODPATH.'core/controllers/nova_admin.php';

class Seo extends Nova_admin {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($action = false) {
		// load the resources
		$this->load->model('seo_model', 'seo');

		$this->load->model('depts_model', 'depts');
		$this->load->model('news_model', 'news');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('posts_model', 'posts');
		$this->load->model('users_model', 'users');
		$this->load->model('characters_model', 'chars');
		// set the variables
		$js_data['tab'] = 0;
		$js_data['tab_general'] = 0;
		if (isset($_POST['submit'])) {
			switch ($action) {
				case 'settings':
					$js_data['tab'] = 0; //'#one';
					$seo_desc = $this->input->post('seo_desc', true);
					$seo_tags = $this->input->post('seo_tags', true);

					$update_array['setting_value'] = $seo_desc;
					$update[0] = $this->settings->update_setting('seo_meta_desc', $update_array);

					$update_array['setting_value'] = $seo_tags;
					$update[1] = $this->settings->update_setting('seo_meta_tags', $update_array);
					if (($update[0] > 0) && ($update[1] > 0)) {
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('labels_site') .' '. lang('labels_settings')),
							lang('actions_updated'),
							''
						);
						
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					} else {
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('labels_site') .' '. lang('labels_settings')),
							lang('actions_updated'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					// set the flash message
					$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
					break;
				case 'addmap':
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 0;
					$map_name = $this->input->post('map_name', true);
					$map_type = $this->input->post('map_type', true);
					$map_parent = $this->input->post('map_parent', true);

					$insert_array = array(
						'name' => $this->security->xss_clean($map_name),
						'type' => $this->security->xss_clean($map_type),
						'map_parent' => $this->security->xss_clean($map_parent),
						'user_created' => 'y',
						'active' => 'y',
					);
					
					$insert = $this->seo->add_sitemap($insert_array);
					if ($insert > 0) {
						$message = "Sitemap was successfully added.";
						

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					} else {
						$message = "There was a problem adding the sitemap. Please try again later. Contact your administrator if this persists or file a bug report.";

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				
					break;
				case "delmap":
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 0;
					$mid = $this->input->post('mapid', true);
					// get all sitemaps assigned to the sitemap
					
					$submaps = $this->seo->get_all_sitemaps('', $mid, '');
					if ($submaps->num_rows() > 0)
					{
						$update = 0;
						
						// reassign the departments to unassigned
						foreach ($submaps->result() as $smap) {
							$update += $this->seo->update_sitemap($smap->id, array('map_parent' => 0));
						}
						
						if ($submaps->num_rows() == $update) {
							// delete the manifest
							$delete = $this->seo->delete_sitemap($mid);
							
							if ($delete > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_site').' sitemap'),
									lang('actions_deleted'),
									''
								);
		
								$flash['status'] = 'success';
								$flash['message'] = text_output($message);
							}
							else
							{
								$message = sprintf(
									lang('flash_failure'),
									ucfirst(lang('labels_site').' sitemap'),
									lang('actions_deleted'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						} else {
							$message = "The system could not reassign some of the child sitemaps. You might have to edit some sitemaps manually. <strong>Delete aborted.</strong>";
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					} else {
						// delete the manifest
						$delete = $this->seo->delete_sitemap($mid);
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_site').' sitemap'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('labels_site').' sitemap'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
					break;
				case 'editmap':
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 0;
					// get the ID
					$id = $this->input->post('id', true);
					$sections = $this->input->post('chkSections', true);

					$update_array = array(
						'name' => $this->security->xss_clean($this->input->post('map_name', true)),
						'type' => $this->security->xss_clean($this->input->post('map_type', true)),
						'map_parent' => $this->security->xss_clean($this->input->post('map_parent', true)),
						'sections' => implode(',',$sections)
					);
										
					// update the record
					$update = $this->seo->update_sitemap($id, $update_array);
					if ($update > 0) {
											
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site').' sitemap'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_site').' sitemap'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
				case 'addsection':
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 1;
					$sec_title = $this->input->post('sec_title', true);
					$sec_desc = $this->input->post('sec_desc', true);
					
					$insert_array = array(
						'section_title' => $this->security->xss_clean($sec_title),
						'section_type' => 'custom',
						'section_locked' => 'n',
						'section_description' => $this->security->xss_clean($sec_desc),
					);
					
					//print_r($insert_array);
					//exit;
					
					$insert = $this->seo->add_section($insert_array);
					if ($insert > 0) {
						$message = "Section was successfully added.";
						

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					} else {
						$message = "There was a problem adding the section. Please try again later. Contact your administrator if this persists or file a bug report.";

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				
					break;
				case "delsection":
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 1;
					$id = $this->input->post('id', true);
					// get all sitemaps assigned to the sitemap
						$delete = $this->seo->delete_section($id);
					
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_site').' section'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('labels_site').' section'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					break;
				case 'editsection':
					$js_data['tab'] =1; //'#two';
					$js_data['tab_general'] = 1;
					// get the ID
					$id = $this->input->post('id', true);
					$sec_title = $this->input->post('sec_title', true);
					$sec_desc = $this->input->post('sec_desc', true);

					$update_array = array(
						'section_title' => $this->security->xss_clean($sec_title),
						'section_description' => $this->security->xss_clean($sec_desc)
					);
										
					// update the record
					$update = $this->seo->update_section($id, $update_array);
					if ($update > 0) {
											
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site').' section'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_site').' section'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
			}
		} //end $_POST condition
	

		// get all sitemaps
		$sitemaps = $this->seo->get_all_sitemaps('y',-1,'');
			
		if ($sitemaps->num_rows() > 0) {
			foreach ($sitemaps->result() as $s) {
				//sections in the map:
				unset($sectionlist);
				unset($stemp);
				$mapsections = '';

				$sectionlist = explode(',',$s->sections);
				if (count($sectionlist) > 0) {
					foreach ($sectionlist as $sid) {
						$stemp[] = $this->seo->get_section($sid, 'section_title');
					}
				}

				if (count($stemp)>0) { 
					$mapsections = implode(', ',$stemp); 
				}
				if ($s->map_parent > 0) {
					$data['sitemaps'][$s->map_parent]['sub'][$s->id] = array(
						'id' => $s->id,
						'name' => $s->name,
						'type' => $s->type,
						'parent' => $s->map_parent,
						'active' => $s->active,
						'sections' => $mapsections,
					);
				} else {
					$data['sitemaps'][$s->id] = array(
						'id' => $s->id,
						'name' => $s->name,
						'type' => $s->type,
						'parent' => $s->map_parent,
						'active' => $s->active,
						'sections' => $mapsections,
					);
				}
			}
		}
		
		$data['label'] = array(
			'assign' => 'Assign Sections to Sitemaps',
			'add' => 'Add Sitemap',
			'del' => 'Delete Sitemap',
			'off' => 'Inactive'
		);
		
		$data['buttons'] = array(
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_add'))),
		);
		
		$settings_array = array(
			'sim_name',
			'seo_meta_desc',
			'seo_meta_tags'
		);
		// set the options
		$options = $this->settings->get_settings($settings_array);
		
		$data['data']['seo_tags'] = $options['seo_meta_tags'];
		$data['data']['seo_desc'] = $options['seo_meta_desc'];
		
		$data['label']['seo_header_one'] = 'General SEO';
		$data['label']['seo_header_two'] = 'Sitemaps';
		$data['label']['seo_header_three'] = 'Custom Sections';
		$data['label']['seo_header_four'] = 'Robots.txt File';

		$data['inputs'] = array(
			'sitemaps' => array(
				'name' => array(
					'name' => 'map_name',
					'id' => 'map_name'),
				'button' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
				),
			'sections' => array(
				'name' => array(
					'name' => 'sec_title',
					'id' => 'sec_title'),
				'button' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
				),
		);
		$data['inputopts']['sitemaps'] = array(
			'type' => array(
				'index' => 'Index Map',
				'sitemap' => 'Sitemap'
			)
		);
		
		// get all indeces
		$indexmaps = $this->seo->get_all_sitemaps('y',-1,'index');
		$data['inputopts']['sitemaps']['parent'][0] = 'None'; 

		if ($indexmaps->num_rows() > 0) {
			foreach ($indexmaps->result() as $s) {
				if ($s->parent == 0) {
					$data['inputopts']['sitemaps']['parent'][$s->id] = $s->name; 
				} else {
					$data['inputopts']['sitemaps']['parent'][$s->id] = "-- ".$s->name; 
				}
			}
		}

		// get all sections
		$sections = $this->seo->get_all_sections();
		if ($sections->num_rows() > 0) {
			foreach ($sections->result() as $sec) {
				if ($sec->section_locked == 'y') { //locked
					$data['sections']['locked'][$sec->id] = array(
						'id' => $sec->id,
						'title' => $sec->section_title,
						'type' => $sec->section_type,
						'model' => $sec->section_model,
					);
				} else { //custom
					//find out how many links are in this section:
					$linknum = 0;
					$links = $this->seo->get_all_links($sec->id);
					$linknum = $links->num_rows();
					$data['sections']['custom'][$sec->id] = array(
						'id' => $sec->id,
						'title' => $sec->section_title,
						'type' => $sec->section_type,
						'model' => $sec->section_model,
						'links' => $linknum,
					);
				}
			}
		}
		
		
		$data['images'] = array(
			'logo' => array(
				'src' => Location::asset('images/modseo','novaSEO.png'),
				'alt' => 'NovaSEO Mod by mooeypoo'),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_edit'))),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_delete'))),
			'assign' => array(
				'src' => Location::img('property-import.png', $this->skin, 'admin'),
				'alt' => 'Assing links to section',
				'class' => 'image'),
			'refresh' => array(
				'src' => Location::img('arrow-circle-double-135.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);

		$data['header'] = "NovaSEO Configuration Page";
		
		$view_loc = "seo_index";
		$view_loc_js = "seo_index_js";
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js($view_loc_js, $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}

	public function sections($id = false, $action = false) {
		// load the resources
		$this->load->model('seo_model', 'seo');

		$this->load->model('depts_model', 'depts');
		$this->load->model('news_model', 'news');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('posts_model', 'posts');
		$this->load->model('users_model', 'users');
		$this->load->model('characters_model', 'chars');

		// set the variables
		$js_data['tab'] = 0;
		$err = '';

		if (isset($_POST['submit'])) {
			switch ($action) {
				case 'addlink':
					$link_title = $this->input->post('link_title', true);
					$link_url = $this->input->post('link_url', true);
					$section_id = $this->input->post('secid', true);
					
					$insert_array = array(
						'title' => $this->security->xss_clean($link_title),
						'link' => $this->security->xss_clean($link_url),
						'section_id' => $section_id,
					);
					
					$insert = $this->seo->add_link($insert_array);
					if ($insert > 0) {
						$message = "Link was successfully added.";
						

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					} else {
						$message = "There was a problem adding the link. Please try again later. Contact your administrator if this persists or file a bug report.";

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				
					break;
				case "dellink":
					$js_data['tab'] = 2;//'#three';
					$linkid = $this->input->post('id', true);
					$section_id = $this->input->post('secid', true);
					// get all sitemaps assigned to the sitemap
						$delete = $this->seo->delete_link($linkid);
					
						if ($delete > 0) {
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_site').' link'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						} else {
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('labels_site').' link'),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					break;
				case 'editlink':
					$js_data['tab'] = 2;//'#three';
					// get the ID
					$link_title = $this->input->post('link_title', true);
					$link_url = $this->input->post('link_url', true);
					$section_id = $this->input->post('secid', true);
					$linkid = $this->input->post('id', true);

					$update_array = array(
						'title' => $this->security->xss_clean($link_title),
						'link' => $this->security->xss_clean($link_url),
						'section_id' => $section_id
					);
										
					// update the record
					$update = $this->seo->update_link($linkid, $update_array);
					if ($update > 0) {
											
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site').' link'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					} else {
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_site').' link'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
			}
		}

		//get the section:
		if (((int)($id) <= 0) || ($id == false)) {
			$err = 'Section ID not found.';
		}
		
		$section = $this->seo->get_section($id);
		if ($section->locked == 'y') {
			$err = 'This section is locked.';
		}
		$data['err'] = $err;
		
		$data['section'] = array(
			'id' => $section->id,
			'title' => $section->section_title,
			'description' => $section->section_description,
		);
		
		//get all links for this section:
		$links = $this->seo->get_all_links($id);
		if ($links->num_rows() > 0) {
			foreach ($links->result() as $link) {
				$data['links'][$link->id] = array(
					'id' => $link->id,
					'link' => $link->link,
					'title' => $link->title,
				);
			}
		}
		
		
		$data['header'] = 'Section Configuration: '.$section->section_title;
		$data['images'] = array(
			'logo' => array(
				'src' => Location::asset('images/modseo','novaSEO.png'),
				'alt' => 'NovaSEO Mod by mooeypoo'),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_edit'))),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_delete'))),
			'assign' => array(
				'src' => Location::img('property-import.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'refresh' => array(
				'src' => Location::img('arrow-circle-double-135.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		$data['inputs'] = array(
				'title' => array(
					'name' => 'link_title',
					'id' => 'link_title'),
				'link' => array(
					'name' => 'link_url',
					'id' => 'link_url'),
				'button' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
		);
		
		
		$data['label'] = array(
			'add' => 'Add Link',
			'del' => 'Delete Link',
			'off' => 'Inactive'
		);
		
		$this->_regions['content'] = Location::view('seo_sections', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('seo_sections_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
		

	}
	
}
