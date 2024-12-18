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

    // بارگذاری اسکریپت‌های دیگر
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/asset/javascript/custom.js', array('jquery'), null, true);
    wp_enqueue_script('foodmodal-js', get_template_directory_uri() . '/asset/javascript/openfoodmodal.js', array('jquery'), null, true);
    wp_enqueue_script('structure-js', get_template_directory_uri() . '/asset/javascript/structure.js', array('jquery'), null, true);
    wp_enqueue_script('garson-js', get_template_directory_uri() . '/asset/javascript/garson.js', array('jquery'), null, true);
    wp_enqueue_script('ajaxsearch-js', get_template_directory_uri() . '/asset/javascript/ajaxsearch.js', array('jquery'), null, true);
    wp_enqueue_script('cartshop-js', get_template_directory_uri() . '/asset/javascript/cartshop.js', array('jquery'), null, true);
    wp_enqueue_script('priceFormater-js', get_template_directory_uri() . '/asset/javascript/priceFormater.js', array(), null, true);
    wp_enqueue_script('footer-js', get_template_directory_uri() . '/asset/javascript/footer.js', array('jquery'), null, true);
    wp_enqueue_script('branchlist-js', get_template_directory_uri() . '/asset/javascript/branchlist.js', array('jquery'), null, true);

    // اضافه کردن ajaxurl برای استفاده در جاوااسکریپت
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

// بارگذاری استایل فونت یکن برای کل داشبورد
function custom_admin_fonts()
{
    echo '
    <style>
        @font-face {
            font-family: "Yekan";
            src: url("' . get_template_directory_uri() . '/asset/fonts/yekan.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        /* اعمال فونت یکن به تمام بخش‌های داشبورد */
        body, td, textarea, input, select, .wp-core-ui .button, .wrap h1, .wrap p, .wrap a {
            font-family: "Yekan", sans-serif !important;
        }

        /* بهبود نمایش برخی بخش‌های خاص */
        .wp-core-ui .button-primary {
            background-color: #0073aa;
            border-color: #0073aa;
            color: #ffffff;
        }

        .wp-core-ui .button-primary:hover {
            background-color: #005177;
        }
    </style>
    ';
}
add_action('admin_head', 'custom_admin_fonts');




require_once get_template_directory() . '/FunctionsParts/AddFoodItems.php';
require_once get_template_directory() . '/FunctionsParts/Garson.php';
require_once get_template_directory() . '/FunctionsParts/AjaxSearch.php';
require_once get_template_directory() . '/FunctionsParts/CafeInformations.php';
require_once get_template_directory() . '/FunctionsParts/Discount_Price.php';
require_once get_template_directory() . '/FunctionsParts/persiandateandnumber.php';
require_once get_template_directory() . '/FunctionsParts/jdf.php';
require_once get_template_directory() . '/FunctionsParts/comments.php';
require_once get_template_directory() . '/FunctionsParts/branchlist.php';
require_once get_template_directory() . '/FunctionsParts/qrcode.php';

// پایان فایل functions.php
?>