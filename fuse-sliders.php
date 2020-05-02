<?php
    /**
     *  @package fuse-sliders
     *  
     *  Plugin Name: Fuse Sliders
     *  Plugin URI: https://fusecms.org/plugins/fuse-sliders
     *  Description: Set up sliders on your site simply with Fuse Sliders.
     *  Version: 1.0
     *  Author: 7-90 Systems
     *  Author URI: https://7-90.com.au
     *  Text Domain: fuse
     */
    
    namespace Fuse\Plugin\Sliders;
    
    
    define ('FUSE_PLUGIN_SLIDERS_BASE_URI', __DIR__);
    define ('FUSE_PLUGIN_SLIDERS_BASE_URL', plugins_url ('', __FILE__));
    
    
    $fuse_sliders_setup = new Setup ();