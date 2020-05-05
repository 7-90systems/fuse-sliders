<?php
    /**
     *  @package fuse-sliders
     *
     *  This is the default template for our slide. You can over-write this by creating
     *  a new file in your theme at '/templates/fuse-sliders/slide.php'.
     */
    
    if (!defined ('ABSPATH')) {
        die ();
    } // if ()
    
    global $slider;
    global $slide;
    
    $image = wp_get_attachment_image_url (get_post_thumbnail_id ($slide->ID), 'full');
?>
<li class="fuse-sliders-slide fuse-sliders-slide-<?php echo $slide->ID; ?>">
    <div class="wrap">
            
        <img src="<?php echo esc_url ($image); ?>" alt="<?php esc_attr_e ($slide->post_title); ?>" />
        
        <?php if (strlen ($slide->post_content) > 0): ?>
            <div class="slide-caption">
                <div class="wrap">
                    <?php echo apply_filters ('the_content', $slide->post_content); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</li>