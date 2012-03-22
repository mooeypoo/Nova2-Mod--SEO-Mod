<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SEO controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Moriel Schottlender
 * @copyright	2012 Moriel Schottlender GNU
 */

require_once MODPATH.'core/controllers/nova_main.php';
class Sitemap extends Nova_main {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index($map = false, $format = 'xml') {

		// load the resources
		$this->load->model('seo_model', 'seo');

		$data['header'] = "Available Sitemaps";
		
		// get all sitemaps
		$sitemaps = $this->seo->get_all_sitemaps('y',-1,'');
			
		if ($sitemaps->num_rows() > 0) {
			foreach ($sitemaps->result() as $s) {
				//sections in the map:
				unset($sectionlist);


				$sectionlist = explode(',',$s->sections);
				if (count($sectionlist) > 0) {
					foreach ($sectionlist as $sid) {
						$sects = $this->seo->get_all_sections($sid);
						if ($sects->num_rows() > 0) {
							foreach ($sects->result() as $sec) {
								switch ($sec->section_type) {
									case 'model':
										//get the info from the model:
										
										break;
									case 'menu_categories':
										//get the info from the menu:
										break;
									case 'custom':
										//get the links:
									
										break;
								}
								if ($s->type != 'index') {
									$data['sections'][$s->id]['title'] = $sec->section_title;
									$data['sections'][$s->id]['type'] = $sec->section_type;
									$data['sections'][$s->id]['description'] = $sec->section_description;
									$data['sections'][$s->id]['model'] = $sec->section_model;
									
								}
							}
						}
						
					} //end foreach sectionlist
				}//end if sectionlist exists

				if ($s->map_parent > 0) {
					$data['sitemaps'][$s->map_parent]['sub'][$s->id] = array(
						'id' => $s->id,
						'name' => $s->name,
						'type' => $s->type,
						'parent' => $s->map_parent,
						'active' => $s->active,
					);
				} else {
					$data['sitemaps'][$s->id] = array(
						'id' => $s->id,
						'name' => $s->name,
						'type' => $s->type,
						'parent' => $s->map_parent,
						'active' => $s->active,
					);
				}
				
			}
		}
		
		
		
		
		$data['images'] = array(
			'logo' => array(
				'src' => Location::asset('images/modseo','novaSEO.png'),
				'alt' => 'NovaSEO Mod by mooeypoo')
		);
		
		$view_loc = "sitemap_index";
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
}

?>

