document.addEventListener('DOMContentLoaded', function() {
    // تابع برای باز کردن مودال
    function openBranchModal(branchId) {
      var modal = document.getElementById('modal-' + branchId);
      modal.style.display = 'flex'; // ابتدا مودال را نمایش می‌دهیم
      modal.classList.remove('modal-close'); // اطمینان از حذف کلاس بسته شدن
      setTimeout(function() {
        modal.classList.add('show'); // اضافه کردن کلاس برای نمایش مودال با انیمیشن
      }, 10); // تاخیر کوتاه برای اجرای صحیح انیمیشن
    }
  
    // تابع برای بستن مودال
    function closeBranchModal(branchId) {
      var modal = document.getElementById('modal-' + branchId);
      modal.classList.remove('show'); // حذف کلاس نمایش مودال
      modal.classList.add('modal-close'); // اضافه کردن کلاس انیمیشن بسته شدن
  
      // پس از انیمیشن بسته شدن (0.3 ثانیه تأخیر) مودال را کاملاً مخفی می‌کنیم
      setTimeout(function() {
        modal.style.display = 'none'; // مودال را پس از انیمیشن مخفی می‌کنیم
      }, 300); // مدت زمان انیمیشن (300 میلی‌ثانیه)
    }
  
    // اختصاص دادن توابع به دکمه‌ها
    window.openBranchModal = openBranchModal;
    window.closeBranchModal = closeBranchModal;
  });
  