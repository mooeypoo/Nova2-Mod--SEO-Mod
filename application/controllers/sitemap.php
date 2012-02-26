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
	
	
	public function index() {

		// load the resources
		$this->load->model('seo_model', 'seo');

		$data['header'] = "Sitemap Index";
		
		$view_loc = "sitemap_index";
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
}

?>

