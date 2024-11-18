jQuery(document).ready(function($) {
    $('#search-input').on('input', function() {
        var query = $(this).val();
        if (query.length >= 3) { // جستجو پس از ۳ حرف
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    'action': 'ajax_search_food_items',
                    'query': query
                },
                success: function(data) {
                    // اضافه کردن عنوان نتایج
                    var resultsTitle = '<h2 style="padding: 5px; background-color: #e8e8e8;margin-bottom:5px;  color: #b49d9d; border-radius: 10px;">نتایج</h2>';
                    $('#suggestions-container').html(resultsTitle + data).show(); // نمایش عنوان نتایج همراه با داده‌ها
                }
            });
        } else {
            $('#suggestions-container').html('').hide(); // مخفی کردن پیشنهادات اگر کمتر از 3 حرف باشد
        }
    });
  
    // جلوگیری از ارسال فرم با کلید اینتر
    $('#search-input').on('keypress', function(e) {
        if (e.which === 13) { // 13 معادل کلید Enter است
            e.preventDefault(); // جلوگیری از عملکرد پیش‌فرض (ارسال فرم)
        }
    });
  });
  