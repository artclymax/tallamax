<?php
$page = get_queried_object();

$title = get_field('section_about_title', $page) ?? '';
$descr = get_field('section_about_descr', $page) ?? '';
$quote = get_field('section_about_quote', $page) ?? '';
$image = get_field('section_about_image', $page) ?? null;
$values = get_field('section_about_values', $page) ?? [];

if ($title || $descr || $quote || ($image && !empty($image['ID'])) || !empty($values)):
	?>
	<section class="section-full section-about" id="section-about">
		<div class="container section-about__container">
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="section-about__image image-box" data-aos="fade-up" data-aos-delay="100">
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

			<div class="section-about__content" data-aos="fade-up">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'descr' => $descr,
				]); ?>

				<?php if ($quote): ?>
					<blockquote class="section-about__quote descr icon icon--quotes">
						<?php echo wp_kses_post($quote); ?>
					</blockquote>
				<?php endif; ?>

				<?php if (!empty($values)): ?>
					<ul class="section-about__values">
						<?php foreach ($values as $value):
							$value_icon = $value['icon'] ?? null;
							$value_title = $value['title'] ?? '';
							$value_descr = $value['descr'] ?? '';

							if (!$value_title && !$value_descr)
								continue;
							?>
							<li class="section-about__value section-about-value">
								<?php if ($value_icon && is_array($value_icon) && !empty($value_icon['ID'])): ?>
									<div class="section-about-value__icon">
										<?php echo wp_get_attachment_image(
											$value_icon['ID'],
											'medium',
											false,
											[
												'class' => 'img',
												'alt' => $value_icon['alt'] ?: $value_title,
												'loading' => 'lazy'
											]
										); ?>
									</div>
								<?php endif; ?>

								<?php if ($value_title): ?>
									<h3 class="section-about-value__title title-4">
										<?php echo esc_html($value_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($value_descr): ?>
									<div class="section-about-value__descr descr">
										<?php echo wp_kses_post($value_descr); ?>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>