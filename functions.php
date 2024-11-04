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

// افزودن پشتیبانی از فونت‌های سفارشی
function add_custom_font() {
    // مسیر فایل CSS
    wp_enqueue_style('custom-font', get_template_directory_uri() . '/asset/fonts/custom-font.css', array(), null);
}
add_action('wp_enqueue_scripts', 'add_custom_font');

// ثبت نوع پست سفارشی برای آیتم‌های غذا
function register_food_post_type() {
    register_post_type('food_item',
        array(
            'labels' => array(
                'name' => __('آیتم‌های غذا'),
                'singular_name' => __('آیتم غذا')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'food-items'),
            'supports' => array('title', 'editor', 'thumbnail')
        )
    );
    
    register_taxonomy(
        'food_category',
        'food_item',
        array(
            'label' => __('دسته‌بندی غذاها'),
            'rewrite' => array('slug' => 'food-category'),
            'hierarchical' => true,
        )
    );
}
add_action('init', 'register_food_post_type');

// افزودن متا باکس برای قیمت غذا
function add_food_item_meta_boxes() {
    add_meta_box('food_price_meta_box', __('قیمت غذا', 'mytheme'), 'render_food_price_meta_box', 'food_item', 'side', 'default');
}
add_action('add_meta_boxes', 'add_food_item_meta_boxes');

function render_food_price_meta_box($post) {
    $price = get_post_meta($post->ID, 'food_price', true);
    ?>
    <label for="food_price"><?php _e('قیمت غذا (تومان)', 'mytheme'); ?></label>
    <input type="text" id="food_price" name="food_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;">
    <?php
}

// ذخیره قیمت غذا
function save_food_item_price($post_id) {
    if (isset($_POST['food_price'])) {
        update_post_meta($post_id, 'food_price', sanitize_text_field($_POST['food_price']));
    }
}
add_action('save_post', 'save_food_item_price');

// اضافه کردن متا فیلد برای تصویر دسته‌بندی
function add_food_category_image_field($taxonomy) {
    ?>
    <div class="form-field term-group">
        <label for="category-image-id"><?php _e('تصویر دسته‌بندی', 'mytheme'); ?></label>
        <input type="hidden" id="category-image-id" name="category-image-id" value="">
        <div id="category-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary" id="category-image-button" value="<?php _e('افزودن تصویر', 'mytheme'); ?>">
            <input type="button" class="button button-secondary" id="category-image-remove-button" value="<?php _e('حذف تصویر', 'mytheme'); ?>">
        </p>
    </div>
    <?php
}
add_action('food_category_add_form_fields', 'add_food_category_image_field', 10, 2);

function edit_food_category_image_field($term, $taxonomy) {
    $image_id = get_term_meta($term->term_id, 'category_image', true);
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category-image-id"><?php _e('تصویر دسته‌بندی', 'mytheme'); ?></label></th>
        <td>
            <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo esc_attr($image_id); ?>">
            <div id="category-image-wrapper">
                <?php if ($image_id) {
                    echo wp_get_attachment_image($image_id, 'thumbnail');
                } ?>
            </div>
            <p>
                <input type="button" class="button button-secondary" id="category-image-button" value="<?php _e('تغییر تصویر', 'mytheme'); ?>">
                <input type="button" class="button button-secondary" id="category-image-remove-button" value="<?php _e('حذف تصویر', 'mytheme'); ?>">
            </p>
        </td>
    </tr>
    <?php
}
add_action('food_category_edit_form_fields', 'edit_food_category_image_field', 10, 2);

// اضافه کردن جاوا اسکریپت آپلود
function add_category_image_script() {
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'food_category') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('category-image-upload', get_template_directory_uri() . '/asset/javascript/category-image-upload.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'add_category_image_script');

function save_food_category_image($term_id, $tt_id) {
    if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
        add_term_meta($term_id, 'category_image', $_POST['category-image-id'], true);
    } else {
        delete_term_meta($term_id, 'category_image');
    }
}
add_action('created_food_category', 'save_food_category_image', 10, 2);
add_action('edited_food_category', 'save_food_category_image', 10, 2);

// پایان فایل functions.php
?>
