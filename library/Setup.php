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
        } // __consturct ()
        
        
        
        
        /**
         *  Set up our post types.
         */
        public function registerPostTypes () {
            $posttype_slider = new PostType\Slider ();
            $posttype_slide = new PostType\Slide ();
        } // registerPostTypes ()
        
    } // class Setup