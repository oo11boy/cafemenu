<?php 


function enqueue_comment_script() {
    wp_enqueue_script('comment-ajax', get_template_directory_uri() . '/asset/javascript/comment.js', array('jquery'), null, true);

    // انتقال URL AJAX به جاوااسکریپت
    wp_localize_script('comment-ajax', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_comment_script');


function add_rating_to_comment_form($fields) {
    $fields['rating'] = '<p class="comment-form-rating">
                            <label for="rating">' . __('Rating') . '</label>
                            <span class="required">*</span>
                            <input type="number" name="rating" id="rating" value="" min="1" max="5" />
                          </p>';
    return $fields;
}
add_filter('comment_form_fields', 'add_rating_to_comment_form');


function save_comment_rating($comment_id) {
    if (isset($_POST['rating'])) {
        $rating = intval($_POST['rating']);
        if ($rating >= 1 && $rating <= 5) {
            add_comment_meta($comment_id, 'rating', $rating);
        }
    }
}
add_action('comment_post', 'save_comment_rating');

// افزودن ستون برای نمایش رتبه‌بندی در بخش کامنت‌ها
function add_rating_column_to_comments($columns) {
    $columns['rating'] = 'Rating';
    return $columns;
}
add_filter('manage_edit-comments_columns', 'add_rating_column_to_comments');

// نمایش رتبه‌بندی در ستون جدید
function show_rating_in_comment_column($column, $comment_id) {
    if ($column === 'rating') {
        $rating = get_comment_meta($comment_id, 'rating', true);
        echo $rating ? $rating : 'No rating';
    }
}
add_action('manage_comments_custom_column', 'show_rating_in_comment_column', 10, 2);



// ثبت اکشن برای ارسال نظرات از طریق AJAX
function handle_comment_submission() {
    // چک کردن ورودی‌ها
    if ( isset($_POST['name']) && isset($_POST['comment']) && isset($_POST['rating']) ) {
        $name = sanitize_text_field($_POST['name']);
        $comment = sanitize_textarea_field($_POST['comment']);
        $rating = intval($_POST['rating']);

        // تنظیمات برای ذخیره دیدگاه
        $post_id = $_POST['post_id']; // شناسه پست

        // ایجاد دیدگاه جدید
        $comment_data = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $name,
            'comment_content' => $comment,
            'comment_approved' => 0,
            'comment_date' => current_time('mysql'),
            'comment_meta' => array(
                'rating' => $rating // ذخیره امتیاز
            )
        );

        // افزودن دیدگاه
        $comment_id = wp_insert_comment($comment_data);

        if ($comment_id) {
            wp_send_json_success(array('message' => 'دیدگاه با موفقیت ارسال شد.'));
        } else {
            wp_send_json_error(array('message' => 'خطا در ارسال دیدگاه.'));
        }
    } else {
        wp_send_json_error(array('message' => 'لطفاً تمام فیلدها را پر کنید.'));
    }
}
add_action('wp_ajax_submit_comment', 'handle_comment_submission');
add_action('wp_ajax_nopriv_submit_comment', 'handle_comment_submission');
