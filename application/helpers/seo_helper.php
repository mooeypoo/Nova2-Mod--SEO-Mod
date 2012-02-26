<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
if ( ! function_exists('seo_metadata')) {
	function seo_metadata() {
		/* get an instance of CI 
		$ci =& get_instance();
		
		$ci->load->model('settings_model', 'settings');
		$ci->load->model('seo_model', 'seo');

		$settings_array = array(
			'sim_name',
			'seo_meta_desc',
			'seo_meta_tags'
		);
		// set the options
		$options = $ci->settings->get_settings($settings_array);
		
		return $options;
	}
}*/

if ( ! function_exists('output_seo_metadata')) {
	function output_seo_metadata() {
		/* get an instance of CI */
		$ci =& get_instance();
		
		$ci->load->model('settings_model', 'settings');
		$ci->load->model('seo_model', 'seo');

		$settings_array = array(
			'sim_name',
			'seo_meta_desc',
			'seo_meta_tags'
		);
		// set the options
		$options = $ci->settings->get_settings($settings_array);
		
		$out = '';
		
		$out .= "<meta name='description' content='".$options['seo_meta_desc']."'>\n";
		$out .= "<meta name='keywords' content='".$options['seo_meta_tags']."'>\n";
		$out .= "<meta name='author' content='".$options['site_name']."'>\n";
		
		return $out;
	}
}

