<?php
$page_id = get_the_ID();

$section_title = get_field('products_title', $page_id) ?? 'Средства для ежедневного ухода';
$all_btn = get_field('products_all_btn', $page_id) ?? null;
$products_per_page = get_field('products_per_page', $page_id) ?? 8;
$section_decor = get_field('products_section_decor', $page_id) ?? false;

$exclude_term = get_term_by('slug', 'misc', 'product_cat');
$exclude_ids = $exclude_term ? [$exclude_term->term_id] : [];

$categories = get_terms([
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'parent' => 0,
	'exclude' => $exclude_ids,
]);

$products_args = [
	'post_type' => 'product',
	'posts_per_page' => $products_per_page,
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
];

$products_query = new WP_Query($products_args);
?>
<section class="section-full section-products" id="section-products">
	<?php if (!empty($section_decor)): ?>
		<div class="section-decor" aria-hidden="true">
			<?php echo wp_get_attachment_image(
				$section_decor['ID'],
				'large',
				false,
				array(
					'class' => 'img',
					'alt' => $section_decor['alt'] ?: ''
				)
			); ?>
		</div>
	<?php endif; ?>
	<div class="container section-products__container section-gap">
		<div class="section-products__header">
			<?php if ($section_title): ?>
				<h2 class="section-products__title title-2 descr" data-aos="fade-up">
					<?php echo wp_kses_post($section_title); ?>
				</h2>
			<?php endif; ?>
			<ul class="section-products__btn-list" data-aos="fade-up" data-aos-delay="100">
				<li class="section-products__btn-item">
					<a class="section-products__btn btn btn--stroke" href="<?php echo esc_url(home_url('/shop/')); ?>">
						Все средства
					</a>
				</li>
				<?php if (!empty($categories)): ?>
					<?php foreach ($categories as $index => $cat): ?>
						<li class="section-products__btn-item">
							<a class="section-products__btn link" href="<?php echo esc_url(get_term_link($cat)); ?>">
								<?php echo esc_html($cat->name); ?>
							</a>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>
		<?php if ($products_query->have_posts()): ?>
			<div class="section-products__slider swiper-slider" data-aos="fade-up">
				<div class="swiper products-swiper"
					data-swiper='{ "slidesPerView": 2, "spaceBetween": 8, "rewind": true, "breakpoints": { "640": { "slidesPerView": 2.2, "spaceBetween": 16 }, "1024": { "slidesPerView": 3.5, "spaceBetween": 16 }, "1280": { "slidesPerView": 4, "spaceBetween": 24 } } }'>
					<div class="swiper-wrapper products-swiper__wrapper">
						<?php while ($products_query->have_posts()):
							$products_query->the_post();
							$index = 1;
							?>
							<div class="swiper-slide products-slide">
								<?php get_template_part('woocommerce/content-product'); ?>
							</div>
							<?php
							++$index;
						endwhile;
						wp_reset_postdata(); ?>
					</div>
				</div>
				<div class="swiper-pagination swiper-slider__pagination visible-mobile"
					data-swiper-pagination=".products-swiper"></div>
				<button class="swiper-btn swiper-btn__prev swiper-slider__btn swiper-slider__btn-prev hidden-mobile"
					type="button" aria-label="Назад" data-swiper-btn-prev=".products-swiper"></button>
				<button class="swiper-btn swiper-btn__next swiper-slider__btn swiper-slider__btn-next hidden-mobile"
					type="button" aria-label="Вперёд" data-swiper-btn-next=".products-swiper"></button>
			</div>
		<?php else: ?>
			<div class="section-products__no-products">
				<p>Товары в этой категории пока не добавлены.</p>
			</div>
		<?php endif; ?>
	</div>
</section>