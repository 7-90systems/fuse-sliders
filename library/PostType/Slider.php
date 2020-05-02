<?php
    /**
     *  @package fuse-sliders
     *  
     *  Set up the slider post type.
     */
    
    namespace Fuse\Plugin\Sliders\PostType;
    
    use Fuse\PostType;
    
    
    class Slider extends PostType {
        
        /**
         *  Object constructor.
         */
        public function __construct () {
            parent::__construct ('slider', __ ('Slider', 'fuse'), __ ('Sliders', 'fuse'), array (
                'public' => false,
                'publicly_queryable' => false,
                'rewrite' => false,
                'menu_icon' => FUSE_PLUGIN_SLIDERS_BASE_URL.'/assets/images/icons/application_side_expand.png',
                'supports' => array (
                    'title'
                )
            ));
        } // __construct ()
        
        
        
        
        /**
         *  Add our meta boxes.
         */
        public function addMetaBoxes () {
            add_meta_box ('fuse_sliders_slides_meta', __ ('Slides', 'fuse'), array ($this, 'slidesMeta'), $this->getSlug (), 'normal', 'default');
        } // addMetaBoxes ()
        
        /**
         *  Show the slides for this slider.
         *
         *  @param WP_Post $post The post.
         */
        public function slidesMeta ($post) {
            $slides = get_posts (array (
                'numberposts' => -1,
                'post_type' => 'fusesliderslide',
                'post_parent' => $post->ID,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            ?>
                <table class="widefat">
                    <thead>
                        <tr>
                            <th><?php _e ('Title', 'fuse'); ?></th>
                            <th><?php _e ('Starts At', 'fuse'); ?></th>
                            <th><?php _e ('Ends At', 'fuse'); ?></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th><?php _e ('Title', 'fuse'); ?></th>
                            <th><?php _e ('Starts At', 'fuse'); ?></th>
                            <th><?php _e ('Ends At', 'fuse'); ?></th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php if (count ($slides) > 0): ?>
                            <?php foreach ($slides as $slide): ?>
                                <tr>
                                    <td><a href="<?php echo esc_url (admin_url ('post.php?post='.$slide->ID.'&action=edit')); ?>"><?php echo $slide->post_title; ?></a></td>
                                    <td><?php _e ('Starts At', 'fuse'); ?></td>
                                    <td><?php _e ('Ends At', 'fuse'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center;"><?php _e ('No slides set', 'fuse'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <p><a href="<?php echo esc_url (admin_url ('post-new.php?post_type=fusesliderslide&slider='.$post->ID)); ?>" class="button button-primary"><?php _e ('Add a New Slide', 'fuse'); ?></a></p>
            <?php
        } // slidesMeta ()
        
        
        
        
        /**
         *  Add in our admin list columns.
         *
         *  @param array $columns The existing columns.
         *
         *  @return array The complete column list.
         */
        public function adminListColumns ($columns) {
            $columns ['fuse_sliders_function_call'] = __ ('Function Call', 'fuse');
            
            return $columns;
        } // adminListColumns ()
        
        /**
         *  Add the columns content.
         *
         *  @param string $column The name of the column.
         *  @param int $post_id The post ID.
         */
        public function adminListValues ($column, $post_id) {
            switch ($column) {
                case 'fuse_sliders_function_call':
                    echo 'fuse_sliders ('.$post_id.');';
                    break;
            } // switch ()
        } // adminListValues ()
        
    } // class Slider