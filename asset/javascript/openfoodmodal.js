// مدیریت باز و بسته کردن مودال

document.querySelectorAll('#card').forEach(card => {
    card.addEventListener('click', (e) => {
      // اطمینان از این که فقط روی کارت کلیک شده و نه دکمه سبد خرید
      if (!e.target.closest('.add-to-cart, .increase , .decrease ,.countcart')) {
   
        const foodData = {
            id: card.querySelector('.foodid').textContent,
          title: card.querySelector('#card__info h3').textContent,
          description: card.querySelector('#card__info span') ? card.querySelector('#card__info span').textContent : '',
          image: card.querySelector('#card__image img').src,
          price: card.dataset.price
        };
    
        openModal(foodData); // فراخوانی تابع برای باز کردن مودال
        
      }
      
    });
  });
  
// باز کردن مودال
function openModal(foodData) {
    const modal = document.getElementById('modal');
    modal.querySelector('.food-container img').src = foodData.image;
    modal.querySelector('.food-container img').alt = foodData.title;
    modal.querySelector('.food-modal .food-price').textContent = priceFormater(foodData.price)
    modal.querySelector('.food-modal .food-title').textContent = foodData.title;
    modal.querySelector('.food-modal .food-description').textContent = foodData.description;
 
// پیدا کردن دکمه add-to-cart و ست کردن اتریبیوت‌ها
const addToCartButton = modal.querySelector('.add-to-cart');
addToCartButton.setAttribute('data-food-id', foodData.id);
addToCartButton.setAttribute('data-food-price', foodData.price);
addToCartButton.setAttribute('data-food-title', foodData.title);
addToCartButton.setAttribute('data-food-image', foodData.image);
    toggleModal(); // باز کردن مودال
}
// بازنشانی دکمه‌ها و اینپوت‌ها هنگام بسته شدن مودال
function resetCartButtons() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        const quantityInputDiv = button.closest('.card__actions').querySelector('.quantity-input');
        const addButton = button;
       
        // مخفی کردن اینپوت تعداد و دکمه‌های + و - و نمایش دکمه "افزودن به سبد خرید"
        quantityInputDiv.classList.add('hidden');
        const quantityInput = quantityInputDiv.querySelector('input');
        quantityInput.value = 1;
        addButton.classList.remove('hidden');
    });
}
// تغییر حالت مودال
function toggleModal() {
    const modal = document.getElementById('modal');
    
    // بررسی وضعیت مودال و تغییر کلاس‌های آن
    if (modal.classList.contains('show')) {
        modal.classList.remove('show');
        modal.classList.add('hide');
        setTimeout(() => {
            modal.style.display = 'none';
            modal.classList.remove('hide');
            resetCartButtons(); // بازنشانی دکمه‌ها و اینپوت‌ها
        }, 300); // زمان انیمیشن
    } else {
    
        setTimeout(() => {
            modal.style.display = 'block';
            modal.classList.add('show');
        }, 10); // برای انیمیشن صاف‌تر
    }
}


// بستن مودال با کلیک خارج از آن
document.getElementById('modal').addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        toggleModal();
    }
});
