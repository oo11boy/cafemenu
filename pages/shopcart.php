<div id="cart-items" class="cart-container p-4 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4">سبد خرید شما</h2>
    <!-- پیغام سبد خرید خالی -->
    <div id="empty-cart-message" class="hidden text-center text-lg text-gray-500">
        <p>سبد خرید شما خالی است!</p>
    </div>
    <div id="cart-list" class="flex flex-col gap-4"></div>
    <div class="mt-4 text-lg font-semibold">
        <p>جمع کل: <span id="total-price">0</span> تومان</p>
    </div>
</div>


<!-- دکمه ثبت درخواست گارسون -->
<button id="openGarsonModal" class="btn btn-primary">درخواست گارسون</button>

<!-- مودال درخواست گارسون -->
<div id="garsonModal" class="modal hidden">
  <div class="modal-content">
    <span id="closeModal" class="close">&times;</span>
    <h2>درخواست گارسون</h2>
    <label for="tableNumber">شماره میز:</label>
    <input type="text" id="tableNumber" placeholder="شماره میز را وارد کنید">
    <button id="submitGarsonRequest" class="btn btn-success">ثبت درخواست</button>
  </div>
</div>


<style>
    /* استایل‌های مودال */
.modal {
    display: none; /* مخفی بودن به طور پیش‌فرض */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0); /* رنگ پس‌زمینه */
    background-color: rgba(0,0,0,0.4); /* شفافیت پس‌زمینه */
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

button {
    margin-top: 10px;
}

</style>