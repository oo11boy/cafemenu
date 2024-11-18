<div id="cart-items" class="cart-container    bg-white rounded-lg mt-2  mx-auto ">
<div class="flex w-full mb-2 bg-gray-200 border rounded-md p-2 reyhaneh justify-between items-center">
    <p class="text-3xl text-black"><?php echo esc_html(get_option('cafe_name')); ?></p>
    <img class="w-[50px] h-[50px] rounded-full"   src="<?php echo esc_url(get_option('cafe_logo')); ?>"
        alt="Default avatar">
</div> 
<!-- پیغام سبد خرید خالی -->
    <div id="empty-cart-message" class=" text-center text-lg text-gray-500">

    <div class="h-[55vh] flex-col flex justify-center gap-2 items-center w-full">
        
   <i class="fa fa-2x text-gray-400 fa-shopping-cart" aria-hidden="true"></i>
   <p class="text-gray-400   yekan" >سبد سفارشات شما خالی است! </p>
 
   </div>
    </div>
    <div id="cart-list" class="flex max-h-[55vh]  overflow-auto flex-col gap-4">

  
    
    </div>
    <div class="mt-6 yekan text-center text-lg font-semibold text-gray-700">
        <p>جمع کل: <span id="total-price">0</span> تومان</p>
    </div>
</div>

<!-- دکمه ثبت درخواست گارسون -->
<button id="openGarsonModal" class="mt-4  w-full p-4 reyhaneh bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
    درخواست گارسون
</button>

<!-- مودال درخواست گارسون -->
<div id="garsonModal" class="modal hidden fixed inset-0 flex justify-center items-center bg-gray-900 bg-opacity-50">
  <div class="modal-content bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <span id="closeModal" class="close absolute top-2 right-2 text-xl font-bold text-gray-500 cursor-pointer hover:text-gray-800">&times;</span>
    <h2 class="text-2xl font-semibold mb-4">درخواست گارسون</h2>
    <label for="tableNumber" class="text-lg text-gray-700">شماره میز:</label>
    <input type="text" id="tableNumber" placeholder="شماره میز را وارد کنید" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button id="submitGarsonRequest" class="mt-4 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300">
        ثبت درخواست
    </button>
  </div>
</div>

<script>

    
document.getElementById('openGarsonModal').addEventListener('click', function() {
    document.getElementById('garsonModal').style.display = 'flex';
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
