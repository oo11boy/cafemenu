document.getElementById('submit-comment').addEventListener('click', function() {
    var name = document.getElementById('name').value;
    var comment = document.getElementById('comment').value;
    var rating = document.querySelector('.star-rating-container .star.selected') ? document.querySelector('.star-rating-container .star.selected').getAttribute('data-value') : null;
    var postId = document.querySelector('input[name="post_id"]').value; // شناسه پست

    // بررسی اینکه همه فیلدها پر شده‌اند
    if (!name || !comment || !rating) {
        alert('لطفاً تمام فیلدها را پر کنید.');
        return;
    }

    // ارسال درخواست به سرور
    var data = {
        action: 'submit_comment',
        name: name,
        comment: comment,
        rating: rating,
        post_id: postId
    };

    jQuery.post(ajax_object.ajax_url, data, function(response) {
        if (response.success) {
            alert(response.data.message); // نمایش پیام موفقیت
        } else {
            alert(response.data.message); // نمایش پیام خطا
        }
    });
});

// مدیریت امتیاز دهی ستاره‌ای
document.querySelectorAll('.star-rating-container .star').forEach(function(star) {
    star.addEventListener('click', function() {
        document.querySelectorAll('.star-rating-container .star').forEach(function(star) {
            star.classList.remove('selected'); // حذف کلاس انتخاب شده از همه ستاره‌ها
        });
        star.classList.add('selected'); // اضافه کردن کلاس انتخاب شده به ستاره انتخاب شده
    });
});



document.getElementById("addcomment").addEventListener("click", function() {
    const form = document.getElementById("commentForm");
    const icon = document.getElementById("icon");

    if (form.classList.contains("hidden")) {
        form.classList.remove("hidden");
        setTimeout(() => {
            form.classList.remove("opacity-0", "translate-y-4");
        }, 10); // Apply transition after making the form visible

        // Change icon to close
        icon.name = "close-outline";
    } else {
        form.classList.add("opacity-0", "translate-y-4");
        setTimeout(() => {
            form.classList.add("hidden");
        }, 500); // Wait for the animation to finish before hiding

        // Change icon back to add
        icon.name = "add-outline";
    }
});


const stars = document.querySelectorAll('.star');
const ratingValue = document.getElementById('rating-value');

stars.forEach(star => {
    star.addEventListener('mouseover', function() {
        // Highlight the stars on hover
        const value = parseInt(star.getAttribute('data-value'));
        stars.forEach(s => {
            if (parseInt(s.getAttribute('data-value')) <= value) {
                s.classList.add('gold');
            } else {
                s.classList.remove('gold');
            }
        });
    });

    star.addEventListener('mouseout', function() {
        // Remove the hover highlight after mouseout
        const value = parseInt(ratingValue.innerText);
        stars.forEach(s => {
            if (parseInt(s.getAttribute('data-value')) <= value) {
                s.classList.add('gold');
            } else {
                s.classList.remove('gold');
            }
        });
    });

    star.addEventListener('click', function() {
        // Set the rating based on clicked star
        const value = parseInt(star.getAttribute('data-value'));
        ratingValue.innerText = value;

        stars.forEach(s => {
            if (parseInt(s.getAttribute('data-value')) <= value) {
                s.classList.add('gold');
            } else {
                s.classList.remove('gold');
            }
        });
    });
});
