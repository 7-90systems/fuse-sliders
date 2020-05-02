<?php
    /**
     *  @package fuse-sliders
     *
     *  This class sets up our individual slides.
     */
    
    namespace Fuse\Plugin\Sliders\PostType;
    
    use Fuse\PostType;
    
    
    class Slide extends PostType {
        
        /**
         *  Object constructor.
         */
        public function __construct () {
            parent::__construct ('fusesliderslide', __ ('Slide', 'fuse'), __ ('Slides', 'fuse'), array (
                'public' => false,
                'publicly_queryable' => false,
                'rewrite' => false,
                'show_in_menu' => 'edit.php?post_type=slider',
                'supports' => array (
                    'title',
                    'editor',
                    'page-attributes'
                )
            ));
        } // __construct ()
        
    } // class Slide