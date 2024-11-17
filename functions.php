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

// بارگذاری استایل‌ها و اسکریپت‌ها
function my_theme_scripts() {
    // بارگذاری استایل اصلی
    wp_enqueue_style('main-stylesheet', get_template_directory_uri() . '/asset/css/custom-style.css');
  
    // بارگذاری یک اسکریپت سفارشی
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/asset/javascript/custom-js.js', array('jquery'), null, true);

    // اضافه کردن ajaxurl برای استفاده در جاوا اسکریپت
    wp_localize_script('custom-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
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




// ثبت درخواست گارسون از طریق Ajax
function submit_waiter_request() {
    if (isset($_POST['table_number'])) {
        $table_number = sanitize_text_field($_POST['table_number']);

        // ایجاد یک پست سفارشی برای ذخیره درخواست‌ها
        $post_id = wp_insert_post(array(
            'post_title'    => 'درخواست گارسون میز ' . $table_number,
            'post_type'     => 'waiter_request',
            'post_status'   => 'publish',
        ));

        if ($post_id) {
            wp_send_json_success('درخواست با موفقیت ثبت شد');
        } else {
            wp_send_json_error('خطا در ثبت درخواست');
        }
    } else {
        wp_send_json_error('شماره میز نامعتبر است');
    }

    wp_die(); // پایان پردازش درخواست Ajax
}
add_action('wp_ajax_submit_waiter_request', 'submit_waiter_request');
add_action('wp_ajax_nopriv_submit_waiter_request', 'submit_waiter_request');

// ثبت نوع پست سفارشی برای درخواست گارسون
function register_waiter_request_post_type() {
    register_post_type('waiter_request',
        array(
            'labels' => array(
                'name' => __('درخواست‌های گارسون'),
                'singular_name' => __('درخواست گارسون')
            ),
            'public' => true,
            'has_archive' => false,
            'show_in_menu' => true,
            'supports' => array('title'),
        )
    );
}
add_action('init', 'register_waiter_request_post_type');



// تعریف لیست آیکون‌ها
function get_food_category_icons() {
    return array(
        'icon3' => '/foodicons/Chinese.png',
        'icon4' => '/foodicons/hamburger.png',
        'icon5' => '/foodicons/pizza.png',
        'icon6' => '/foodicons/cocktail.png',
        'icon7' => '/foodicons/cocktail2.png',
        'icon8' => '/foodicons/coffee-cup.png',
        'icon9' => '/foodicons/soft-drink.png',
        'icon10' => '/foodicons/pizza2.png',
        'icon11' => '/foodicons/petato.png',
        'icon12' => '/foodicons/pastfood.png',
        'icon13' => '/foodicons/kebab.png',
        'icon14' => '/foodicons/petato.png',
        'icon15' => '/foodicons/drink2.png',
        'icon16' => '/foodicons/drink3.png',
        'icon17' => '/foodicons/cream.png',
        'icon18' => '/foodicons/chiken.png',
        'icon19' => '/foodicons/bereng.png',
    );
}

// افزودن فیلد آیکون دسته‌بندی به فرم ایجاد دسته‌بندی
function add_food_category_icon_field($taxonomy) {
    $icons = get_food_category_icons(); // دریافت لیست آیکون‌ها
    ?>
    <div class="form-field term-group">
        <label for="category-icon"><?php _e('آیکون دسته‌بندی', 'mytheme'); ?></label>
        <div id="category-icons">
            <?php foreach ($icons as $value => $label) : ?>
                <label class="category-icon-option" style="display: inline-block; margin-right: 10px;">
                    <input type="radio" name="category-icon" value="<?php echo esc_attr($value); ?>" />
                    <img src="<?php echo get_theme_image_url($label)?>" alt="<?php echo esc_attr($label); ?>" style="width: 30px; height: 30px;" />
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
add_action('food_category_add_form_fields', 'add_food_category_icon_field', 10, 2);

// ویرایش فیلد آیکون دسته‌بندی هنگام ویرایش
function edit_food_category_icon_field($term, $taxonomy) {
    $icon_value = get_term_meta($term->term_id, 'category_icon', true);
    $icons = get_food_category_icons(); // دریافت لیست آیکون‌ها
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category-icon"><?php _e('آیکون دسته‌بندی', 'mytheme'); ?></label></th>
        <td>
            <div id="category-icons">
                <?php foreach ($icons as $value => $label) : ?>
                    <label class="category-icon-option" style="display: inline-block; margin-right: 10px;">
                        <input type="radio" name="category-icon" value="<?php echo esc_attr($value); ?>" <?php checked($icon_value, $value); ?> />
                        <img src="<?php echo get_theme_image_url($label)?>" alt="<?php echo esc_attr($label); ?>" style="width: 30px; height: 30px;" />
                    </label>
                <?php endforeach; ?>
            </div>
        </td>
    </tr>
    <?php
}
add_action('food_category_edit_form_fields', 'edit_food_category_icon_field', 10, 2);





// ذخیره تصویر دسته‌بندی و حذف آیکون در صورت استفاده از تصویر
function save_food_category_image_and_icon($term_id, $tt_id) {
    if (isset($_POST['category-image-id']) && $_POST['category-image-id'] !== '') {
        // ذخیره تصویر دسته‌بندی
        add_term_meta($term_id, 'category_image', $_POST['category-image-id'], true);
        
        // اگر تصویری انتخاب شده است، آیکون را حذف کنید
        delete_term_meta($term_id, 'category_icon');
    } else {
        // حذف تصویر دسته‌بندی اگر هیچ تصویری انتخاب نشد
        delete_term_meta($term_id, 'category_image');
    }

    // ذخیره آیکون دسته‌بندی و حذف تصویر در صورت استفاده از آیکون
    if (isset($_POST['category-icon']) && $_POST['category-icon'] !== '') {
        // ذخیره آیکون دسته‌بندی
        update_term_meta($term_id, 'category_icon', sanitize_text_field($_POST['category-icon']));
        
        // اگر آیکونی انتخاب شده است، تصویر را حذف کنید
        delete_term_meta($term_id, 'category_image');
    } else {
        // حذف آیکون دسته‌بندی اگر هیچ آیکونی انتخاب نشد
        delete_term_meta($term_id, 'category_icon');
    }
}
add_action('created_food_category', 'save_food_category_image_and_icon', 10, 2);
add_action('edited_food_category', 'save_food_category_image_and_icon', 10, 2);


// ایجاد صفحه تنظیمات جدید
function cafe_settings_menu() {
    add_menu_page(
        'اطلاعات کافه',       // عنوان صفحه
        'اطلاعات کافه',       // عنوان منو
        'manage_options',     // دسترسی به تنظیمات
        'cafe-settings',      // شناسه صفحه
        'cafe_settings_page', // تابع برای نمایش صفحه تنظیمات
        'dashicons-store',    // آیکون منو
        30                    // اولویت
    );
}
add_action('admin_menu', 'cafe_settings_menu');


// اضافه کردن تنظیمات و فیلدها
function cafe_settings_init() {
    // ثبت تنظیمات
    register_setting('cafe_settings_group', 'cafe_name');
    register_setting('cafe_settings_group', 'cafe_name_en');
    register_setting('cafe_settings_group', 'cafe_logo');
    register_setting('cafe_settings_group', 'cafe_image');
    register_setting('cafe_settings_group', 'cafe_instagram');
    register_setting('cafe_settings_group', 'cafe_phone');
    register_setting('cafe_settings_group', 'cafe_description');
    register_setting('cafe_settings_group', 'cafe_address');
    register_setting('cafe_settings_group', 'cafe_latitude');
register_setting('cafe_settings_group', 'cafe_longitude');

    // ایجاد بخش برای تنظیمات
    add_settings_section(
        'cafe_general_section', // شناسه بخش
        'اطلاعات کافه',        // عنوان بخش
        null,                   // توضیحات
        'cafe-settings'         // صفحه‌ای که بخش در آن نمایش داده می‌شود
    );


    add_settings_field(
        'cafe_latitude', 
        'عرض جغرافیایی', 
        'cafe_latitude_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_longitude', 
        'طول جغرافیایی', 
        'cafe_longitude_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    // فیلدهای ورودی
    add_settings_field(
        'cafe_name', 
        'نام کافه', 
        'cafe_name_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_name_en', 
        'نام انگلیسی کافه', 
        'cafe_name_en_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_logo', 
        'لوگوی کافه', 
        'cafe_logo_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_image', 
        'تصویر کافه', 
        'cafe_image_field', 
        'cafe-settings', 
        'cafe_general_section'
    );

    add_settings_field(
        'cafe_address', 
        'آدرس کافه', 
        'cafe_address_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_instagram', 
        'اینستاگرام', 
        'cafe_instagram_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_phone', 
        'شماره تماس', 
        'cafe_phone_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
    add_settings_field(
        'cafe_description', 
        'توصیف کوتاه کافه', 
        'cafe_description_field', 
        'cafe-settings', 
        'cafe_general_section'
    );
}
add_action('admin_init', 'cafe_settings_init');
function cafe_latitude_field() {
    $value = get_option('cafe_latitude');
    echo '<input type="text" name="cafe_latitude" value="' . esc_attr($value) . '" class="regular-text" />';
}

function cafe_longitude_field() {
    $value = get_option('cafe_longitude');
    echo '<input type="text" name="cafe_longitude" value="' . esc_attr($value) . '" class="regular-text" />';
}

function cafe_admin_map_script() {
    wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');
    wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
}
add_action('admin_enqueue_scripts', 'cafe_admin_map_script');

function cafe_settings_page() {
    ?>
    <div class="wrap">
        <h1>اطلاعات کافه</h1>
        <h2>انتخاب مکان کافه روی نقشه</h2>
        <div id="map" style="height: 400px;"></div>
        <script>
           var defaultLatitude = <?php echo esc_js(get_option('cafe_latitude', 35.6892)); ?>;
var defaultLongitude = <?php echo esc_js(get_option('cafe_longitude', 51.3890)); ?>;

var map = L.map('map').setView([defaultLatitude, defaultLongitude], 13); // مرکزیت نقشه
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var marker = L.marker([defaultLatitude, defaultLongitude]).addTo(map);

map.on('click', function(e) {
    marker.setLatLng(e.latlng);
    document.querySelector('input[name="cafe_latitude"]').value = e.latlng.lat;
    document.querySelector('input[name="cafe_longitude"]').value = e.latlng.lng;
});

        </script>
    </div>
        <form method="post" action="options.php">
            <?php
            settings_fields('cafe_settings_group');
            do_settings_sections('cafe-settings');
            submit_button();
            ?>
        </form>

   
    <?php
}

// نمایش فیلدهای ورودی
function cafe_name_field() {
    $value = get_option('cafe_name');
    echo '<input type="text" name="cafe_name" value="' . esc_attr($value) . '" class="regular-text" />';
}

function cafe_name_en_field() {
    $value = get_option('cafe_name_en');
    echo '<input type="text" name="cafe_name_en" value="' . esc_attr($value) . '" class="regular-text" />';
}


function cafe_address_field() {
    $value = get_option('cafe_address');
    echo '<input type="text" name="cafe_address" value="' . esc_attr($value) . '" class="regular-text" />';
}


function cafe_logo_field() {
    $value = get_option('cafe_logo');
    echo '<input type="text" name="cafe_logo" value="' . esc_attr($value) . '" class="regular-text" id="cafe_logo" />';
    echo '<input type="button" class="button" value="انتخاب لوگو" id="upload_logo_button" />';
}

function cafe_image_field() {
    $value = get_option('cafe_image');
    echo '<input type="text" name="cafe_image" value="' . esc_attr($value) . '" class="regular-text" id="cafe_image" />';
    echo '<input type="button" class="button" value="انتخاب تصویر" id="upload_image_button" />';
}

function cafe_instagram_field() {
    $value = get_option('cafe_instagram');
    echo '<input type="text" name="cafe_instagram" value="' . esc_attr($value) . '" class="regular-text" />';
}

function cafe_phone_field() {
    $value = get_option('cafe_phone');
    echo '<input type="text" name="cafe_phone" value="' . esc_attr($value) . '" class="regular-text" />';
}

function cafe_description_field() {
    $value = get_option('cafe_description');
    echo '<textarea name="cafe_description" class="regular-text" rows="5">' . esc_textarea($value) . '</textarea>';
}



// بارگذاری اسکریپت‌های مورد نیاز برای انتخاب رسانه
function cafe_media_uploader_script() {
    wp_enqueue_media(); // این خط به بارگذاری کتابخانه رسانه وردپرس کمک می‌کند
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var mediaUploader;

            $('#upload_logo_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب لوگو',
                    button: {
                        text: 'انتخاب لوگو'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#cafe_logo').val(attachment.url);
                });

                mediaUploader.open();
            });

            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب تصویر کافه',
                    button: {
                        text: 'انتخاب تصویر'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#cafe_image').val(attachment.url);
                });

                mediaUploader.open();
            });
        });
    </script>
    <?php
}
add_action('admin_enqueue_scripts', 'cafe_media_uploader_script');

// بارگذاری رسانه‌ها (تصاویر)
function cafe_media_uploader() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var mediaUploader;

            $('#upload_logo_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب لوگو',
                    button: {
                        text: 'انتخاب لوگو'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#cafe_logo').val(attachment.url);
                });

                mediaUploader.open();
            });

            $('#upload_image_button').click(function(e) {
                e.preventDefault();
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'انتخاب تصویر کافه',
                    button: {
                        text: 'انتخاب تصویر'
                    },
                    multiple: false
                });

                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#cafe_image').val(attachment.url);
                });

                mediaUploader.open();
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'cafe_media_uploader');

// پایان فایل functions.php
?>
