<?php
$page = 'options';

$label = get_field('page_404_subtitle', $page) ?? get_the_title();
$title = get_field('page_404_title', $page) ?? get_the_title();
$descr = get_field('page_404_descr', $page) ?? '';
$btn = get_field('page_404_btn', $page) ?? '';
$btn_second = get_field('page_404_btn_second', $page) ?? '';
$image = get_field('page_404_image', $page) ?? '';


$has_content = ($title || $descr || (!empty($btn) && !empty($btn['url'])));

if ($has_content || $image):
	?>
	<section class="section hero-page hero-404 jarallax" id="hero-404">
		<div class="hero-page__overlay"></div>
		<div class="container hero-page__container">
			<div class="hero-page__content" data-aos="fade-up">
				<!-- Label -->
				<?php if ($label): ?>
					<div class="hero-page__label eyebrow">
						<?php echo esc_html($label); ?>
					</div>
				<?php endif; ?>

				<!-- Title -->
				<h1 class="hero-page__title title-1 descr">
					<?php echo wp_kses_post($title); ?>
				</h1>

				<!-- Description -->
				<?php if ($descr): ?>
					<div class="hero-page__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($btn) || !empty($btn_second)): ?>
					<div class="hero-page__btn-box" data-aos="fade-up" data-aos-delay="100">
						<?php if (!empty($btn) && !empty($btn['url'])): ?>
							<a class="btn hero-page__btn btn" href="<?php echo esc_url($btn['url']); ?>">
								<?php echo esc_html($btn['title']); ?>
							</a>
						<?php endif; ?>
						<?php if (!empty($btn_second) && !empty($btn_second['url'])): ?>
							<a class="btn hero-page__btn btn btn--stroke" href="<?php echo esc_url($btn_second['url']); ?>">
								<?php echo esc_html($btn_second['title']); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Image -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="hero-page__image image-box jarallax-img">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'full',
						false,
						[
							'class' => 'img jarallax-img',
							'alt' => $image['alt'] ?: $title,
						]
					); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>