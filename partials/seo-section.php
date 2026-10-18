<?php

$page = $args['page'] ?? get_queried_object();

$title = get_field('seo_title', $page) ?? '';
$descr = apply_filters('the_content', get_the_content()) ?: get_field('seo_descr', $page) ?? '';
// Защитная обёртка
if ($title || $descr):
	?>
	<section class="section-full seo-section" id="seo-section" data-aos="fade-up" data-aos-delay="100">
		<div class="container seo-section__container">

			<?php if ($title): ?>
				<h2 class="seo-section__title title-2">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>

			<?php if ($descr): ?>
				<div class="seo-section__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>