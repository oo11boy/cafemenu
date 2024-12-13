<div class="w-full">
    <div class="chef-suggestion-title-container">
        <hr class="chef-suggestion-title-line">
        <span class="chef-suggestion-title-text reyhaneh text-2xl absolute top-0">شعب دیگر</span>
    </div>

    <div class="yekan overflow-auto custom-scroll py-2 w-full">
        <div class="inline-flex gap-x-2">
            <?php
            // WP_Query برای دریافت شعبه‌ها
            $args = array(
                'post_type' => 'branches',
                'posts_per_page' => -1 // تعداد شعبه‌ها را نامحدود دریافت کن
            );
            $branch_query = new WP_Query($args);

            if ($branch_query->have_posts()):
                while ($branch_query->have_posts()):
                    $branch_query->the_post();
                    // دریافت اطلاعات متاباکس‌ها
                    $branch_name = get_post_meta(get_the_ID(), '_branch_name', true);
                    $branch_image = get_post_meta(get_the_ID(), '_branch_image', true);
                    $branch_instagram = get_post_meta(get_the_ID(), '_branch_instagram', true);
                    $branch_phone = get_post_meta(get_the_ID(), '_branch_phone', true);
                    $branch_address = get_post_meta(get_the_ID(), '_branch_address', true);
                    $branch_id = get_the_ID(); // ID برای شناسایی شعبه
                    ?>
                    <div class="h-[150px] w-[150px] rounded-lg relative cursor-pointer"
                        onclick="openBranchModal('<?php echo $branch_id; ?>')">
                        <img class="w-full h-full object-cover rounded-lg" src="<?php echo esc_url($branch_image); ?>"
                            alt="<?php echo esc_attr($branch_name); ?>">
                        <div class="absolute inset-0 bg-black opacity-25 rounded-lg"></div> <!-- تیره کردن تصویر -->
                        <p class="absolute text-xl text-white left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <?php echo esc_html($branch_name); ?>
                        </p>
                    </div>

                    <!-- مودال مربوط به شعبه -->
                    <div id="modal-<?php echo $branch_id; ?>"
                        class="branch-modal  hidden fixed inset-0 bg-black bg-opacity-50 flex max-w-[550px] m-auto items-center justify-center z-50">
                        <div class="w-full overflow-auto pb-[25%] bg-white relative h-full p-3 yekan">
                            <button
                                class="absolute top-4  right-4 text-6xl text-[white] bg-[#1F9D7E] rounded-xl w-[50px] h-[50px] z-[999] transition-all"
                                onclick="closeBranchModal('<?php echo $branch_id; ?>')">&times;</button>

                            <div class="relative w-full h-[200px]">
                                <!-- نمایش تصویر کافه از تنظیمات -->
                                <img class="w-full h-full object-cover rounded-xl" src="<?php echo esc_url($branch_image); ?>"
                                    alt="کافه تصویر">
                                <!-- لوگوی کافه از تنظیمات -->
                                <img class="rounded-full imglogoinfo absolute -bottom-[25%] border-2 border-white right-[40%] w-[100px] h-[100px] object-cover"
                                    src="<?php echo esc_url(get_option('cafe_logo')); ?>" alt="لوگوی کافه">
                            </div>
                            <!-- نام کافه به زبان فارسی -->
                            <h3 class="mt-12 text-center yekan text-2xl w-full"><?php echo esc_html(get_option('cafe_name')); ?>
                            </h3>
                            <!-- نام کافه به زبان انگلیسی -->
                            <h3 class="text-center yekan text-xl w-full"><?php echo esc_html($branch_name); ?></h3>
                            <div class="flex informationpage flex-wrap mt-4 justify-between w-full">
                                <!-- نمایش شماره تماس -->
                                <a href="tel:<?php echo esc_html($branch_phone); ?>"
                                    class="w-[49%] rounded-xl text-center bg-[#1f9d7e] text-[white] p-4 text-lg">
                                    <i class="fa fa-phone text-2xl mb-2" aria-hidden="true"></i>
                                    <div>ارتباط با ما</div>
                                </a>
                                <!-- نمایش لینک اینستاگرام -->
                                <a href="<?php echo esc_html($branch_instagram); ?>"
                                    class="w-[49%] rounded-xl text-center bg-[#1f9d7e] text-[white] p-4 text-lg">
                                    <i class="fa fa-camera-retro text-2xl mb-2"></i>
                                    <div>اینستاگرام</div>
                                </a>
                            </div>

                            <div
                                class="mt-4 mapaddress bg-[#1f9d7e] w-full items-center rounded-xl text-white flex justify-between p-4">
                                <!-- آدرس کافه -->
                                <p class="text-sm"><?php echo esc_html($branch_address); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>هیچ شعبه‌ای یافت نشد</p>';
            endif;
            ?>
        </div>
    </div>
</div>