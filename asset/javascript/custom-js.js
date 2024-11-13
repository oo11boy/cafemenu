document.addEventListener('DOMContentLoaded', function () {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const foodItems = document.querySelectorAll('.card');
    const rangeInput = document.getElementById('rangeInput');
    const rangeValueDisplay = document.getElementById('rangeValue');
    let selectedCategoryId = 'all'; // مقدار پیش‌فرض برای نمایش همه ایتم‌ها

    // به‌روزرسانی آیتم‌های قابل مشاهده بر اساس دسته‌بندی و رنج قیمت
    function updateVisibleItems(maxPrice) {
        let visibleItems = 0;
        foodItems.forEach(item => {
            const itemCategories = item.getAttribute('data-categories').split(' ');
            const itemPrice = parseInt(item.getAttribute('data-price'));
            const matchesCategory = (selectedCategoryId === 'all' || itemCategories.includes(selectedCategoryId));
            const matchesPrice = itemPrice <= maxPrice;

            if (matchesCategory && matchesPrice) {
                item.style.display = 'flex';
                visibleItems++;
            } else {
                item.style.display = 'none';
            }
        });

        // نمایش پیام "محصولی وجود ندارد" اگر هیچ آیتمی پیدا نشد
        const noItemsMessage = document.getElementById('noItemsMessage');
        if (visibleItems === 0 && !noItemsMessage) {
            const messageElement = document.createElement('div');
            messageElement.id = 'noItemsMessage';
            messageElement.textContent = 'محصولی وجود ندارد';
            messageElement.style.color = 'red';
            messageElement.style.textAlign = 'center';
            messageElement.style.width = '100%';
            messageElement.style.marginTop = '100px';
            document.querySelector('.viewfood').appendChild(messageElement);
        } else if (noItemsMessage) {
            noItemsMessage.remove();
        }
    }

    // مدیریت تغییرات رنج قیمت
    rangeInput.addEventListener('input', function () {
        rangeValueDisplay.textContent = this.value;
        updateVisibleItems(this.value);
    });

    // مدیریت کلیک روی دکمه‌های دسته‌بندی
    categoryButtons.forEach(button => {
        button.addEventListener('click', function () {
            selectedCategoryId = this.getAttribute('data-category-id');
            updateVisibleItems(rangeInput.value);
            // حذف کلاس 'active-category' از تمامی دکمه‌ها و افزودن به دکمه انتخاب شده
            categoryButtons.forEach(btn => btn.classList.remove('active-category'));
            this.classList.add('active-category');
        });
    });

    // مدیریت مودال غذا

// تغییر حالت مودال
function toggleModal() {
    const modal = document.getElementById('modal');

    if (modal.classList.contains('show')) {
        modal.classList.remove('show');
        modal.classList.add('hide');
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('hide');
        }, 300); // زمان انیمیشن
    } else {
        modal.style.display = 'block';
        modal.classList.add('show');
    }
}

    // مدیریت باز و بسته کردن مودال
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', () => {
            const foodData = {
                title: card.querySelector('.card__info h3').textContent,
                description: card.querySelector('.card__info span') ? card.querySelector('.card__info span').textContent : '',
                image: card.querySelector('.card__image img').src,
                price: card.dataset.price
            };
            openModal(foodData); // فراخوانی تابع برای باز کردن مودال
        });
    });
    
    
  // باز کردن مودال
function openModal(foodData) {
    const modal = document.getElementById('modal');
    modal.querySelector('.food-container img').src = foodData.image;
    modal.querySelector('.food-container img').alt = foodData.title;
    modal.querySelector('.food-modal .food-price').textContent = foodData.price + ' تومان';
    modal.querySelector('.food-modal .food-title').textContent = foodData.title;
    modal.querySelector('.food-modal .food-description').textContent = foodData.description;

    toggleModal(); // باز کردن مودال
}
    
    document.getElementById('close-modal').addEventListener('click', () => {
        toggleModal();
    });
    
    // درخواست گارسون
    var openModalBtn = document.getElementById('open-modal');
    var closeModalBtn = document.getElementById('close-modal');
    var waiterModal = document.getElementById('waiter-modal');
    var submitRequestBtn = document.getElementById('submit-request');
    var tableNumberInput = document.getElementById('table-number');

    openModalBtn.addEventListener('click', function() {
        waiterModal.classList.remove('hidden');
        waiterModal.classList.add('modal-enter');
        setTimeout(function() {
            waiterModal.classList.add('modal-enter-active');
        }, 10);
    });

    closeModalBtn.addEventListener('click', function() {
        waiterModal.classList.add('modal-exit-active');
        waiterModal.classList.remove('modal-enter-active');
        setTimeout(function() {
            waiterModal.classList.add('hidden');
            waiterModal.classList.remove('modal-exit-active');
            waiterModal.classList.remove('modal-enter');
        }, 300);
    });

    submitRequestBtn.addEventListener('click', function() {
        var tableNumber = tableNumberInput.value;
        if (tableNumber === '') {
            alert('لطفا شماره میز را وارد کنید');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', ajax_object.ajax_url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('درخواست شما ارسال شد');
                    waiterModal.classList.add('hidden');
                    tableNumberInput.value = '';
                } else {
                    alert('مشکلی در ارسال درخواست وجود دارد');
                }
            } else {
                alert('مشکلی در سرور وجود دارد');
            }
        };

        xhr.onerror = function() {
            alert('درخواست شما ارسال نشد، مشکل شبکه‌ای وجود دارد');
        };

        xhr.send('action=submit_waiter_request&table_number=' + encodeURIComponent(tableNumber));
    });

    // جستجوی ایجکسی غذاها
    jQuery(document).ready(function($) {
        $('#search-input').on('input', function() {
            var query = $(this).val();
            if (query.length > 2) { // جستجو پس از ۲ حرف
                $.ajax({
                    url: ajax_object.ajax_url,
                    type: 'POST',
                    data: {
                        'action': 'ajax_search_food_items',
                        'query': query
                    },
                    success: function(data) {
                        $('#suggestions-container').html(data);
                    }
                });
            } else {
                $('#suggestions-container').html('');
            }
        });
    });
});


