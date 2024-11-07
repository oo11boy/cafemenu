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


