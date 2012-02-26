<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * SEO hook
 *
 * @package		Nova
 * @category	Hook
 * @author		Moriel Schottlender
 * @copyright	2012 Moriel Schottlender CC ShareAlike
 */
require_once MODPATH.'core/hooks/nova_utility.php';

class Seo_hook extends Nova_utility {
	var $ci;
	public function __construct()
	{
		log_message('info', 'Utility Hook Initialized');
	}


}