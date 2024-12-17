<?php 

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


