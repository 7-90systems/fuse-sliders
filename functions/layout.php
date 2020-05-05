<?php
    /**
     *  @package fuse-sliders
     *
     *  Set up our layout functions for sliders.
     */
    
    /**
     *  Display a slider!
     *
     *  @param int $slider_id The ID of the slider
     */
    function fuse_sliders ($slider_id) {
        $template = fuse_sliders_get_template_file ('slider.php');
        
        if (is_null ($template) === false) {
            global $slider;
            
            $slider = get_post ($slider_id);
            
            require ($template);
        } // if ()
    } // fuse_sliders ()
    
    
    
    
    /**
     *  Get the location of the requested file.
     *
     *  @param string $file The template file to find, eg: slider.php.
     *
     *  @return string|NULL The files location or NULL if the file doesn't exist.
     */
    function fuse_sliders_get_template_file ($template_file) {
        $file = NULL;
        
        // Check for a child them first
        if (is_child_theme ()) {
            $tmp = get_stylesheet_directory ().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'fuse-sliders'.DIRECTORY_SEPARATOR.$template_file;
            
            if (file_exists ($tmp)) {
                $file = $tmp;
            } // if ()
        } // if ()
        
        // Check main or parent theme
        if (is_null ($file)) {
            $tmp = get_template_directory ().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'fuse-sliders'.DIRECTORY_SEPARATOR.$template_file;
            
            if (file_exists ($tmp)) {
                $file = $tmp;
            } // if ()
        } // if ()
        
        // Check our plugins template directory
        if (is_null ($file)) {
            $tmp = FUSE_PLUGIN_SLIDERS_BASE_URI.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template_file;
            
            if (file_exists ($tmp)) {
                $file = $tmp;
            } // if ()
        } // if ()
        
        return $file;
    } // fuse_sliders_get_template_file ()