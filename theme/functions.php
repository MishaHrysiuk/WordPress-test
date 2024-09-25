<?php

if (!function_exists('test_setup')) {
    function test_setup()
    {
        add_theme_support('custom-logo', [
            'height'      => 50,
            'width'       => 130,
            'flex-width'  => false,
            'flex-height' => false,
            'header-text' => '',
        ]);
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(730, 480);
    }
    add_action('after_setup_theme', 'test_setup');
}

function test_scripts()
{
    wp_enqueue_style('main', get_stylesheet_uri());
    wp_enqueue_style('test', get_template_directory_uri() . '/css/style.css', ['main']);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/plugins/bootstrap/css/bootstrap.css');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/plugins/fontawesome/css/all.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/plugins/animate-css/animate.css');
    wp_enqueue_style('icofont', get_template_directory_uri() . '/plugins/icofont/icofont.css');

    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/plugins/jquery/jquery.min.js');
    wp_enqueue_script('jquery');

    wp_enqueue_script('popper', get_template_directory_uri() . '/plugins/bootstrap/js/popper.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('wow', get_template_directory_uri() . '/plugins/counterup/wow.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('easing', get_template_directory_uri() . '/plugins/counterup/jquery.easing.1.3.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('waypoints', get_template_directory_uri() . '/plugins/counterup/jquery.waypoints.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('counterup', get_template_directory_uri() . '/plugins/counterup/jquery.counterup.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('contact', get_template_directory_uri() . '/plugins/jquery/contact.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('contact', get_template_directory_uri() . '/plugins/jquery/contact.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('google-map', get_template_directory_uri() . '/plugins/google-map/gmap3.min.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'test_scripts');


function test_menus()
{
    $locations = [
        'header' => __('Header menu', 'test'),
        'footer-information' => __("Footer Information menu", 'test'),
        'footer-links' => __("Footer Links menu", 'test')
    ];
    register_nav_menus($locations);
}
add_action('init', 'test_menus');

class bootstrap_4_walker_nav_menu extends Walker_Nav_menu
{

    function start_lvl(&$output, $depth = 0, $args = null)
    { // ul
        $indent = str_repeat("\t", $depth); // indents the outputted HTML
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    { // li a span

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if ($depth && $args->walker->has_children) {
            $classes[] = 'dropdown-menu';
        }

        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="' . esc_attr($class_names) . '"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $attributes .= ($args->walker->has_children) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';

        $item_output = $args->before;
        $item_output .= ($depth > 0) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

add_filter('intermediate_image_sizes', 'intermediate_delete_image_sizes');
function intermediate_delete_image_sizes($sizes)
{
    return array_diff($sizes, [
        'medium_large',
        'large',
        '1536x1536',
        '2048x2048'
    ]);
}

// removes H2 from the pagination template
//add_filter('navigation_markup_template', 'download_navigation_template', 10, 2);

function download_navigation_template($template, $class)
{
    /*
	Type of basic template:
	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div class="nav-links">%3$s</div>
	</nav>
	*/

    return '
	<nav class="navigation %1$s" role="navigation">
		<div class="nav-links">%3$s</div>
	</nav>
	';
}

// output the pagination
// the_posts_pagination(array(
//     'end_size' => 2,
// ));


function test_widgets_init()
{
    register_sidebar([
        'name' => esc_html__('Sidebar blog', 'test'),
        'id'   => 'sidebar-blog',
        'before_widget' => '<section id="%1$s" class="sidebar-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title mb-3">',
        'after_title'   => '</h5>',
    ]);

    register_sidebar([
        'name' => esc_html__('Sidebar footer-text', 'test'),
        'id'   => 'sidebar-footer-text',
        'before_widget' => '<div id="%1$s" class="footer-widget footer-link %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name' => esc_html__('Sidebar footer-contacts', 'test'),
        'id'   => 'sidebar-footer-contacts',
        'before_widget' => '<div id="%1$s" class="footer-widget footer-link %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'test_widgets_init');

class Download_Widget extends WP_Widget
{

    // Widget registration using the main class
    function __construct()
    {
        // the constructor call looks like this:
        // __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
        parent::__construct(
            'download_widget', // widget ID, if not specified (leave ''), the ID will be equal to the class name in lowercase: foo_widget
            'Полезные файлы',
            array('description' => 'Прикрупите ссылки на полезные файлы', 'classname' => 'download',)
        );

        // widget scripts/styles, only if it is active
        if (is_active_widget(false, false, $this->id_base) || is_customize_preview()) {
            add_action('wp_enqueue_scripts', array($this, 'add_download_widget_scripts'));
            add_action('wp_head', array($this, 'add_download_widget_style'));
        }
    }

    /**
     * Widget output in the Front End
     *
     * @param array $args widget arguments.
     * @param array $instance saved data from settings
     */
    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $file = $instance['file'];
        $file_name = $instance['file_name'];

        echo $args['before_widget'];
        if (! empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo "<a href='" . $file . "'><i class='fa fa-file-pdf'></i>" . $file_name . "</a>";
        echo $args['after_widget'];
    }

    /**
     * The admin part of the widget
     *
     * @param array $instance saved data from settings
     */
    function form($instance)
    {
        $title = @$instance['title'] ?: 'Полезные файлы';
        $file = @$instance['file'] ?: 'URL файла';
        $file_name = @$instance['file_name' ?: 'Назва файла'];

?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file'); ?>"><?php _e('URL File:'); ?></label>
            <input class="widefat"
                id="<?php echo $this->get_field_id('file'); ?>"
                name="<?php echo $this->get_field_name('file'); ?>"
                type="text" value="<?php echo esc_attr($file); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('file_name'); ?>"><?php _e('File name:'); ?></label>
            <input class="widefat"
                id="<?php echo $this->get_field_id('file_name'); ?>"
                name="<?php echo $this->get_field_name('file_name'); ?>"
                type="text" value="<?php echo esc_attr($file_name); ?>">
        </p>
    <?php
    }

    /**
     * Saving the widget settings. Here the data must be cleared and returned to save it to the database.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance new settings
     * @param array $old_instance previous settings
     *
     * @return array data to be saved
     */
    function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['file'] = (! empty($new_instance['file'])) ? strip_tags($new_instance['file']) : '';
        $instance['file_name'] = (! empty($new_instance['file_name'])) ? strip_tags($new_instance['file_name']) : '';


        return $instance;
    }

    // widget script
    function add_download_widget_scripts()
    {
        // filter so you can disable scripts
        if (! apply_filters('show_download_widget_script', true, $this->id_base))
            return;

        $theme_url = get_stylesheet_directory_uri();

        // wp_enqueue_script('download_widget_script', $theme_url . '/download_widget_script.js');
    }

    // widget styles
    function add_download_widget_style()
    {
        // filter so that you can disable styles
        if (! apply_filters('show_download_widget_style', true, $this->id_base))
            return;
    ?>
        <style type="text/css">
            .download_widget a {
                display: inline;
            }
        </style>
<?php
    }
}

function register_download_widget()
{
    register_widget("Download_Widget");
}
add_action('widgets_init', 'register_download_widget');
