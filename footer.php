<?php get_template_part('components/endfooter', name: 'single'); ?>

</div>

<div class="footer max-w-[650px] relative">
    <div class="absolute bottom-0 z-[50] w-full">
    <div class="navigation">
  <ul>
    <li class="list active">
      <a id="tab-home" href="#"  class="tab-button">
        <span class="icon">
     
          <ion-icon name="restaurant-outline"></ion-icon>
          
        </span>
        <span class="text">منو</span>
      </a>
    </li>
    <li class="list">
      <a id="tab-game"  href="#" class="tab-button">
        <span class="icon">
          <ion-icon name="game-controller-outline"></ion-icon>
        </span>
        <span class="text">بازی</span>
      </a>
    </li>
    <li class="list">
      <a id="tab-cart" href="#" class="tab-button">
        <span class="icon">
          <ion-icon name="cart-outline"></ion-icon>
        </span>
        <span class="text">سفارشات</span>
      </a>
    </li>

    <li class="list">
      <a id="tab-garson" href="#" class="tab-button">
        <span class="icon">
        <img width="24" height="24" src="https://img.icons8.com/?size=100&id=XLIocFCXawoN&format=png&color=ffffff" alt="waiter"/>
       
        </span>
        <span class="text">گارسون</span>
      </a>
    </li>
 
     <li class="list">
      <a id="tab-info" href="#" class="tab-button">
        <span class="icon">
          <ion-icon name="call-outline"></ion-icon>
        </span>
        <span class="text">ارتباط</span>
      </a>
    </li>
    <div class="indicator"></div>
  </ul>
</div>
<?php get_template_part('components/garsonmodal', 'single'); ?>
   
    </div>
</div>


<!-- اسکریپت jQuery برای مدیریت تب‌ها -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<?php wp_footer(); ?>
</body>
</html>
