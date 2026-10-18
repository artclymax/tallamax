<?php
$page = $args['page'] ?? get_queried_object();

$title = get_field('cta_title', $page) ?: get_field('cta_title', 'option') ?? '';
$descr = get_field('cta_descr', $page) ?: get_field('cta_descr', 'option') ?? '';
$btn = get_field('cta_btn', $page) ?: get_field('cta_btn', 'option') ?? [];
$image = get_field('cta_image', $page) ?: get_field('cta_image', 'option') ?? null;

if ($title || $descr || (!empty($btn) && !empty($btn['url'])) || ($image && is_array($image) && !empty($image['ID']))):
	?>
	<section class="section-full cta-section" id="cta-section">
		<div class="container cta-section__container">

			<div class="cta-section__wrapper" data-aos="fade-up" data-aos-delay="100">
				<div class="cta-section__content">
					<?php if ($title): ?>
						<h2 class="cta-section__title title-2">
							<?php echo wp_kses_post($title); ?>
						</h2>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="cta-section__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($btn) && !empty($btn['url'])): ?>
						<a class="cta-section__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
					<?php echo esc_attr($btn['target']); ?>"
							<?php endif; ?>>
							<?php echo esc_html($btn['title']); ?>
						</a>
					<?php endif; ?>
				</div>

				<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
					<div class="cta-section__image image-box">
						<?php echo wp_get_attachment_image(
							$image['ID'],
							'large',
							false,
							[
								'class' => 'img',
								'alt' => $image['alt'] ?: $title,
								'loading' => 'lazy'
							]
						); ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>
<?php endif; ?>