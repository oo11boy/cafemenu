
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
        // پیدا کردن اینپوت تعداد و دکمه‌های + و - در نزدیکی دکمه
        const quantityInputDiv = this.closest('.card__actions').querySelector('.quantity-input');
        const addButton = this;
        
        // دریافت اطلاعات غذا
        const foodId = this.getAttribute('data-food-id');
        const foodPrice = parseFloat(this.getAttribute('data-food-price'));
        const foodTitle = this.getAttribute('data-food-title');
        const foodImage = this.getAttribute('data-food-image');
        
        // مخفی کردن دکمه "افزودن به سبد خرید" و نمایش بخش تعداد
        addButton.classList.add('hidden');
        quantityInputDiv.classList.remove('hidden');

        // دریافت اینپوت و تنظیم مقدار اولیه
        const quantityInput = quantityInputDiv.querySelector('input');
        let quantity = parseInt(quantityInput.value);

        // ثبت رویداد برای دکمه‌های افزایش و کاهش
        const increaseButton = quantityInputDiv.querySelector('.increase');
        const decreaseButton = quantityInputDiv.querySelector('.decrease');

        increaseButton.onclick = () => {
            quantity++;
            quantityInput.value = quantity;
            updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
        };

        decreaseButton.onclick = () => {
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;
                updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
            } else {
                // بازگرداندن به حالت دکمه "افزودن به سبد خرید" و مخفی کردن بخش تعداد
                addButton.classList.remove('hidden');
                quantityInputDiv.classList.add('hidden');
                // حذف از سبد خرید
                removeFromCart(foodId);
            }
        };

        // به‌روزرسانی سبد خرید در ابتدای کلیک
        updateCart(foodId, foodPrice, foodTitle, foodImage, quantity);
    });
});

// به‌روزرسانی تعداد اقلام سبد خرید
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.length;
    document.getElementById('cart-count').textContent = totalItems;
    console.log(totalItems);
}

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
    updateCartCount();
}

// تابع نمایش سبد خرید
function displayCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartList = document.getElementById('cart-list');
    const totalPriceElement = document.getElementById('total-price');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    
    cartList.innerHTML = ''; 
    let totalPrice = 0;

    if (cart.length === 0) {
        emptyCartMessage.classList.remove('hidden');
        totalPriceElement.textContent = '0';
    } else {
        emptyCartMessage.classList.add('hidden');
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            totalPrice += itemTotal;
            const cartItemHTML = `
                <div class="flex h-[100px] yekan relative justify-start w-full border shadow" id="cart-item-${item.id}">
                    <img class="w-[30%] h-[100%] object-cover" src="${item.image || '../wp-content/themes/cafemenu/asset/image/dimg.png'}">
                    <div class="py-2 pr-2 justify-between flex flex-col">
                        <h2>${item.title}</h2>
                        <div>تعداد: ${item.quantity}</div>
                        <p class="text-[green]">${item.price} تومان</p>
                    </div>
                    <i data-food-id="${item.id}" class="remove-item cursor-pointer fa text-xl text-[red] fa-trash absolute top-[40%] left-4"></i>
                </div>`;
            cartList.insertAdjacentHTML('beforeend', cartItemHTML);
        });
        totalPriceElement.textContent = totalPrice;

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
    cart = cart.filter(item => item.id !== foodId);
    localStorage.setItem('cart', JSON.stringify(cart));
    displayCart();
    updateCartCount();
}

  