<?php
    /**
     *  @package fuse-sliders
     *
     *  Set up our slider plugin.
     */
    
    namespace Fuse\Plugin\Sliders;
    
    
    class Setup {
        
        /**
         *  Object constructor.
         */
        public function __construct () {
            add_action ('plugins_loaded', array ($this, 'registerPostTypes'));
            add_filter ('fuse_load_functions_from', array ($this, 'loadFunctions'));
            
            add_filter ('fuse_javascript_dependencies', array ($this, 'javascriptDependencies'));
            add_filter ('fuse_css_dependencies', array ($this, 'cssDependencies'));
        } // __consturct ()
        
        
        
        
        /**
         *  Set up our post types.
         */
        public function registerPostTypes () {
            $posttype_slider = new PostType\Slider ();
            $posttype_slide = new PostType\Slide ();
        } // registerPostTypes ()
        
        
        
        
        /**
         *  Re-gister our function files.
         *
         *  @param array $dirs The function file directories.
         *
         *  @return array Our completed list.
         */
        public function loadFunctions ($dirs) {
            $dirs [] = FUSE_PLUGIN_SLIDERS_BASE_URI.DIRECTORY_SEPARATOR.'functions';
            
            return $dirs;
        } // loadFunctions ()
        
        
        
        
        /**
         *  Add in our JavaScript dependencies.
         *
         *  @param array $depenencies The dependency files.
         *
         *  @return array The completed list of dependencies.
         */
        public function javascriptDependencies ($depenencies) {
            $depenencies [] = 'bxslider';
            
            return $depenencies;
        } // javascriptDependencies ()
        
        /**
         *  Add in our CSS dependencies.
         *
         *  @param array $depenencies The dependency files.
         *
         *  @return array The completed list of dependencies.
         */
        public function cssDependencies ($depenencies) {
            $depenencies [] = 'bxslider';
            
            return $depenencies;
        } // cssDependencies ()
        
    } // class Setup