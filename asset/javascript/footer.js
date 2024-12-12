const list = document.querySelectorAll(".list");
const indicators = document.querySelectorAll(".indicator");

function activeLink() {
  // حذف کلاس‌های active از تمام تب‌ها
  list.forEach((item) => item.classList.remove("active"));
  // افزودن کلاس active به تب کلیک شده
  this.classList.add("active");

  // برای هر indicator انیمیشن را اعمال کنید
  indicators.forEach((indicator) => {
    indicator.classList.remove("indicatoranim"); // ابتدا کلاس انیمیشن را حذف کنید (اگر از قبل وجود دارد)
    void indicator.offsetWidth; // بازنشانی انیمیشن
    indicator.classList.add("indicatoranim"); // افزودن کلاس انیمیشن

    // حذف کلاس انیمیشن بعد از پایان انیمیشن
    setTimeout(() => {
      indicator.classList.remove("indicatoranim");
    },1000); // مدت زمان انیمیشن (۲ ثانیه)
  });
}

// افزودن event listener برای هر تب
list.forEach((item) => item.addEventListener("click", activeLink));
