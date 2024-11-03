
    // تابع برای باز کردن مودال
    function openModal(title, description) {
        document.getElementById('foodTitle').innerText = title;
       
        document.getElementById('foodModal').classList.remove('hidden');
    }

    // تابع برای بستن مودال
    function closeModal() {
        document.getElementById('foodModal').classList.add('hidden');
    }

    // افزودن رویداد به دکمه بستن
    document.getElementById('closeModal').addEventListener('click', closeModal);

    // افزودن رویداد کلیک به غذاها
    const foodItems = document.querySelectorAll('.viewfood .food-item'); // انتخاب همه غذاها
    foodItems.forEach(item => {
        item.addEventListener('click', function () {
            const title = this.querySelector('p').innerText; // عنوان غذا
            const description = this.querySelector('.food-description').value; // توضیحات غذا
            openModal(title, description);
        });
    });

