<?php
// ثبت نوع پست سفارشی برای شعبات
function create_branch_post_type() {
    register_post_type( 'branches',
        array(
            'labels' => array(
                'name' => 'شعبات',
                'singular_name' => 'شعبه',
                'add_new' => 'افزودن شعبه جدید',
                'add_new_item' => 'افزودن شعبه جدید',
                'edit_item' => 'ویرایش شعبه',
                'new_item' => 'شعبه جدید',
                'view_item' => 'مشاهده شعبه',
                'search_items' => 'جستجو شعبات',
                'not_found' => 'هیچ شعبه‌ای یافت نشد',
                'not_found_in_trash' => 'هیچ شعبه‌ای در سطل زباله یافت نشد',
                'parent_item_colon' => '',
                'menu_name' => 'شعبات'
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'branches'),
            'show_in_rest' => true, // برای استفاده از بلوک گوتنبرگ
            'supports' => array('title', 'editor', 'thumbnail'),
        )
    );
}
add_action( 'init', 'create_branch_post_type' );

// افزودن متاباکس برای فیلدهای سفارشی
function add_branch_meta_boxes() {
    add_meta_box(
        'branch_details',
        'جزئیات شعبه',
        'branch_meta_box_callback',
        'branches', 
        'normal', 
        'high'
    );
}
add_action('add_meta_boxes', 'add_branch_meta_boxes');

// تابع برای نمایش فیلدهای متاباکس
function branch_meta_box_callback($post) {
    // اضافه کردن nonce برای امنیت
    wp_nonce_field( 'save_branch_details', 'branch_details_nonce' );

    // دریافت مقادیر فعلی فیلدها
    $branch_name = get_post_meta( $post->ID, '_branch_name', true );
    $branch_image = get_post_meta( $post->ID, '_branch_image', true );
    $branch_instagram = get_post_meta( $post->ID, '_branch_instagram', true );
    $branch_phone = get_post_meta( $post->ID, '_branch_phone', true );
    $branch_address = get_post_meta( $post->ID, '_branch_address', true );
    
    // نمایش فیلدها
    ?>
    <p>
        <label for="branch_name">نام شعبه:</label><br>
        <input type="text" id="branch_name" name="branch_name" value="<?php echo esc_attr( $branch_name ); ?>" style="width: 100%;" />
    </p>
    <p>
        <label for="branch_image">تصویر شعبه:</label><br>
        <input type="text" id="branch_image" name="branch_image" value="<?php echo esc_attr( $branch_image ); ?>" style="width: 100%;" />
        <button type="button" class="upload_image_button">انتخاب تصویر</button>
    </p>
    <p>
        <label for="branch_instagram">آدرس اینستاگرام:</label><br>
        <input type="text" id="branch_instagram" name="branch_instagram" value="<?php echo esc_attr( $branch_instagram ); ?>" style="width: 100%;" />
    </p>
    <p>
        <label for="branch_phone">شماره تماس:</label><br>
        <input type="text" id="branch_phone" name="branch_phone" value="<?php echo esc_attr( $branch_phone ); ?>" style="width: 100%;" />
    </p>
    <p>
        <label for="branch_address">آدرس شعبه:</label><br>
        <input type="text" id="branch_address" name="branch_address" value="<?php echo esc_attr( $branch_address ); ?>" style="width: 100%;" />
    </p>
    <script>
        jQuery(document).ready(function($){
            $('.upload_image_button').click(function(e) {
                e.preventDefault();
                var image = wp.media({ 
                    title: 'انتخاب تصویر',
                    button: { text: 'انتخاب تصویر' },
                    multiple: false
                }).open().on('select', function(e){
                    var selectedImage = image.state().get('selection').first().toJSON();
                    $('#branch_image').val(selectedImage.url);
                });
            });
        });
    </script>
    <?php
}

// ذخیره اطلاعات شعبه
function save_branch_details($post_id) {
    // بررسی nonce برای امنیت
    if ( ! isset( $_POST['branch_details_nonce'] ) || ! wp_verify_nonce( $_POST['branch_details_nonce'], 'save_branch_details' ) ) {
        return;
    }

    // ذخیره فیلدهای سفارشی
    if ( isset( $_POST['branch_name'] ) ) {
        update_post_meta( $post_id, '_branch_name', sanitize_text_field( $_POST['branch_name'] ) );
    }
    if ( isset( $_POST['branch_image'] ) ) {
        update_post_meta( $post_id, '_branch_image', esc_url_raw( $_POST['branch_image'] ) );
    }
    if ( isset( $_POST['branch_instagram'] ) ) {
        update_post_meta( $post_id, '_branch_instagram', esc_url_raw( $_POST['branch_instagram'] ) );
    }
    if ( isset( $_POST['branch_phone'] ) ) {
        update_post_meta( $post_id, '_branch_phone', sanitize_text_field( $_POST['branch_phone'] ) );
    }
    if ( isset( $_POST['branch_address'] ) ) {
        update_post_meta( $post_id, '_branch_address', sanitize_text_field( $_POST['branch_address'] ) );
    }
}
add_action('save_post', 'save_branch_details');
