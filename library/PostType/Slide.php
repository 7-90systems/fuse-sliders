<?php
    /**
     *  @package fuse-sliders
     *
     *  This class sets up our individual slides.
     */
    
    namespace Fuse\Plugin\Sliders\PostType;
    
    use Fuse\PostType;
    use WP_Post;
    
    
    class Slide extends PostType {
        
        protected $_date_types = array (
            'start' => 'Starting Date',
            'end' => 'Ending Date'
        );
        
        
        
        
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
                    'thumbnail',
                    'page-attributes'
                )
            ));
        } // __construct ()
        
        
        
        
        /**
         *  Set up our meta boxes.
         */
        public function addMetaBoxes () {
            add_meta_box ('fuse_sliders_slide_slider_meta', __ ('Slider', 'fuse'), array ($this, 'sliderMeta'), $this->getSlug (), 'side', 'high');
            
            add_meta_box ('fuse_sliders_slide_date_meta', __ ('Activity Dates', 'fuse'), array ($this, 'datesMeta'), $this->getSlug (), 'normal', 'default');
        } // addMetaBoxes ()
        
        /**
         *  St up the slider emta box.
         *
         *  @param WP_POst $post The post object.
         */
        public function sliderMeta ($post) {
            $slider = NULL;
            
            if ($post->post_parent > 0) {
                $tmp = get_post ($post->post_parent);
                
                if ($tmp->post_type == 'slider') {
                    $slider = $tmp;
                } // if ()
            } // if ()
            elseif (array_key_exists ('slider', $_GET)) {
                $tmp = get_post ($_GET ['slider']);
                
                if ($tmp->post_type == 'slider') {
                    $slider = $tmp;
                } // if ()
            } // elseif ()
            ?>
                <?php if (is_null ($slider)): ?>
                    <select name="fuse_sliders_slide_slider">
                        <option value="">&nbsp;</option>
                        <?php foreach ($this->_getSliderList () as $slider): ?>
                            <option value="<?php echo $slider->ID; ?>"><?php echo $slider->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <a href="<?php echo esc_url (admin_url ('post.php?post='.$slider->ID.'&action=edit')); ?>"><?php echo $slider->post_title; ?></a>
                    <input type="hidden" name="fuse_sliders_slide_slider" value="<?php echo $slider->ID; ?>" />
                <?php endif; ?>
            <?php
        } // sliderMeta ()
        
        /**
         *  Set up the dates meta box.
         */
        public function datesMeta ($post) {
            ?>
                <script type="text/javascript">
                    jQuery (document).ready (function () {
                        jQuery ('.fuse_sliders_slide_date_set').change (function () {
                            var el = jQuery (this);
                            var table = jQuery ('#fuse_slide_date_table_' + el.data ('type'));
                            
                            if (el.is (':checked')) {
                                table.show ();
                            } // if ()
                            else {
                                table.hide ();
                            } // else
                        });
                    });
                </script>
                <?php foreach ($this->_date_types as $type => $label): ?>
                    <?php
                        $date = get_post_meta ($post->ID, 'fuse_sliders_slide_date_'.$type, true);
                        
                        $year = $month = $day = $hour = $minute = '';
                        
                        if (strlen ($date) > 0) {
                            $date = new \DateTime ($date);
                            
                            $year = $date->format ('Y');
                            $month = $date->format ('n');
                            $day = $date->format ('j');
                            $hour = $date->format ('G');
                            $minute = intval ($date->format ('i'));
                        } // if ()
                        else {
                            $date = NULL;
                        } // else
                    ?>
                    <p>
                        <label>
                            <input type="checkbox" name="fuse_sliders_slide_type_<?php echo $type; ?>" class="fuse_sliders_slide_date_set" data-type="<?php echo $type; ?>"<?php if (is_null ($date) === false) echo ' checked="checked"'; ?> />
                            <?php printf (__ ('Set a %s', 'fuse'), __ ($label, 'fuse')); ?>
                        </label>
                    </p>
                    <table id="fuse_slide_date_table_<?php echo $type; ?>" class="form-table"<?php if (is_null ($date)) echo ' style="display: none;"'; ?>>
                        <tr>
                            <th><?php printf (__ ('Set %s', 'fuse'), __ ($label, 'fuse')); ?></th>
                            <td>
                                <select name="fuse_slide_date_<?php echo $type; ?>_hour">
                                    <?php for ($i = 0; $i < 24; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php selected ($hour, $i); ?>><?php echo str_pad ($i, 2, '0', STR_PAD_LEFT); ?></option>
                                    <?php endfor; ?>
                                </select>
                                :
                                <select name="fuse_slide_date_<?php echo $type; ?>_minute">
                                    <?php for ($i = 0; $i < 60; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php selected ($minute, $i); ?>><?php echo str_pad ($i, 2, '0', STR_PAD_LEFT); ?></option>
                                    <?php endfor; ?>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                                <select name="fuse_slide_date_<?php echo $type; ?>_day">
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php selected ($day, $i); ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                                /
                                <select name="fuse_slide_date_<?php echo $type; ?>_month">
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?php echo $i; ?>"<?php selected ($month, $i); ?>><?php echo date ('F', strtotime ('2000-'.$i.'-01')); ?></option>
                                    <?php endfor; ?>
                                </select>
                                /
                                <select name="fuse_slide_date_<?php echo $type; ?>_year">
                                    <?php for ($i = date ('Y') + 2; $i >= 2000; $i--): ?>
                                        <option value="<?php echo $i; ?>"<?php selected ($year, $i); ?>><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
                <input type="hidden" name="fuse_sliders_slide_update_dates" value="update" />
            <?php
        } // datesMeta ()
        
        
        
        
        /**
         *  Save the posts values.
         *
         *  @param int $post_id The ID of the post.
         *  @param WP_Post $psot The post object.
         */
        public function savePost ($post_id, $post) {
            global $wpdb;
            
            if (defined ('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            } // if ()
            else {
                // Slider
                if (array_key_exists ('fuse_sliders_slide_slider', $_POST) && $post->post_narent == 0) {
                    $wpdb->update ($wpdb->posts, array (
                        'post_parent' => $_POST ['fuse_sliders_slide_slider']
                    ), array (
                        'ID' => $post_id
                    ), array (
                        '%d'
                    ), array (
                        '%d'
                    ));
                } // if ()
                
                // Dates
                if (array_key_exists ('fuse_sliders_slide_update_dates', $_POST)) {
                    foreach ($this->_date_types as $type => $label) {
                        $date = '';
                        
                        if (array_key_exists ('fuse_sliders_slide_type_'.$type, $_POST)) {
                            $year = $_POST ['fuse_slide_date_'.$type.'_year'];
                            $month = str_pad ($_POST ['fuse_slide_date_'.$type.'_month'], 2, '0', STR_PAD_LEFT);
                            $day = str_pad ($_POST ['fuse_slide_date_'.$type.'_day'], 2, '0', STR_PAD_LEFT);
                            $hour = str_pad ($_POST ['fuse_slide_date_'.$type.'_hour'], 2, '0', STR_PAD_LEFT);
                            $minute = str_pad ($_POST ['fuse_slide_date_'.$type.'_minute'], 2, '0', STR_PAD_LEFT);
                            
                            if (checkdate ($month, $day, $year)) {
                                $date = date ('Y-m-d H:i:s', strtotime ($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute));
                            } // if ()
                        } // if ()
                        
                        update_post_meta ($post_id, 'fuse_sliders_slide_date_'.$type, $date);
                    } // foreach ()
                } // if ()
            } // else
        } // savePost ()
        
        
        
        
        /**
         *  Set up our admin list columns.
         *
         *  @param array $columns The current column list.
         *
         *  @return array The completed column list.
         */
        public function adminListColumns ($columns) {
            $columns ['fuse_slider_slide_slider'] = __ ('Slider', 'fuse');
            $columns ['fuse_slider_slide_start'] = __ ('Starts At', 'fuse');
            $columns ['fuse_slider_slide_end'] = __ ('Ends At', 'fuse');
            
            return $columns;
        } // adminListColumns ()
        
        /**
         *  Set up the admin list column values.
         *
         *  @param string $column The column index.
         *  @paran int $post_id The ID of the current post.
         */
        public function adminListValues ($column, $post_id) {
            switch ($column) {
                case 'fuse_slider_slide_slider':
                    $this->_sliderColumn ($post_id);
                    break;
                case 'fuse_slider_slide_start':
                    $this->_dateColumn ($post_id, 'start');
                    break;
                case 'fuse_slider_slide_end':
                    $this->_dateColumn ($post_id, 'end');
                    break;
            } // switch ()
        } // adminListValues ()
        
        
        
        
        /**
         *  Show the slider column value.
         *
         *  @param int $post_id The ID of the post.
         */
        protected function _sliderColumn ($post_id) {
            $slide = get_post ($post_id);
            $slider = NULL;
            
            if ($slide->post_parent > 0) {
                $slider = get_post ($slide->post_parent);
                
                if ($slider->post_type != 'slider') {
                    $slider = NULL;
                } // if ()
            } // if ()
            
            if (is_null ($slider)) {
                echo '<span class="admin-bold admin-red">'.__ ('Slider not set', 'fuse').'</span>';
            } // if ()
            else {
                echo '<a href="'.esc_url (admin_url ('post.php?post='.$slider->ID.'&action=edit')).'">'.$slider->post_title.'</a>';
            } // else
        } // _sliderColumn ()
        
        /**
         *  Display the date column
         *
         *  @param int $post_id The post ID.
         *  @param string $type The date type.
         */
        protected function _dateColumn ($post_id, $type) {
            $date = get_post_meta ($post_id, 'fuse_sliders_slide_date_'.$type, true);
                        
            if (strlen ($date) > 0) {
                $date = new \DateTime ($date);
                $current = new \DateTime (current_time ('mysql'));
                
                if (($type == 'start' && $date < $current) || ($type == 'end' && $date > $current)) {
                    $class = 'admin-green admin';
                } // if ()
                else {
                    $class = 'admin-red';
                } // else
                
                echo '<span class="'.$class.' admin-bold">'.$date->format ('g:ia jS F Y').'</span>';
            } // if ()
            else {
                echo '<span class="admin-italic">'.sprintf (__ ('No %s', 'fuse'), strtolower ($this->_date_types [$type])).'</span>';
            } // else
        } // _dateColumn ()
        
        
        
        
        /**
         *  Get the slider list.
         *
         *  return array The array of sliders.
         */
        protected function _getSliderList () {
            global $wpdb;
            
            $query = "SELECT
                ID,
                post_title
            FROM ".$wpdb->posts."
            WHERE post_type = 'slider'
                AND post_status = 'publish'
                AND post_date <= NOW()
            ORDER BY post_title ASC";
            
            return $wpdb->get_results ($query);
        } // _getSliderList ()
        
    } // class Slide