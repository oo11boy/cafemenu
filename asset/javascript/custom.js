document.addEventListener('DOMContentLoaded', function () {
  const categoryButtons = document.querySelectorAll('.category-btn');
  const foodItems = document.querySelectorAll('.card');
  const rangeInput = document.getElementById('rangeInput');
  const rangeValueDisplay = document.getElementById('rangeValue');
  const loadMoreButton = document.getElementById("loadMore");
  const cardsPerLoad = 4; 
  let activeCategory = "all";
  let visibleCardCount = 6;

  const priceFormat = (number) => {
      return `${new Intl.NumberFormat('fa-IR').format(number)} تومان`;
  };

  function updateCardVisibility() {
      let visibleCount = 0
      
      foodItems.forEach((card) => {
          const cardCategories = card.dataset.categories.split(" ");
          const cardPrice = parseInt(card.dataset.price);
          const maxPrice = parseInt(rangeInput.value);

          const shouldShow =
              (activeCategory === "all" || cardCategories.includes(activeCategory)) &&
              cardPrice <= maxPrice;

          if (activeCategory === "all" && shouldShow && visibleCount < visibleCardCount) {
              card.classList.remove("hidden");
              card.style.display = "block";
              
              visibleCount++;
          } else if (activeCategory !== "all" && shouldShow) {
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

      if (activeCategory === "all" && totalCardsInCategory > visibleCount) {
          loadMoreButton.style.display = "block";
      } else {
          loadMoreButton.style.display = "none";
      }

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
              loadMoreButton.classList.remove('hidden');
          } else {
              loadMoreButton.classList.add('hidden');
          }
      });
  });

  loadMoreButton.addEventListener("click", () => {
      visibleCardCount += cardsPerLoad;
      updateCardVisibility();
  });

  rangeInput.addEventListener("input", function () {
      const value = ((this.value - this.min) / (this.max - this.min)) * 100;
      this.style.setProperty('--value', `${value}%`);
      rangeValueDisplay.textContent = priceFormat(this.value);
      
      updateCardVisibility();
  });

  if (rangeValueDisplay) {
      rangeValueDisplay.textContent = priceFormat(rangeInput.value); // مقداردهی اولیه
  }
  updateCardVisibility();
});
