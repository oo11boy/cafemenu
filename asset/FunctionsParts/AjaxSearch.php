<?php 

// تابع Ajax برای جستجوی غذاها
function ajax_search_food_items()
{
    if (isset($_POST['query'])) {
        $query = sanitize_text_field($_POST['query']);
        $args = array(
            'post_type' => 'food_item',
            's' => $query,
            'posts_per_page' => 5, // Limit the results to 5
        );
        $search_query = new WP_Query($args);
        if ($search_query->have_posts()) {
            ?>
            <div class="card-container  ">
                <div class="art-board__container gap-4 viewfood yekan">
                    <?php
                    while ($search_query->have_posts()) {
                        $search_query->the_post();

                        $food_title = get_the_title();
                        $food_description = get_the_content();
                        $food_image = get_the_post_thumbnail_url();
                        $food_price = get_post_meta(get_the_ID(), 'food_price', true);
                        // گرفتن دسته‌بندی‌های غذا
                        $food_categories = wp_get_post_terms(get_the_ID(), 'food_category');
                        $category_ids = wp_list_pluck($food_categories, 'term_id'); ?>



                        <div data-price="<?php echo esc_html($food_price); ?>"
                            data-categories="<?php echo implode(' ', $category_ids); ?>" style="
    width: 100%;
    border: 1px solid #E8E8E8;
    height: 80px;
" class="flex card rounded-lg  items-center cursor-pointer z-[920] shadow">

                            <div class="card__image w-[100px]">
                                <img class="h-[full] w-full" src="<?php echo esc_url($food_image); ?>"
                                    alt="<?php echo esc_attr($food_title); ?>" />
                            </div>


                            <div  class="card__info" style="
    display: flex;
    flex-direction: column;
    align-items: unset;
    height: 100%;
    justify-content: space-between;
    padding-right: 10px;
">
   
                                <div class="card__info--title">
                                    <h3><?php echo esc_html($food_title); ?></h3>
                                    <p><?php echo esc_html(mb_substr($food_description, 0, 20, 'UTF-8')); ?>...</p>
                                    <!-- فقط 10 حرف اول -->

                                </div>

                                <div class="card__info--price">
                                    <p><?php echo esc_html($food_price); ?> تومان</p>
                                </div>
                            </div>
                        </div>


                        <script src="<?php echo get_template_directory_uri(); ?>/asset/javascript/openfoodmodal.js"></script>

                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            wp_reset_postdata();
        } else {
            echo '<p>نتیجه‌ای یافت نشد</p>';
        }
    }
    wp_die();
}

add_action('wp_ajax_nopriv_ajax_search_food_items', 'ajax_search_food_items');
add_action('wp_ajax_ajax_search_food_items', 'ajax_search_food_items');
