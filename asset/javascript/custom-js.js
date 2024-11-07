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
  