document.addEventListener('DOMContentLoaded', function () {
  const categoryButtons = document.querySelectorAll('.category-btn');
  const foodItems = document.querySelectorAll('.card');
  const rangeInput = document.getElementById('rangeInput');
  const rangeValueDisplay = document.getElementById('rangeValue');
  const loadMoreButton = document.getElementById("loadMore");
    const cardsPerLoad = 4; 
    let activeCategory = "all";
    let visibleCardCount = 6;

 
    function updateCardVisibility() {
      let visibleCount = 0;
    
      foodItems.forEach((card) => {
        const cardCategories = card.dataset.categories.split(" ");
        const cardPrice = parseInt(card.dataset.price);
        const maxPrice = parseInt(rangeInput.value);
    
        const shouldShow =
          (activeCategory === "all" || cardCategories.includes(activeCategory)) &&
          cardPrice <= maxPrice;
    
        // اگر دسته‌بندی "همه" است، کارت‌ها را تا حد محدودیت نمایش بده
        if (activeCategory === "all" && shouldShow && visibleCount < visibleCardCount) {
          card.classList.remove("hidden");
          card.style.display = "block";
          visibleCount++;
        }
        // اگر دسته‌بندی دیگری است، همه کارت‌ها را نمایش بده
        else if (activeCategory !== "all" && shouldShow) {
          card.classList.remove("hidden");
          card.style.display = "block";
        } else {
          card.classList.add("hidden");
          card.style.display = "none";
        }
      });
    
      const totalCardsInCategory = Array.from(foodItems).filter((card) => {
        const cardCategories = card.dataset.categories.split(" ");
        const cardPrice = parseInt(card.dataset.price);
        const maxPrice = parseInt(rangeInput.value);
    
        return (
          (activeCategory === "all" || cardCategories.includes(activeCategory)) &&
          cardPrice <= maxPrice
        );
      }).length;
    
      // کنترل نمایش دکمه "بارگذاری بیشتر"
      if (activeCategory === "all" && totalCardsInCategory > visibleCount) {
        loadMoreButton.style.display = "block";
      } else {
        loadMoreButton.style.display = "none";
      }
    
      // پیام "محصولی وجود ندارد" در صورت عدم نمایش کارت
      const noItemsMessage = document.getElementById("noItemsMessage");
      if (visibleCount === 0 && totalCardsInCategory === 0) {
        if (!noItemsMessage) {
          const messageElement = document.createElement("div");
          messageElement.id = "noItemsMessage";
          messageElement.textContent = "محصولی وجود ندارد";
          messageElement.style.color = "red";
          messageElement.style.textAlign = "center";
          messageElement.style.marginTop = "20px";
          document.querySelector(".card-container").appendChild(messageElement);
        }
      } else if (noItemsMessage) {
        noItemsMessage.remove();
      }
    }
    
  

  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      activeCategory = this.getAttribute("data-category-id");
      visibleCardCount = 6;
      categoryButtons.forEach((btn) => btn.classList.remove("active-category"));
      this.classList.add("active-category");
      updateCardVisibility();
      if (activeCategory === "all") {
        loadMoreButton.classList.remove('hidden');  // نمایش دکمه "بارگذاری بیشتر"
      } else {
        loadMoreButton.classList.add('hidden');  // مخفی کردن دکمه برای دسته‌بندی‌های دیگر
      }
    });
  });

loadMoreButton.addEventListener("click", () => {
  visibleCardCount += cardsPerLoad;
  updateCardVisibility();  // بروزرسانی کارت‌ها بعد از بارگذاری بیشتر
});

  rangeInput.addEventListener("input", function () {
    rangeValueDisplay.textContent = this.value;
    updateCardVisibility();
  });

  updateCardVisibility();

  // مدیریت کلیک روی دکمه‌های دسته‌بندی
  categoryButtons.forEach(button => {
      button.addEventListener('click', function () {
          selectedCategoryId = this.getAttribute('data-category-id');
        
          // حذف کلاس 'active-category' از تمامی دکمه‌ها و افزودن به دکمه انتخاب شده
          categoryButtons.forEach(btn => btn.classList.remove('active-category'));
          this.classList.add('active-category');
      });
  });




});

