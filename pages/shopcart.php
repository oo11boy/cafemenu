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

<script>
document.getElementById('openGarsonModal').addEventListener('click', function() {
    document.getElementById('garsonModal').style.display = 'block';
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('garsonModal').style.display = 'none';
});

document.getElementById('submitGarsonRequest').addEventListener('click', function() {
    const tableNumber = document.getElementById('tableNumber').value;
    const cartContents = localStorage.getItem('cart'); // فرض بر اینکه محتویات سبد خرید در localStorage ذخیره شده

    if (!tableNumber) {
        alert('لطفا شماره میز را وارد کنید!');
        return;
    }

    // اضافه کردن nonce برای امنیت
    const nonce = '<?php echo wp_create_nonce("garson_request_nonce"); ?>';

    const data = {
        action: 'submit_garson_request',
        table_number: tableNumber,
        cart_contents: cartContents,
        security: nonce // ارسال nonce برای امنیت
    };

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(data)
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.success) {
            alert('درخواست شما با موفقیت ارسال شد.');
            document.getElementById('garsonModal').style.display = 'none'; // بستن مودال
        } else {
            alert('خطا در ارسال درخواست. لطفا دوباره تلاش کنید.');
        }
    })
    .catch(error => {
        alert('خطای شبکه. لطفا دوباره تلاش کنید.');
    });
});
</script>

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