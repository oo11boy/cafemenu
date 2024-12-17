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
    // ثبت تنظیمات برای هر تب به صورت جداگانه
    register_setting('cafe_general_settings_group', 'cafe_name');
    register_setting('cafe_general_settings_group', 'cafe_name_en');
    register_setting('cafe_general_settings_group', 'cafe_logo');
    register_setting('cafe_general_settings_group', 'cafe_image');
    register_setting('cafe_general_settings_group', 'cafe_instagram');
    register_setting('cafe_general_settings_group', 'cafe_phone');
    register_setting('cafe_general_settings_group', 'cafe_description');
    register_setting('cafe_general_settings_group', 'cafe_address');
    
    register_setting('cafe_location_settings_group', 'cafe_latitude');
    register_setting('cafe_location_settings_group', 'cafe_longitude');
    
    register_setting('cafe_activation_settings_group', 'comments_visibility');
    register_setting('cafe_activation_settings_group', 'branch_visibility');
    register_setting('cafe_activation_settings_group', 'takhfif_visibility');

    // ایجاد بخش‌ها برای تنظیمات

    // بخش برای تنظیمات عمومی
    add_settings_section(
        'cafe_general_section', 
        '',        
        null,                   
        'cafe-settings'         
    );
    
    // فیلدهای مربوط به تنظیمات عمومی
    add_settings_field('cafe_name', 'نام کافه', 'cafe_name_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_name_en', 'نام انگلیسی کافه', 'cafe_name_en_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_logo', 'لوگوی کافه', 'cafe_logo_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_image', 'تصویر کافه', 'cafe_image_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_address', 'آدرس کافه', 'cafe_address_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_instagram', 'اینستاگرام', 'cafe_instagram_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_phone', 'شماره تماس', 'cafe_phone_field', 'cafe-settings', 'cafe_general_section');
    add_settings_field('cafe_description', 'توصیف کوتاه کافه', 'cafe_description_field', 'cafe-settings', 'cafe_general_section');
    
    // بخش برای تنظیمات مکان
    add_settings_section(
        'loc_activation_section', 
        'مکان', 
        null,                       
        'loc-settings'             
    );
    
    // فیلدهای مربوط به تنظیمات مکان
    add_settings_field('cafe_latitude', 'عرض جغرافیایی', 'cafe_latitude_field', 'loc-settings', 'loc_activation_section');
    add_settings_field('cafe_longitude', 'طول جغرافیایی', 'cafe_longitude_field', 'loc-settings', 'loc_activation_section');
    
    // بخش برای تنظیمات فعال‌سازی
    add_settings_section(
        'cafe_activation_section', 
        '', 
        null,                       
        'status-settings'             
    );
    
    // فیلدهای مربوط به تنظیمات فعال‌سازی
    add_settings_field('comments_visibility', 'فعال/غیرفعال سازی بخش نظرات', 'comments_visibility_field', 'status-settings', 'cafe_activation_section');
    add_settings_field('branch_visibility', 'فعال/غیرفعال سازی بخش شعبه‌ها', 'branch_visibility_field', 'status-settings', 'cafe_activation_section');
    add_settings_field('takhfif_visibility', 'فعال/غیرفعال سازی بخش تخفیفات ویژه', 'takhfif_visibility_field', 'status-settings', 'cafe_activation_section');
}
add_action('admin_init', 'cafe_settings_init');


function comments_visibility_field() {
    $value = get_option('comments_visibility', 'enabled'); // پیش‌فرض فعال باشد

    echo '<label class="switch">';
    echo '<input type="checkbox" name="comments_visibility" value="enabled" ' . checked($value, 'enabled', false) . '>';
    echo '<span class="slider round"></span>';
    echo '</label>';

  ?>

<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:checked + .slider:before {
  transform: translateX(26px);
}

/* Optional: Add rounded corners to the switch */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style>
<?php
}

function takhfif_visibility_field() {
    $value = get_option('takhfif_visibility', 'enabled'); // پیش‌فرض فعال باشد

    echo '<label class="switch">';
    echo '<input type="checkbox" name="takhfif_visibility" value="enabled" ' . checked($value, 'enabled', false) . '>';
    echo '<span class="slider round"></span>';
    echo '</label>';


}


function branch_visibility_field() {
    $value = get_option('branch_visibility', 'enabled'); // پیش‌فرض فعال باشد

    echo '<label class="switch">';
    echo '<input type="checkbox" name="branch_visibility" value="enabled" ' . checked($value, 'enabled', false) . '>';
    echo '<span class="slider round"></span>';
    echo '</label>';

}



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
 

        <!-- ایجاد تب‌ها -->
        <div class="tabs">
            <button class="tablinks" onclick="openTab(event, 'general')">اطلاعات عمومی</button>
            <button class="tablinks" onclick="openTab(event, 'location')">مکان کافه</button>
           <button class="tablinks" onclick="openTab(event, 'activation')">فعال‌سازی/غیرفعال‌سازی</button> <!-- تب فعال‌سازی -->
        </div>

        <!-- محتویات تب‌ها -->
        <div id="general" class="tabcontent">
    <form method="post" action="options.php">
        <?php
        settings_fields('cafe_general_settings_group'); // تغییر به گروه تنظیمات جداگانه
        do_settings_sections('cafe-settings');
        submit_button();
        ?>
    </form>
</div>

<div id="location" class="tabcontent">
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
    <form method="post" action="options.php">
        <?php
        settings_fields('cafe_location_settings_group'); // تغییر به گروه تنظیمات جداگانه
        do_settings_sections('loc-settings');
        submit_button();
        ?>
    </form>
</div>

<div id="activation" class="tabcontent">
    <form method="post" action="options.php">
        <?php
        settings_fields('cafe_activation_settings_group'); // تغییر به گروه تنظیمات جداگانه
        do_settings_sections('status-settings');
        submit_button();
        ?>
    </form>
</div>

    </div>

    <!-- استایل تب‌ها -->
    <style>
        .wrap{
            width: 80%;
            margin:10% auto;
            
        }
    /* طراحی تب‌ها */
    .tabs {
        display: flex;
        margin-bottom: 20px;
        border-bottom: 2px solid #ddd;
    }

    .tablinks {
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        padding: 10px 20px;
        cursor: pointer;
        margin-right: 5px;
        font-size: 16px;
        border-radius: 4px 4px 0 0;
        transition: background-color 0.3s ease;
        text-align: center;
        flex: 1;
    }

    .tablinks:hover {
        background-color: #e0e0e0;
    }

    .tablinks.active {
        background-color: #2196F3;
        color: white;
        border-color: #2196F3;
    }

    .tabcontent {
        display: none;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 4px 4px;
        margin-top: -1px;
    }

    .tabcontent.active {
        display: block;
    }

    /* طراحی دکمه‌ها */
    .button {
        background-color: #2196F3;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #1976d2;
    }

    /* طراحی ورودی‌ها */
    .regular-text {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    .regular-text:focus {
        border-color: #2196F3;
        outline: none;
    }

    /* طراحی سوئیچ‌ها */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    /* طراحی نقشه */
    #map {
        height: 400px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }



    </style>

    <!-- جاوا اسکریپت برای عملکرد تب‌ها -->
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // پیش‌فرض باز کردن اولین تب
        document.querySelector('.tablinks').click();
    </script>
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