<?php
/*
Template Name: Доставка и оплата
*/
get_header();

get_template_part('partials/components/hero-page');
get_template_part('partials/payment-delivery/delivery-features');
get_template_part('partials/payment-delivery/delivery-countries');
get_template_part('partials/payment-delivery/delivery-info');
get_template_part('partials/section-faq', null, ['class' => 'delivery-faq']);
get_template_part('partials/cta-section-socials');
get_template_part('partials/section-image');

get_footer();

?>