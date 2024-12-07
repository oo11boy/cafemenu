
 const priceFormat = (number) => {
    return `${new Intl.NumberFormat('fa-IR').format(number)} تومان`;
};


    document.querySelectorAll('.recipe-price').forEach((element) => {
        const rawPrice = element.getAttribute('data-raw-price');
        if (rawPrice) {
            element.textContent = priceFormat(rawPrice);
        }
    });
