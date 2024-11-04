<?php
// شروع فایل functions.php

// افزودن پشتیبانی از تصاویر شاخص
add_theme_support('post-thumbnails');

// افزودن پشتیبانی از عنوان پویا
add_theme_support('title-tag');

// افزودن پشتیبانی از فهرست‌ها (منوهای سفارشی)
function my_theme_setup() {
  register_nav_menus(array(
    'primary-menu' => __('Primary Menu', 'mytheme'),
    'footer-menu' => __('Footer Menu', 'mytheme')
  ));
}
add_action('after_setup_theme', 'my_theme_setup');

// بارگذاری استایل‌ها و اسکریپت‌ها
function my_theme_scripts() {
  // بارگذاری استایل اصلی
  wp_enqueue_style('main-stylesheet', get_template_directory_uri() . '/asset/css/custom-style.css');
  
  // بارگذاری یک اسکریپت سفارشی
  wp_enqueue_script('custom-js', get_template_directory_uri() . '/asset/javascript/custom-js.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

// تابع برای لود کردن تصاویر از پوشه asset
function get_theme_image_url($image_name) {
  return get_template_directory_uri() . '/asset/image/' . $image_name;
}

//فونت اسوم
function load_font_awesome() {
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'load_font_awesome');


// افزودن پشتیبانی از ویجت‌ها
function my_custom_widget_areas() {
  register_sidebar(array(
    'name'          => __('Main Sidebar', 'mytheme'),
    'id'            => 'main-sidebar',
    'before_widget' => '<div class="widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ));
  
  register_sidebar(array(
    'name'          => __('Footer Widget Area', 'mytheme'),
    'id'            => 'footer-widget-area',
    'before_widget' => '<div class="footer-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="footer-widget-title">',
    'after_title'   => '</h3>',
  ));
}
add_action('widgets_init', 'my_custom_widget_areas');

// حذف ورژن وردپرس از هدر
remove_action('wp_head', 'wp_generator');

// غیرفعال کردن ویرایشگر گوتنبرگ
add_filter('use_block_editor_for_post', '__return_false');

// پایان فایل functions.php
function add_custom_font() {
  // مسیر فایل CSS
  wp_enqueue_style( 'custom-font', get_template_directory_uri() . '/asset/fonts/custom-font.css', array(), null );
}
add_action( 'wp_enqueue_scripts', 'add_custom_font' );

