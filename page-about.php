<?php
/*
Template Name: О бренде
*/
get_header();

get_template_part('partials/components/hero-page');
get_template_part('partials/about/section-about');
get_template_part('partials/about/section-origin');
get_template_part('partials/section-image');
get_template_part('partials/about/section-key-ingredient');
get_template_part('partials/ritual-steps', null, ['class' => 'about-ritual-steps']);
get_template_part('partials/about/about-mushrooms');
get_template_part('partials/about/section-our-values');
get_template_part('partials/cta-section');

get_footer();

?>