<?php 

// اضافه کردن یک آیتم جدید به منوی داشبورد
function add_qr_code_menu_item() {
    add_menu_page(
        'QR Code منو',             // عنوان صفحه
        'QR Code منو',             // عنوان منو
        'manage_options',      // دسترسی کاربر
        'qr-code-dashboard',   // slug منو
        'qr_code_dashboard_page', // تابعی که محتوا را رندر می‌کند
        'dashicons-admin-site', // آیکون منو
        35                    // موقعیت منو
    );
}
add_action('admin_menu', 'add_qr_code_menu_item');

// تابع برای نمایش محتوای صفحه
function qr_code_dashboard_page() {
    // دریافت آدرس داینامیک سایت وردپرس
    $website_url = get_site_url();

    // ایجاد URL API برای تولید QR کد
    $qr_code_api_url = "https://qr-code.ir/api/qr-code/?s=5&e=M&t=P&d=" . urlencode($website_url);

    // خروجی HTML با قابلیت دانلود تصویر QR
    ?>
    <div class="wrap">
        <h1 style="text-align: center;">QR Code منو شما</h1>
        <div style="display: flex; justify-content: center; margin-top: 20px;">
            <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 300px; text-align: center;">
                <img src="<?php echo esc_url($qr_code_api_url); ?>" alt="QR Code" style="max-width: 100%; margin-bottom: 20px;">
                <p><strong>آدرس منو کافه یا رستوران:</strong> <?php echo esc_html($website_url); ?></p>
                <!-- لینک دانلود تصویر -->
                <a href="<?php echo esc_url($qr_code_api_url); ?>" download="qr-code.png" style="background-color: #0073aa; color: white; text-decoration: none; padding: 10px 20px; border-radius: 4px; display: inline-block; margin-top: 10px;">دانلود QR Code</a>
            </div>
            
        </div>
        <p style="text-align: center;">شما میتوانید این تصویر را در اختیار مشتریان جهت اسکن و ورود به منو کافه یا رستوران قرار دهید.</p>
       
    </div>
    <?php
}
