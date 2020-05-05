<?php
    /**
     *  @package fuse-sliders
     *
     *  This is the default template for our slider. You can over-write this by creating
     *  a new file in your theme at '/templates/fuse-sliders/slider.php'.
     */
    
    if (!defined ('ABSPATH')) {
        die ();
    } // if ()
    
    global $slider;
    global $slide;
    
    $slides = \Fuse\Plugin\Sliders\PostType\Slider::getSlides ($slider->ID);
?>
<?php if (count ($slides) > 0): ?>

    <script type="text/javascript">
        jQuery (document).ready (function () {
            jQuery ('.fuse-sliders-slider.fuse-slider-<?php echo $slider->ID; ?> ul.fuse-slider-slides').bxSlider ({
                mode: 'fade',
                auto: true,
                controls: false,
                touchEnabled: false
            });
        });
    </script>

    <div class="fuse-sliders-slider fuse-slider-<?php echo $slider->ID; ?>">
        <div class="wrap">
            
            <ul class="fuse-slider-slides">
                <?php
                    foreach ($slides as $slide) {
                        $template = fuse_sliders_get_template_file ('slide.php');
                        
                        if (is_null ($template) === false) {
                            require ($template);
                        } // if ()
                    } // foreach ()
                ?>
            </ul>
            
        </div>
    </div>

<?php endif; ?>