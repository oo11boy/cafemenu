<?php
// شروع فایل functions.php

// افزودن پشتیبانی از تصاویر شاخص
add_theme_support('post-thumbnails');

// افزودن پشتیبانی از عنوان پویا
add_theme_support('title-tag');

// افزودن پشتیبانی از فهرست‌ها (منوهای سفارشی)
function my_theme_setup()
{
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'mytheme'),
        'footer-menu' => __('Footer Menu', 'mytheme')
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

// بارگذاری استایل‌ها و اسکریپت‌ها


function my_theme_scripts()
{
    // بارگذاری استایل اصلی
    wp_enqueue_style('main-stylesheet', get_template_directory_uri() . '/asset/css/custom-style.css');

    // بارگذاری یک اسکریپت سفارشی
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/asset/javascript/custom-js.js', array('jquery'), null, true);
    // بارگذاری یک اسکریپت سفارشی
    wp_enqueue_script('foodmodal-js', get_template_directory_uri() . '/asset/javascript/openfoodmodal.js', array('jquery'), null, true);
  // بارگذاری یک اسکریپت سفارشی
    wp_enqueue_script('structure-js', get_template_directory_uri() . '/asset/javascript/structure.js', array('jquery'), null, true);
  // بارگذاری یک اسکریپت سفارشی
  wp_enqueue_script('garson-js', get_template_directory_uri() . '/asset/javascript/garson.js', array('jquery'), null, true);
  // بارگذاری یک اسکریپت سفارشی
  wp_enqueue_script('ajaxsearch-js', get_template_directory_uri() . '/asset/javascript/ajaxsearch.js', array('jquery'), null, true);
  // بارگذاری یک اسکریپت سفارشی
  wp_enqueue_script('cartshop-js', get_template_directory_uri() . '/asset/javascript/cartshop.js', array('jquery'), null, true);

    // اضافه کردن ajaxurl برای استفاده در جاوا اسکریپت
    wp_localize_script('custom-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');


// تابع برای لود کردن تصاویر از پوشه asset
function get_theme_image_url($image_name)
{
    return get_template_directory_uri() . '/asset/image/' . $image_name;
}

//فونت اسوم
function load_font_awesome()
{
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'load_font_awesome');


// افزودن پشتیبانی از ویجت‌ها
function my_custom_widget_areas()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'mytheme'),
        'id' => 'main-sidebar',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer Widget Area', 'mytheme'),
        'id' => 'footer-widget-area',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="footer-widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'my_custom_widget_areas');

// حذف ورژن وردپرس از هدر
remove_action('wp_head', 'wp_generator');

// غیرفعال کردن ویرایشگر گوتنبرگ
add_filter('use_block_editor_for_post', '__return_false');

// افزودن پشتیبانی از فونت‌های سفارشی
function add_custom_font()
{
    // مسیر فایل CSS
    wp_enqueue_style('custom-font', get_template_directory_uri() . '/asset/fonts/custom-font.css', array(), null);
}
add_action('wp_enqueue_scripts', 'add_custom_font');







// افزودن فیلد متا برای پیشنهاد ویژه
function add_food_item_special_offer_meta_box()
{
    add_meta_box('special_offer_meta_box', __('پیشنهاد ویژه', 'mytheme'), 'render_special_offer_meta_box', 'food_item', 'side', 'default');
}
add_action('add_meta_boxes', 'add_food_item_special_offer_meta_box');

function render_special_offer_meta_box($post)
{
    $is_special_offer = get_post_meta($post->ID, 'special_offer', true);
    ?>
    <label for="special_offer"><?php _e('آیا این پیشنهاد ویژه است؟', 'mytheme'); ?></label>
    <select name="special_offer" id="special_offer" style="width: 100%;">
        <option value="1" <?php selected($is_special_offer, '1'); ?>>بله</option>
        <option value="0" <?php selected($is_special_offer, '0'); ?>>خیر</option>
    </select>
    <?php
}

// ذخیره فیلد پیشنهاد ویژه
function save_special_offer_meta($post_id)
{
    if (isset($_POST['special_offer'])) {
        update_post_meta($post_id, 'special_offer', sanitize_text_field($_POST['special_offer']));
    }
}
add_action('save_post', 'save_special_offer_meta');





require_once get_template_directory() . '/asset/FunctionsParts/AddFoodItems.php';
require_once get_template_directory() . '/asset/FunctionsParts/Garson.php';
require_once get_template_directory() . '/asset/FunctionsParts/AjaxSearch.php';
require_once get_template_directory() . '/asset/FunctionsParts/CafeInformations.php';


// پایان فایل functions.php
?>



