<!-- مودال درخواست گارسون -->
<div class="modal-content !bg-[#ffffff4a] p-6 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-2xl reyhaneh text-[darkmagenta] font-semibold mb-4">درخواست گارسون</h2>
    <label for="tableNumber" class="text-lg text-gray-700">شماره میز:</label>
    <input type="text" id="tableNumber" placeholder="شماره میز را وارد کنید" class="mt-2 p-3 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button id="submitGarsonRequest" class="mt-4 px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300">
        ثبت درخواست
    </button>
  </div>



<script>




// ارسال درخواست گارسون
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
.modal-content {
    background-color: #fff;

    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px;
    margin-bottom: 25%;
    font-family: yekan;
}


#content-garson{
background-image: url(https://png.pngtree.com/background/20210711/original/pngtree-gourmet-delicious-poster-background-material-picture-image_1086655.jpg);
width: 100%;
height: 100vh;
background-size: cover;
background-position: center;
display: flex;
align-items: center;
justify-content: center;
}
</style>
