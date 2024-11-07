function toggleModal() {
    const modal = document.getElementById('modal');
  
    if (modal.classList.contains('show')) {
      modal.classList.remove('show');
      modal.classList.add('hide');
  
      // مخفی کردن مودال بعد از اتمام انیمیشن
      setTimeout(() => {
        modal.style.display = 'none';
        modal.classList.remove('hide');
      }, 1000); // باید با زمان انیمیشن uptodown یکی باشد
    } else {
      modal.style.display = 'block';
      modal.classList.add('show');
    }
  }
  


  function updateValue(val) {
    document.getElementById('rangeValue').textContent = val;

    // فیلتر آیتم‌ها بر اساس قیمت
    const items = document.querySelectorAll('.viewfood > div');
    let visibleItems = 0; // شمارش تعداد آیتم‌های قابل مشاهده

    items.forEach(item => {
        const price = parseInt(item.getAttribute('data-price'));
        if (price <= val) {
            item.style.display = 'flex'; // نمایش آیتم
            visibleItems++;
        } else {
            item.style.display = 'none'; // مخفی کردن آیتم
        }
    });

    // نمایش پیام "محصولی وجود ندارد" اگر هیچ آیتمی قابل مشاهده نباشد
    const noItemsMessage = document.getElementById('noItemsMessage');
    if (visibleItems === 0) {
        if (!noItemsMessage) {
            const messageElement = document.createElement('div');
            messageElement.id = 'noItemsMessage';
            messageElement.textContent = 'محصولی وجود ندارد';
            messageElement.style.color = 'red'; // رنگ پیام
            messageElement.style.textAlign = 'center';
            messageElement.style.width = '100%';
            messageElement.style.marginTop = '100px';
            document.querySelector('.viewfood').appendChild(messageElement);
        }
    } else {
        if (noItemsMessage) {
            noItemsMessage.remove();
        }
    }
}


// گرفتن عناصر مودال و دکمه‌ها
var openModalBtn = document.getElementById('open-modal');
var closeModalBtn = document.getElementById('close-modal');
var waiterModal = document.getElementById('waiter-modal');

var submitRequestBtn = document.getElementById('submit-request');

var tableNumberInput = document.getElementById('table-number');
// نمایش مودال با انیمیشن
openModalBtn.addEventListener('click', function() {
    waiterModal.classList.remove('hidden');
    waiterModal.classList.add('modal-enter'); // حالت اولیه انیمیشن
    setTimeout(function() {
        waiterModal.classList.add('modal-enter-active'); // اضافه کردن حالت فعال انیمیشن
    }, 10); // یک تاخیر کوچک برای اعمال تغییرات
});

// بستن مودال با انیمیشن
closeModalBtn.addEventListener('click', function() {
    waiterModal.classList.add('modal-exit-active');
    waiterModal.classList.remove('modal-enter-active');

    setTimeout(function() {
        waiterModal.classList.add('hidden'); // پس از پایان انیمیشن، مودال مخفی شود
        waiterModal.classList.remove('modal-exit-active');
        waiterModal.classList.remove('modal-enter');
    }, 300); // مدت زمان انیمیشن (0.3 ثانیه)
});





// ارسال درخواست گارسون
submitRequestBtn.addEventListener('click', function() {
  var tableNumber = tableNumberInput.value;

  if (tableNumber === '') {
      alert('لطفا شماره میز را وارد کنید');
      return;
  }

  // ساختن درخواست Ajax
  var xhr = new XMLHttpRequest();
  xhr.open('POST', ajax_object.ajax_url, true);  // استفاده از ajax_object.ajax_url
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 400) {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
              alert('درخواست شما ارسال شد');
              waiterModal.classList.add('hidden');
              tableNumberInput.value = '';  // خالی کردن فیلد
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

  // ارسال داده‌ها به وردپرس
  xhr.send('action=submit_waiter_request&table_number=' + encodeURIComponent(tableNumber));
});

