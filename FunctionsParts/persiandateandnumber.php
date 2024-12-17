<?php 


// تابع برای تبدیل اعداد انگلیسی به فارسی
function convert_to_persian_numbers($string) {
    $persian_numbers = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $english_numbers = range(0, 9);
    return str_replace($english_numbers, $persian_numbers, $string);
}

// تبدیل اعداد انگلیسی به فارسی در محتوای پست‌ها
add_filter('the_content', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در عناوین پست‌ها
add_filter('the_title', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در خلاصه پست‌ها
add_filter('the_excerpt', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در متن کامنت‌ها
add_filter('comment_text', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در تاریخ کامنت‌ها
add_filter('get_comment_date', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در زمان کامنت‌ها
add_filter('get_comment_time', 'convert_to_persian_numbers');

// تبدیل اعداد انگلیسی به فارسی در فیلدهای سفارشی (Advanced Custom Fields)
add_filter('acf/format_value', 'convert_to_persian_numbers', 20, 3);

// تبدیل اعداد انگلیسی به فارسی در ویجت‌ها
add_filter('widget_text', 'convert_to_persian_numbers');


// تابع برای تبدیل تاریخ و زمان کامنت‌ها به شمسی و اعداد فارسی
function convert_comment_date_to_jalali($comment_date) {
    // تبدیل تاریخ به شمسی
    $jalali_date = jdate('Y/m/d', strtotime($comment_date));
    
    // تبدیل اعداد به فارسی
    $jalali_date_persian_numbers = convert_to_persian_numbers($jalali_date);
    
    return $jalali_date_persian_numbers;
}

// استفاده در قالب برای نمایش تاریخ شمسی
add_filter('get_comment_date', 'convert_comment_date_to_jalali');
// تابع برای تبدیل زمان کامنت‌ها به شمسی و اعداد فارسی
function convert_comment_time_to_jalali($comment_time) {
    // تبدیل زمان به شمسی
    $jalali_time = jdate('H:i', strtotime($comment_time));
    
    // تبدیل اعداد به فارسی
    $jalali_time_persian_numbers = convert_to_persian_numbers($jalali_time);
    
    return $jalali_time_persian_numbers;
}

// استفاده در قالب برای نمایش زمان شمسی
add_filter('get_comment_time', 'convert_comment_time_to_jalali');


