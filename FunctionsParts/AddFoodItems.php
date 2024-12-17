<?php 


function add_discount_column_to_food_items($columns) {
    $columns['discount'] = __('تخفیف', 'mytheme');  // افزودن ستون تخفیف
    return $columns;
}
add_filter('manage_food_item_posts_columns', 'add_discount_column_to_food_items');

// نمایش وضعیت تخفیف در ستون جدید
function display_discount_in_food_items_column($column, $post_id) {
    if ($column === 'discount') {
        // بررسی وجود قیمت تخفیف‌دار
        $discount_price = get_post_meta($post_id, 'discount_price', true);
        if (!empty($discount_price)) {
            echo '
            <style>

            .discount-badge-container {
    margin-top: 5px;
}

.discount-badge {
    background-color: #FF5733;
    color: white;
    font-weight: bold;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 0.9rem;
    text-transform: uppercase;
    display: inline-block;
    margin-left: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
}

.discount-badge:hover {
    background-color: #C0392B;
}


</style>
            <span class="discount-badge">' . __('تخفیف‌دار', 'mytheme') . '</span>';
        } else {
            echo '<span style="color: black;">' . __('بدون تخفیف', 'mytheme') . '</span>';
        }
    }
}
add_action('manage_food_item_posts_custom_column', 'display_discount_in_food_items_column', 10, 2);

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

