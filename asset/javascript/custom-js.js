document.addEventListener("DOMContentLoaded", function () {
    const categoryButtons = document.querySelectorAll(".category-btn");
    const foodItems = document.querySelectorAll(".card");
    const rangeInput = document.getElementById("rangeInput");
    const rangeValueDisplay = document.getElementById("rangeValue");
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
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      selectedCategoryId = this.getAttribute("data-category-id");
      updateVisibleItems(rangeInput.value);
      // حذف کلاس 'active-category' از تمامی دکمه‌ها و افزودن به دکمه انتخاب شده
      categoryButtons.forEach((btn) => btn.classList.remove("active-category"));
      this.classList.add("active-category");
    });
  });

  document.querySelectorAll(".category-btn").forEach((button) => {
    button.addEventListener("click", () => {
      // حذف کلاس active از تمام دکمه‌ها
      document.querySelectorAll(".category-btn").forEach((btn) => {
        btn.classList.remove("active");
      });

      // اضافه کردن کلاس active به دکمه کلیک شده
      button.classList.add("active");

      // انجام دیگر تغییرات لازم (مثل فیلتر کردن آیتم‌ها بر اساس دسته‌بندی)
      const categoryId = button.getAttribute("data-category-id");
      filterItems(categoryId);
    });
  });

  function filterItems(categoryId) {
    // مثال برای فیلتر کردن آیتم‌ها بر اساس دسته‌بندی
    document.querySelectorAll(".card").forEach((card) => {
      const cardCategories = card.getAttribute("data-categories").split(" ");
      if (categoryId === "all" || cardCategories.includes(categoryId)) {
        card.style.display = "block"; // نمایش دادن آیتم
      } else {
        card.style.display = "none"; // مخفی کردن آیتم
      }
    });
  }

  // مدیریت مودال غذا
  function toggleModal() {
    const modal = document.getElementById("modal");
    if (modal.classList.contains("show")) {
      modal.classList.remove("show");
      modal.classList.add("hide");
      setTimeout(() => {
        modal.style.display = "none";
        modal.classList.remove("hide");
      }, 1000); // زمان انیمیشن
    } else {
      modal.style.display = "block";
      modal.classList.add("show");
    }
  }

  function openModal(foodData) {
    const modal = document.getElementById("modal");
    modal.querySelector(".food-container img").src = foodData.image;
    modal.querySelector(".food-container img").alt = foodData.title;
    modal.querySelector(".food-modal .food-price").textContent =
      foodData.price + " تومان";
    modal.querySelector(".food-modal .food-title").textContent = foodData.title;
    modal.querySelector(".food-modal .food-description").textContent =
      foodData.description;
    toggleModal();
  }

  document.querySelectorAll(".card").forEach((card) => {
    card.addEventListener("click", () => {
      const foodData = {
        title: card.querySelector(".card__info h3").textContent,
        description: card.querySelector(".card__info span").textContent,
        image: card.querySelector(".card__image img").src,
        price: card.dataset.price,
      };
      openModal(foodData);
    });
  });

  // درخواست گارسون
  var openModalBtn = document.getElementById("open-modal");
  var closeModalBtn = document.getElementById("close-modal");
  var waiterModal = document.getElementById("waiter-modal");
  var submitRequestBtn = document.getElementById("submit-request");
  var tableNumberInput = document.getElementById("table-number");

  openModalBtn.addEventListener("click", function () {
    waiterModal.classList.remove("hidden");
    waiterModal.classList.add("modal-enter");
    setTimeout(function () {
      waiterModal.classList.add("modal-enter-active");
    }, 10);
  });

  closeModalBtn.addEventListener("click", function () {
    waiterModal.classList.add("modal-exit-active");
    waiterModal.classList.remove("modal-enter-active");
    setTimeout(function () {
      waiterModal.classList.add("hidden");
      waiterModal.classList.remove("modal-exit-active");
      waiterModal.classList.remove("modal-enter");
    }, 300);
  });

  submitRequestBtn.addEventListener("click", function () {
    var tableNumber = tableNumberInput.value;
    if (tableNumber === "") {
      alert("لطفا شماره میز را وارد کنید");
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", ajax_object.ajax_url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          alert("درخواست شما ارسال شد");
          waiterModal.classList.add("hidden");
          tableNumberInput.value = "";
        } else {
          alert("مشکلی در ارسال درخواست وجود دارد");
        }
      } else {
        alert("مشکلی در سرور وجود دارد");
      }
    };

    xhr.onerror = function () {
      alert("درخواست شما ارسال نشد، مشکل شبکه‌ای وجود دارد");
    };

    xhr.send(
      "action=submit_waiter_request&table_number=" +
        encodeURIComponent(tableNumber)
    );
  });
});
