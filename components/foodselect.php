<div class="w-full custom-scroll vazir p-4 shadow-lg overflow-x-auto sticky top-0 bg-white z-10">
    <div class="flex gap-4">
        <!-- آیتم برگر -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]" src="https://pngimg.com/d/burger_sandwich_PNG96787.png" alt="">
            </div>
            <p class="text-black">برگر</p>
        </div>

        <!-- آیتم نوشیدنی گرم -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]"
                    src="https://static.vecteezy.com/system/resources/thumbnails/036/303/390/small_2x/ai-generated-steaming-coffee-cup-hot-beverage-illustration-transparent-background-coffee-mug-clipart-hot-drink-graphic-brewed-coffee-icon-cafe-latte-png.png"
                    alt="">
            </div>
            <p class="text-black">نوشیدنی گرم</p>
        </div>

        <!-- آیتم نوشیدنی سرد -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]" src="https://purepng.com/public/uploads/large/drinks-5cm.png" alt="">
            </div>
            <p class="text-black">نوشیدنی سرد</p>
        </div>

        <!-- آیتم پیتزا -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]"
                    src="https://www.transparentpng.com/thumb/pizza/hLgXMl-pizza-images-download.png" alt="">
            </div>
            <p class="text-black">پیتزا</p>
        </div>

        <!-- آیتم دسر -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]"
                    src="https://static.vecteezy.com/system/resources/previews/047/826/211/non_2x/raspberry-pudding-alone-against-transparent-background-free-png.png"
                    alt="">
            </div>
            <p class="text-black">دسر</p>
        </div>

        <!-- آیتم کیک -->
        <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] flex justify-center items-center p-2 rounded-xl">
                <img class="w-[100%] h-[60px]"
                    src="https://www.pngarts.com/files/1/Ice-Cream-Desserts-Transparent-Background-PNG.png" alt="">
            </div>
            <p class="text-black">کیک</p>
        </div>
    </div>
    
</div>


<div class="flex iransans gap-y-4 rounded-lg bg-[#4CAF50] z-10 shadow-lg  z-20 mt-5 items-center p-3 flex-row justify-between w-full">
 
    <input class="pricerange" style="accent-color: #1a543b" type="range" id="rangeInput" min="100000" step="100000" max="1000000" value="300000" oninput="updateValue(this.value)" />
    <div class="w-1/2 text-sm sm:text-sm text-left  text-white">
 زیر <span id="rangeValue" class="text-[10px] sm:text-sm">300000</span> تومان
  </div>
</div>

<div class="card-container">
      <div class="art-board__container gap-y-4 viewfood yekan">
         <div onclick="toggleModal()" class="card flex flex-col" data-price="100000">
            <div class="card__image">
               <img src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Salad" />
            </div>
            <div class="card__info">
               <div class="car__info--title">
                  <h3>سالاد</h3>
                  <p>تازه و خنک</p>
               </div>
               <div class="card__info--price">
                  <p>100000تومان</p>

               </div>
            </div>
         </div>
         <div class="card flex flex-col" data-price="200000">
            <div class="card__image">
               <img src="https://images.pexels.com/photos/840216/pexels-photo-840216.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Fish" />
            </div>
            <div class="card__info">
               <div class="car__info--title">
                  <h3>ماهی</h3>
                  <p>تازه و نرم</p>
               </div>
               <div class="card__info--price">
                  <p>200000 تومان</p>

               </div>
            </div>
         </div>
         <div class="card flex flex-col" data-price="300000">
            <div class="card__image">
               <img src="https://images.pexels.com/photos/4001871/pexels-photo-4001871.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" alt="Pizza" />
            </div>
            <div class="card__info">
               <div class="car__info--title">
                  <h3>پیتزا</h3>
                  <p>داغ و تازه</p>
               </div>
               <div class="card__info--price">
                  <p>300000 تومان</p>
               </div>
            </div>
         </div>
         <div class="card flex flex-col" data-price="400000">
            <div class="card__image">
               <img src="https://images.pexels.com/photos/792028/pexels-photo-792028.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Sushi" />
            </div>
            <div class="card__info">
               <div class="car__info--title">
                  <h3>سوشی</h3>
                  <p>تازه و نرم</p>
               </div>
               <div class="card__info--price">
                  <p>400000 تومان</p>
               </div>
            </div>
         </div>
         <div class="card flex flex-col" data-price="600000">
            <div class="card__image">
               <img src="https://images.pexels.com/photos/907142/pexels-photo-907142.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" alt="Dessert" />
            </div>
            <div class="card__info">
               <div class="car__info--title">
                  <h3>دسر</h3>
                  <p>تازه و شیرین</p>
               </div>
               <div class="card__info--price">
                  <p>600000 تومان</p>
               </div>
            </div>
         </div>
      </div>
</div>

<?php get_template_part('pages/infofoodmodal', name: 'single'); ?>