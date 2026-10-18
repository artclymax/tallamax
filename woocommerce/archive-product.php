<?php
defined('ABSPATH') || exit;

get_header();
get_template_part('partials/components/hero-page', null, ['page' => 'shop']);
get_template_part('partials/shop/shop-page');
get_template_part('partials/section-image');
get_template_part('partials/ritual-steps');
get_template_part('partials/cta-section');
get_template_part('partials/seo-section', null, ['page' => get_page_by_path('shop')]);
get_footer();
