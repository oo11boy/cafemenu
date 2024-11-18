<section class="special-offers">
    <h2 class="section-title reyhaneh text-2xl mb-10">پیشنهادهای ویژه</h2>
    <div class="card-container-offer yekan">
        <?php
        $args = array(
            'post_type' => 'food_item',
            'meta_key' => 'special_offer',
            'meta_value' => '1', // فقط آیتم‌های ویژه
            'posts_per_page' => -1, // نمایش همه پیشنهادهای ویژه
        );

        $special_offers_query = new WP_Query($args);

        if ($special_offers_query->have_posts()) :
            while ($special_offers_query->have_posts()) : $special_offers_query->the_post();
                $price = get_post_meta(get_the_ID(), 'food_price', true);
                ?>
                <div class="recipe-card-1">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="recipe-card-image" />
                    <?php endif; ?>
                    <div class="recipe-details-container">
                        <div class="recipe-info">
                            <h3><?php the_title(); ?></h3>
                            <div class="recipe-ratings">
                                <!-- Add SVG Stars here if needed -->
                            </div>
                            <div class="recipe-overview">
                                <div class="recipe-time"><?php echo esc_html(get_post_meta(get_the_ID(), 'food_time', true)); ?> دقیقه</div>
                                <div class="recipe-serve"><?php echo esc_html(get_post_meta(get_the_ID(), 'food_serve', true)); ?> نفر</div>
                                <div class="recipe-price"><?php echo esc_html($price); ?> تومان</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>هیچ پیشنهاد ویژه‌ای یافت نشد.</p>';
        endif;
        ?>
    </div>
</section>

<?php get_template_part('pages/infofoodmodal', name: 'single'); ?>

