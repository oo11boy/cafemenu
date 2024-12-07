const priceFormater = (number) => {
    return `${new Intl.NumberFormat('fa-IR').format(number)} تومان`;
};

const updatePrices = () => {
    document.querySelectorAll('.recipe-price').forEach((element) => {
    const rawPrice = parseFloat(element.getAttribute('data-raw-price'));
        if (!isNaN(rawPrice)) {
            element.textContent = priceFormater(rawPrice);
        }
    });
};

// اجرا در بارگذاری اولیه DOM
document.addEventListener('DOMContentLoaded', updatePrices);

// اجرا در بارگذاری محتوای Ajax
document.addEventListener('ajaxContentLoaded', updatePrices);
