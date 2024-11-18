<?php
/*
Template Name: mainpage
*/
get_header();
?>

<?php get_template_part('components/header', 'single'); ?>

<!-- home tab -->
<div id="content-home" class="tab-content">

    <?php get_template_part('pages/Homepage', 'single'); ?>
</div>


<!-- game tab -->
<div id="content-game" class="tab-content">
    <?php get_template_part('pages/games', 'single'); ?>
</div>


<!-- information tab -->

<div id="content-info" class="tab-content">
    <?php get_template_part('pages/aboutus', 'single'); ?>
</div>



<!-- test tab -->

<div id="content-cart" class="tab-content">
<?php get_template_part('pages/shopcart', 'single'); ?>
</div>

<?php get_footer(); ?>