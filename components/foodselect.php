<div
   class="flex iransans gap-y-4 rounded-lg bg-[#4CAF50] z-10 shadow-lg  z-20 mt-5 items-center p-3 flex-row justify-between w-full">
   <input class="pricerange" style="accent-color: #1a543b" type="range" id="rangeInput" min="100000" step="100000"
      max="1000000" value="1000000" oninput="updateValue(this.value)" />
   <div class="w-1/2 text-sm sm:text-sm text-left  text-white">
      زیر <span id="rangeValue" class="text-[10px] sm:text-sm">1000000</span> تومان
   </div>
</div>

<!-- دکمه "نمایش همه آیتم‌ها" -->
<div class="w-full custom-scroll vazir p-4 shadow-lg overflow-x-auto sticky top-0 bg-white z-10">
   <div class="flex gap-4">
      <!-- دکمه "نمایش همه ایتم‌ها" -->
      <button class="category-btn" data-category-id="all">
         <div class="min-w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
            <div class="bg-[#e3e3e3] w-[90px] h-[90px] flex justify-center items-center p-4 rounded-xl category-img">
               <img class="w-[100%] object-cover " src="<?php echo get_theme_image_url('all.png'); ?>" alt="نمایش همه">
            </div>
            <p class="text-black"> همه</p>
         </div>
      </button>
      <?php
      // دریافت دسته‌بندی‌های غذا
      $categories = get_terms(array(
         'taxonomy' => 'food_category',
         'hide_empty' => false,
      ));

      if (!empty($categories) && !is_wp_error($categories)):
         foreach ($categories as $category):
            $image_id = get_term_meta($category->term_id, 'category_image', true);
            $image_url = ($image_id) ? wp_get_attachment_url($image_id) : get_theme_image_url('default-image.jpg');

            // دریافت آیکون دسته‌بندی
            $icon_value = get_term_meta($category->term_id, 'category_icon', true);
            $icon_url = '';

            // لیست آیکون‌ها (باید در اینجا آیکون‌های خود را مشخص کنید)
            $icons = get_food_category_icons(); // دریافت لیست آیکون‌ها

            // اگر آیکونی برای دسته‌بندی موجود باشد، آن را دریافت کن
            if (isset($icons[$icon_value])) {
               $icon_url = get_theme_image_url($icons[$icon_value]);
            }
            ?>
            <button class="category-btn" data-category-id="<?php echo esc_attr($category->term_id); ?>">
               <div class="min-w-[100px] w-[100px] text-white whitespace-nowrap flex flex-col justify-center items-center">
                  <div class="bg-[#e3e3e3]  w-[90px] h-[90px] flex justify-center items-center p-4 rounded-xl category-img">
                  <?php if ($icon_url) { ?>
                        <img class="w-full h-full object-cover" src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($category->name); ?>"
                         >
                     <?php } else {
                        ?>
                        <img class="w-full h-full object-cover" src="<?php echo esc_url($image_url); ?>"
                           alt="<?php echo esc_attr($category->name); ?>">
                     <?php }
                     ?>
                  </div>
                
                  <p class="text-black"><?php echo esc_html($category->name); ?></p>
               </div>
            </button>
         <?php endforeach; else: ?>
         <p>هیچ دسته‌بندی یافت نشد.</p>
      <?php endif; ?>

   </div>
</div>


<div class="card-container">
   <div class="art-board__container cursor-pointer gap-y-4 viewfood yekan">
      <?php
      // کوئری برای دریافت پست‌های نوع food_item
      $food_items_query = new WP_Query(array(
         'post_type' => 'food_item',
         'posts_per_page' => -1
      ));

      if ($food_items_query->have_posts()):
         while ($food_items_query->have_posts()):
            $food_items_query->the_post();
            $food_title = get_the_title();
            $food_description = get_the_content();
            $food_image = get_the_post_thumbnail_url();
            $food_price = get_post_meta(get_the_ID(), 'food_price', true);
            // گرفتن دسته‌بندی‌های غذا
            $food_categories = wp_get_post_terms(get_the_ID(), 'food_category');
            $category_ids = wp_list_pluck($food_categories, 'term_id');
            ?>
            <div class="card flex shadow flex-col" data-price="<?php echo esc_html($food_price); ?>"
               data-categories="<?php echo implode(' ', $category_ids); ?>">
               <div class="card__image">
                  <img src="<?php echo esc_url($food_image); ?>" alt="<?php echo esc_attr($food_title); ?>" />
               </div>
               <div class="card__info">
                  <div class="car__info--title">
                     <h3><?php echo esc_html($food_title); ?></h3>
                     <p><?php echo esc_html(mb_substr($food_description, 0, 10, 'UTF-8')); ?>...</p> <!-- فقط 10 حرف اول -->
                     <span class="hidden">
                        <?php echo esc_html($food_description) ?>
                     </span>
                  </div>
                  <div class="card__info--price">
                     <p><?php echo esc_html($food_price); ?> تومان</p>
                  </div>
               </div>
            </div>
            <?php
         endwhile;
         wp_reset_postdata();
      else:
         echo '<p>آیتمی یافت نشد</p>';
      endif;
      ?>
   </div>
</div>



<?php get_template_part('pages/infofoodmodal', name: 'single'); ?>