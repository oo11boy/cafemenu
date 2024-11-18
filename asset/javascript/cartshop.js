
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
  
        
      <div class="flex h-[100px] yekan relative justify-starth-[80px] w-full border shadow" id="cart-item-${item.id}">
          <img class="w-[30%] h-[100%] object-cover"  src="${item.image}" >
          <div class=" py-2 pr-2  justify-between flex flex-col">
            <div class="flex justify-start"> <h2>${item.title}</h2></div> 
            <div>تعداد: ${item.quantity}</div>
              <p class="text-[green]">${item.price} تومان</p>
          </div>
  
  
          <i  data-food-id="${item.id}" class="remove-item cursor-pointer fa text-xl text-[red] fa-trash absolute top-[40%] left-4" aria-hidden="true"></i>
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
  