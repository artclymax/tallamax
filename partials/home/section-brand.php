<?php
$page = get_queried_object();

$title = get_field('section_brand_title', $page) ?? '';
$descr = get_field('section_brand_descr', $page) ?? '';
$btn = get_field('section_brand_btn', $page) ?? [];
$image = get_field('section_brand_image', $page) ?? null;
$features = get_field('section_brand_features', $page) ?? [];

if ($title || $descr || ($image && !empty($image['ID'])) || !empty($features) || (!empty($btn) && !empty($btn['url']))):
	?>
	<section class="section-full section-brand" id="section-brand">
		<div class="container section-brand__container">
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="section-brand__image image-box" data-aos="fade-up">
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

			<div class="section-brand__content" data-aos="fade-up" data-aos-delay="100">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'descr' => $descr,
				]); ?>

				<?php if (!empty($features)): ?>
					<ul class="section-brand__features">
						<?php foreach ($features as $feature):
							$feature_icon = $feature['icon'] ?? null;
							$feature_title = $feature['title'] ?? '';
							$feature_descr = $feature['descr'] ?? '';

							if (!$feature_title && !$feature_descr)
								continue;
							?>
							<li class="section-brand__feature section-brand-feature">
								<?php if ($feature_icon && is_array($feature_icon) && !empty($feature_icon['ID'])): ?>
									<div class="section-brand-feature__icon">
										<?php echo wp_get_attachment_image(
											$feature_icon['ID'],
											'medium',
											false,
											[
												'class' => 'img',
												'alt' => $feature_icon['alt'] ?: $feature_title,
												'loading' => 'lazy'
											]
										); ?>
									</div>
								<?php endif; ?>

								<div class="section-brand-feature__info">
									<?php if ($feature_title): ?>
										<h3 class="section-brand-feature__title title-4">
											<?php echo esc_html($feature_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($feature_descr): ?>
										<div class="section-brand-feature__descr descr">
											<?php echo wp_kses_post($feature_descr); ?>
										</div>
									<?php endif; ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if (!empty($btn) && !empty($btn['url'])): ?>
					<a class="section-brand__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>