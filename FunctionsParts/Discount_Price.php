
<?php
// افزودن متاباکس برای قیمت تخفیف‌دار
function add_food_item_discount_price_meta_box()
{
    add_meta_box('discount_price_meta_box', __('قیمت تخفیف‌دار', 'mytheme'), 'render_discount_price_meta_box', 'food_item', 'side', 'default');
}
add_action('add_meta_boxes', 'add_food_item_discount_price_meta_box');

// رندر متاباکس قیمت تخفیف‌دار
function render_discount_price_meta_box($post)
{
    $discount_price = get_post_meta($post->ID, 'discount_price', true);
    $discount_end_time = get_post_meta($post->ID, 'discount_end_time', true); // دریافت زمان پایان تخفیف
    
    // بررسی زمان و پاک کردن قیمت تخفیف پس از اتمام
    $current_time = current_time('timestamp');
    $end_time = strtotime($discount_end_time);
    if ($current_time > $end_time && !empty($discount_price)) {
        $discount_price = '';  // پاک کردن قیمت تخفیف پس از پایان زمان
        update_post_meta($post->ID, 'discount_price', ''); // به روز رسانی متاباکس
    }
    ?>
    <label for="discount_price"><?php _e('قیمت با تخفیف', 'mytheme'); ?></label>
    <input type="number" name="discount_price" id="discount_price" value="<?php echo esc_attr($discount_price); ?>" style="width: 100%;" />
    <br><br>
    <label for="discount_end_time"><?php _e('زمان پایان تخفیف', 'mytheme'); ?></label>
    <input type="datetime-local" name="discount_end_time" id="discount_end_time" value="<?php echo esc_attr($discount_end_time); ?>" style="width: 100%;" />
    <?php
}

// ذخیره فیلد قیمت تخفیف‌دار و زمان پایان تخفیف
function save_discount_price_meta($post_id)
{
    if (isset($_POST['discount_price'])) {
        update_post_meta($post_id, 'discount_price', sanitize_text_field($_POST['discount_price']));
    }

    if (isset($_POST['discount_end_time'])) {
        update_post_meta($post_id, 'discount_end_time', sanitize_text_field($_POST['discount_end_time']));
    }
}
add_action('save_post', 'save_discount_price_meta');

// بررسی زمان و پاک کردن قیمت تخفیف پس از اتمام
// بررسی و حذف قیمت تخفیف پس از اتمام زمان
function clear_discount_price_after_time($post_id)
{
    // اگر درخواست از نوع autosave یا revision باشد، متوقف شود
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // دریافت زمان پایان تخفیف
    $discount_end_time = get_post_meta($post_id, 'discount_end_time', true);
    
    // اگر زمان پایان تخفیف مشخص شده باشد
    if ($discount_end_time) {
        // تبدیل زمان پایان تخفیف به timestamp
        $end_time = strtotime($discount_end_time);
        
        // زمان فعلی
        $current_time = current_time('timestamp');
        
        // اگر زمان فعلی بیشتر از زمان پایان تخفیف باشد، قیمت تخفیف را پاک کن
        if ($current_time > $end_time) {
            delete_post_meta($post_id, 'discount_price');
        }
    }
}
add_action('save_post', 'clear_discount_price_after_time');
