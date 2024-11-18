
    
     $(document).ready(function () {
        // زمانی که دکمه‌ها کلیک می‌شوند
        $(".tab-button").click(function () {
            // همه تب‌ها را مخفی کرده و انیمیشن را شروع می‌کنیم
            $(".tab-content").fadeOut(300, function () {
                $(this).removeClass("active-tab");
            });
    
            // شناسه دکمه کلیک شده را بگیرید
            var tabId = $(this).attr("id").replace("tab-", "");
    
            // تب مربوطه را نمایش دهید
            $("#content-" + tabId).fadeIn(300, function () {
                $(this).addClass("active-tab");
            });
        });
    
        // به طور پیش‌فرض، اولین تب را نمایش دهید
        $("#content-home").addClass("active-tab");
        $(".tab-content").hide();
        $("#content-home").show();
    });
    