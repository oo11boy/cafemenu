jQuery(document).ready(function($) {
  $('#search-input').on('input', function() {
      var query = $(this).val();
      if (query.length >= 3) { // جستجو پس از ۳ حرف
          $.ajax({
              url: ajax_object.ajax_url,
              type: 'POST',
              data: {
                  'action': 'ajax_search_food_items',
                  'query': query
              },
              success: function(data) {
                  // اضافه کردن عنوان نتایج
                  var resultsTitle = '<h2 style="padding: 5px; background-color: #e8e8e8;margin-bottom:5px;  color: #b49d9d; border-radius: 10px;">نتایج</h2>';
                  $('#suggestions-container').html(resultsTitle + data).show(); // نمایش عنوان نتایج همراه با داده‌ها
              }
          });
      } else {
          $('#suggestions-container').html('').hide(); // مخفی کردن پیشنهادات اگر کمتر از 3 حرف باشد
      }
  });

  // جلوگیری از ارسال فرم با کلید اینتر
  $('#search-input').on('keypress', function(e) {
      if (e.which === 13) { // 13 معادل کلید Enter است
          e.preventDefault(); // جلوگیری از عملکرد پیش‌فرض (ارسال فرم)
      }
  });
});

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


});


document.querySelectorAll('.add-to-cart').forEach(button => {
  
  button.addEventListener('click', function() {
    // پیدا کردن بخش اینپوت تعداد و دکمه‌های + و - در نزدیکی دکمه + 
    const quantityInput = this.closest('.card__actions').querySelector('.quantity-input');
    const addButton = this;
    
    // مخفی کردن دکمه + 
    addButton.classList.add('hidden');
    
    // نمایش اینپوت تعداد و دکمه‌های + و - 
    quantityInput.classList.remove('hidden');
  });
});
document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', function() {
    
    const foodId = this.getAttribute('data-food-id');
    const foodPrice = parseFloat(this.getAttribute('data-food-price'));
    const foodTitle = this.getAttribute('data-food-title');
    const foodImage = this.getAttribute('data-food-image');

    // نمایان شدن بخش input تعداد
    const quantityInputDiv = this.closest('.card__actions').querySelector('.quantity-input');
    quantityInputDiv.classList.remove('hidden');

    const quantityInput = quantityInputDiv.querySelector('input');
    let quantity = parseInt(quantityInput.value);

    // افزایش تعداد
    quantityInputDiv.querySelector('.increase').addEventListener('click', () => {
      quantity++;
      quantityInput.value = quantity;
      updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
    });

    // کاهش تعداد
    quantityInputDiv.querySelector('.decrease').addEventListener('click', () => {
      if (quantity > 1) {
        quantity--;
        quantityInput.value = quantity;
        updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
      }
    });

    // بروز رسانی سبد خرید
    updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
  });
});

// تابع به‌روزرسانی سبد خرید
function updateCart(foodId, foodPrice, foodTitle, foodImage, quantity) {
  const cartItem = {
    id: foodId,
    title: foodTitle,
    price: foodPrice,
    image: foodImage,
    quantity: quantity
  };

  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  const existingItemIndex = cart.findIndex(item => item.id === foodId);
  if (existingItemIndex !== -1) {
    cart[existingItemIndex].quantity = quantity;
  } else {
    cart.push(cartItem);
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  displayCart();
}


// به‌روزرسانی سبد خرید و نمایش آن با دکمه حذف
function displayCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const cartList = document.getElementById('cart-list');
  const totalPriceElement = document.getElementById('total-price');
  const emptyCartMessage = document.getElementById('empty-cart-message'); // بخش پیغام خالی بودن سبد خرید

  cartList.innerHTML = ''; // پاک کردن لیست قبلی
  
  let totalPrice = 0;

  // اگر سبد خرید خالی است
  if (cart.length === 0) {
    emptyCartMessage.classList.remove('hidden'); // نمایش پیغام سبد خرید خالی
    totalPriceElement.textContent = '0'; // نمایش جمع کل 0
  } else {
    emptyCartMessage.classList.add('hidden'); // مخفی کردن پیغام سبد خرید خالی
    cart.forEach(item => {
      const itemTotal = item.price * item.quantity;
      totalPrice += itemTotal;

      const cartItemHTML = `
        <div class="flex justify-between items-center border-b pb-2" id="cart-item-${item.id}">
          <div class="cart-item-title">
            <h3>${item.title}</h3>
            <p>قیمت: ${item.price} تومان</p>
            <p>تعداد: ${item.quantity}</p>
          </div>
          <div class="cart-item-total">
            <p>مجموع: ${itemTotal} تومان</p>
            <!-- دکمه حذف -->
            <button class="remove-item" data-food-id="${item.id}">حذف</button>
          </div>
        </div>
      `;
      cartList.insertAdjacentHTML('beforeend', cartItemHTML);
    });

    totalPriceElement.textContent = totalPrice; // نمایش جمع کل قیمت

    // اضافه کردن رویداد برای دکمه حذف
    document.querySelectorAll('.remove-item').forEach(button => {
      button.addEventListener('click', function() {
        const foodId = this.getAttribute('data-food-id');
        removeFromCart(foodId);
      });
    });
  }
}

// تابع حذف از سبد خرید
function removeFromCart(foodId) {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];
  cart = cart.filter(item => item.id !== foodId); // فیلتر کردن آیتم با id خاص
  localStorage.setItem('cart', JSON.stringify(cart));
  displayCart(); // نمایش دوباره سبد خرید بعد از حذف
}
