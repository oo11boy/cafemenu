<?php 

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
    <div style="" class="wrap">
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