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

// ثبت نوع پست سفارشی برای آیتم‌های غذا
function register_food_post_type()
{
    register_post_type(
        'food_item',
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
function add_food_item_meta_boxes()
{
    add_meta_box('food_price_meta_box', __('قیمت غذا', 'mytheme'), 'render_food_price_meta_box', 'food_item', 'side', 'default');
}
add_action('add_meta_boxes', 'add_food_item_meta_boxes');

function render_food_price_meta_box($post)
{
    $price = get_post_meta($post->ID, 'food_price', true);
    ?>
    <label for="food_price"><?php _e('قیمت غذا (تومان)', 'mytheme'); ?></label>
    <input type="text" id="food_price" name="food_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;">
    <?php
}

// ذخیره قیمت غذا
function save_food_item_price($post_id)
{
    if (isset($_POST['food_price'])) {
        update_post_meta($post_id, 'food_price', sanitize_text_field($_POST['food_price']));
    }
}
add_action('save_post', 'save_food_item_price');

// اضافه کردن متا فیلد برای تصویر دسته‌بندی
function add_food_category_image_field($taxonomy)
{
    ?>
    <div class="form-field term-group">
        <label for="category-image-id"><?php _e('تصویر دسته‌بندی', 'mytheme'); ?></label>
        <input type="hidden" id="category-image-id" name="category-image-id" value="">
        <div id="category-image-wrapper"></div>
        <p>
            <input type="button" class="button button-secondary" id="category-image-button"
                value="<?php _e('افزودن تصویر', 'mytheme'); ?>">
            <input type="button" class="button button-secondary" id="category-image-remove-button"
                value="<?php _e('حذف تصویر', 'mytheme'); ?>">
        </p>
    </div>
    <?php
}
add_action('food_category_add_form_fields', 'add_food_category_image_field', 10, 2);

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


function edit_food_category_image_field($term, $taxonomy)
{
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
                <input type="button" class="button button-secondary" id="category-image-button"
                    value="<?php _e('تغییر تصویر', 'mytheme'); ?>">
                <input type="button" class="button button-secondary" id="category-image-remove-button"
                    value="<?php _e('حذف تصویر', 'mytheme'); ?>">
            </p>
        </td>
    </tr>
    <?php
}
add_action('food_category_edit_form_fields', 'edit_food_category_image_field', 10, 2);

// اضافه کردن جاوا اسکریپت آپلود
function add_category_image_script()
{
    if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'food_category') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('category-image-upload', get_template_directory_uri() . '/asset/javascript/category-image-upload.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'add_category_image_script');

function save_food_category_image($term_id, $tt_id)
{
    if (isset($_POST['category-image-id']) && '' !== $_POST['category-image-id']) {
        add_term_meta($term_id, 'category_image', $_POST['category-image-id'], true);
    } else {
        delete_term_meta($term_id, 'category_image');
    }
}
add_action('created_food_category', 'save_food_category_image', 10, 2);
add_action('edited_food_category', 'save_food_category_image', 10, 2);







// تعریف لیست آیکون‌ها
function get_food_category_icons()
{
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
function add_food_category_icon_field($taxonomy)
{
    $icons = get_food_category_icons(); // دریافت لیست آیکون‌ها
    ?>
    <div class="form-field term-group">
        <label for="category-icon"><?php _e('آیکون دسته‌بندی', 'mytheme'); ?></label>
        <div id="category-icons">
            <?php foreach ($icons as $value => $label): ?>
                <label class="category-icon-option" style="display: inline-block; margin-right: 10px;">
                    <input type="radio" name="category-icon" value="<?php echo esc_attr($value); ?>" />
                    <img src="<?php echo get_theme_image_url($label) ?>" alt="<?php echo esc_attr($label); ?>"
                        style="width: 30px; height: 30px;" />
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
add_action('food_category_add_form_fields', 'add_food_category_icon_field', 10, 2);

// ویرایش فیلد آیکون دسته‌بندی هنگام ویرایش
function edit_food_category_icon_field($term, $taxonomy)
{
    $icon_value = get_term_meta($term->term_id, 'category_icon', true);
    $icons = get_food_category_icons(); // دریافت لیست آیکون‌ها
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row"><label for="category-icon"><?php _e('آیکون دسته‌بندی', 'mytheme'); ?></label></th>
        <td>
            <div id="category-icons">
                <?php foreach ($icons as $value => $label): ?>
                    <label class="category-icon-option" style="display: inline-block; margin-right: 10px;">
                        <input type="radio" name="category-icon" value="<?php echo esc_attr($value); ?>" <?php checked($icon_value, $value); ?> />
                        <img src="<?php echo get_theme_image_url($label) ?>" alt="<?php echo esc_attr($label); ?>"
                            style="width: 30px; height: 30px;" />
                    </label>
                <?php endforeach; ?>
            </div>
        </td>
    </tr>
    <?php
}
add_action('food_category_edit_form_fields', 'edit_food_category_icon_field', 10, 2);





// ذخیره تصویر دسته‌بندی و حذف آیکون در صورت استفاده از تصویر
function save_food_category_image_and_icon($term_id, $tt_id)
{
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


// تابع Ajax برای جستجوی غذاها
function ajax_search_food_items()
{
    if (isset($_POST['query'])) {
        $query = sanitize_text_field($_POST['query']);
        $args = array(
            'post_type' => 'food_item',
            's' => $query,
            'posts_per_page' => 5, // Limit the results to 5
        );
        $search_query = new WP_Query($args);
        if ($search_query->have_posts()) {
            ?>
            <div class="card-container  ">
                <div class="art-board__container gap-4 viewfood yekan">
                    <?php
                    while ($search_query->have_posts()) {
                        $search_query->the_post();

                        $food_title = get_the_title();
                        $food_description = get_the_content();
                        $food_image = get_the_post_thumbnail_url();
                        $food_price = get_post_meta(get_the_ID(), 'food_price', true);
                        // گرفتن دسته‌بندی‌های غذا
                        $food_categories = wp_get_post_terms(get_the_ID(), 'food_category');
                        $category_ids = wp_list_pluck($food_categories, 'term_id'); ?>



                        <div data-price="<?php echo esc_html($food_price); ?>"
                            data-categories="<?php echo implode(' ', $category_ids); ?>" style="
    width: 100%;
    border: 1px solid #E8E8E8;
    height: 80px;
" class="flex card rounded-lg  items-center cursor-pointer z-[999] shadow">

                            <div class="card__image w-[100px]">
                                <img class="h-[full] w-full" src="<?php echo esc_url($food_image); ?>"
                                    alt="<?php echo esc_attr($food_title); ?>" />
                            </div>


                            <div  class="card__info" style="
    display: flex;
    flex-direction: column;
    align-items: unset;
    height: 100%;
    justify-content: space-between;
    padding-right: 10px;
">
   
                                <div class="card__info--title">
                                    <h3><?php echo esc_html($food_title); ?></h3>
                                    <p><?php echo esc_html(mb_substr($food_description, 0, 20, 'UTF-8')); ?>...</p>
                                    <!-- فقط 10 حرف اول -->

                                </div>

                                <div class="card__info--price">
                                    <p><?php echo esc_html($food_price); ?> تومان</p>
                                </div>
                            </div>
                        </div>


                        <script src="<?php echo get_template_directory_uri(); ?>/asset/javascript/openfoodmodal.js"></script>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        } else {
            echo '<p>نتیجه‌ای یافت نشد</p>';
        }
    }
    wp_die();
}

add_action('wp_ajax_nopriv_ajax_search_food_items', 'ajax_search_food_items');
add_action('wp_ajax_ajax_search_food_items', 'ajax_search_food_items');





// 1. ثبت پست تایپ سفارشی 'garson_request'
function create_garson_request_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'درخواست‌های گارسون',
            'singular_name' => 'درخواست گارسون',
            'add_new' => 'افزودن درخواست',
            'add_new_item' => 'افزودن درخواست گارسون جدید',
            'edit_item' => 'ویرایش درخواست گارسون',
            'new_item' => 'درخواست جدید',
            'view_item' => 'مشاهده درخواست',
            'search_items' => 'جستجوی درخواست‌ها',
            'not_found' => 'درخواستی یافت نشد',
            'not_found_in_trash' => 'درخواستی در سطل زباله یافت نشد',
            'parent_item_colon' => '',
            'menu_name' => 'درخواست‌های گارسون',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'show_in_rest' => true, // فعال‌سازی گوتنبرگ
        'menu_icon' => 'dashicons-cart', // آیکون پست تایپ
        'rewrite' => array('slug' => 'garson-requests'), // آدرس پست تایپ
    );

    register_post_type('garson_request', $args);
}
add_action('init', 'create_garson_request_post_type');
function handle_garson_request() {
    // بررسی nonce برای امنیت
    if( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'garson_request_nonce') ) {
        wp_send_json_error(array('message' => 'توکن امنیتی معتبر نیست.'));
    }

    // دریافت داده‌ها
    $table_number = sanitize_text_field($_POST['table_number']);
    $cart_contents = $_POST['cart_contents']; // فرض بر این است که محتوای سبد خرید JSON است

    // ذخیره داده‌ها در پست تایپ یا متاباکس‌ها
    $post_id = wp_insert_post(array(
        'post_type' => 'garson_request',
        'post_title' => 'درخواست شماره میز ' . $table_number,
        'post_status' => 'publish',
        'meta_input' => array(
            '_table_number' => $table_number,
            '_reserved_foods' => $cart_contents,
        ),
    ));

    if($post_id) {
        wp_send_json_success(array('message' => 'درخواست با موفقیت ثبت شد!'));
    } else {
        wp_send_json_error(array('message' => 'خطا در ثبت درخواست.'));
    }

    wp_die();
}
add_action('wp_ajax_submit_garson_request', 'handle_garson_request'); // برای کاربران وارد شده
add_action('wp_ajax_nopriv_submit_garson_request', 'handle_garson_request'); // برای کاربران غیر وارد شده

// ایجاد nonce برای امنیت
function enqueue_garson_request_script() {
    wp_localize_script('your-script-handle', 'ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('garson_request_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_garson_request_script');

// 2. افزودن متاباکس برای فیلدهای سفارشی (شماره میز و غذاهای رزرو شده)
function add_garson_request_meta_boxes() {
    add_meta_box(
        'garson_request_details', // ID متاباکس
        'جزئیات درخواست گارسون', // عنوان متاباکس
        'garson_request_meta_box_callback', // تابع کال‌بک
        'garson_request', // پست تایپ
        'normal', // موقعیت متاباکس
        'high' // اولویت نمایش متاباکس
    );
}
add_action('add_meta_boxes', 'add_garson_request_meta_boxes');

// 3. نمایش فیلدهای سفارشی در متاباکس
function garson_request_meta_box_callback($post) {
    // شماره میز
    $table_number = get_post_meta($post->ID, '_table_number', true);
    // غذاهای رزرو شده
    $reserved_foods = get_post_meta($post->ID, '_reserved_foods', true);

    // فیلد شماره میز
    echo '<label for="table_number">شماره میز:</label>';
    echo '<input type="text" id="table_number" name="table_number" value="' . esc_attr($table_number) . '" class="widefat">';

    // فیلد غذاهای رزرو شده
    echo '<label for="reserved_foods">غذاهای رزرو شده:</label>';
    echo '<textarea id="reserved_foods" name="reserved_foods" class="widefat" rows="5">' . esc_textarea($reserved_foods) . '</textarea>';
}

// 4. ذخیره داده‌های فیلدهای سفارشی
function save_garson_request_meta($post_id) {
    if (isset($_POST['table_number'])) {
        update_post_meta($post_id, '_table_number', sanitize_text_field($_POST['table_number']));
    }
    if (isset($_POST['reserved_foods'])) {
        update_post_meta($post_id, '_reserved_foods', sanitize_textarea_field($_POST['reserved_foods']));
    }
}
add_action('save_post', 'save_garson_request_meta');

// 5. نمایش ستون‌های اضافی (شماره میز و غذاهای رزرو شده) در جدول مدیریت پست‌ها
function display_garson_request_columns($columns) {
    $columns['table_number'] = 'شماره میز';
    $columns['reserved_foods'] = 'غذاهای رزرو شده';
    return $columns;
}
add_filter('manage_garson_request_posts_columns', 'display_garson_request_columns');

// 6. نمایش محتویات ستون‌ها
function display_garson_request_column_data($column, $post_id) {
    if ($column == 'table_number') {
        echo esc_html(get_post_meta($post_id, '_table_number', true));
    }
    if ($column == 'reserved_foods') {
        $reserved_foods = get_post_meta($post_id, '_reserved_foods', true);
        if ($reserved_foods) {
            $foods = json_decode($reserved_foods, true);
            foreach ($foods as $food) {
                echo $food['title'] . ' - تعداد: ' . $food['quantity'] . '<br>';
            }
        }
    }
}
add_action('manage_garson_request_posts_custom_column', 'display_garson_request_column_data', 10, 2);


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



