jQuery(document).ready(function($) {
    var mediaUploader;

    $('#category-image-button').click(function(e) {
        e.preventDefault();

        // اگر بارگذار وجود دارد، آن را باز کن
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // ایجاد بارگذار رسانه
        mediaUploader = wp.media({
            title: 'انتخاب تصویر',
            button: {
                text: 'انتخاب تصویر'
            },
            multiple: false // به کاربر اجازه انتخاب چند تصویر را نمی‌دهد
        });

        // زمانی که تصویر انتخاب شد
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category-image-id').val(attachment.id);
            $('#category-image-wrapper').html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width:100%;"/>');
        });

        mediaUploader.open();
    });

    $('#category-image-remove-button').click(function(e) {
        e.preventDefault();
        $('#category-image-id').val('');
        $('#category-image-wrapper').html('');
    });
});
