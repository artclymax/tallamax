<?php
$page = $args['page'] ?? get_queried_object();
$class = $args['class'] ?? '';
$title = get_field('ritual_title', $page) ?: get_field('ritual_title', 'option') ?? '';
$descr = get_field('ritual_descr', $page) ?: get_field('ritual_descr', 'option') ?? '';
$steps = get_field('ritual_steps', $page) ?: get_field('ritual_steps', 'option') ?? [];

if ($title || !empty($steps)):
	?>
	<section class="ritual-steps <?= esc_attr($class); ?>" id="ritual-steps">
		<div class="container ritual-steps__container section-gap" data-aos="fade-up">

			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr,
			]); ?>

			<!-- Grid карточек -->
			<?php if (!empty($steps)): ?>
				<ul class="ritual-steps__list grid">
					<?php foreach ($steps as $index => $step):
						$step_title = $step['title'] ?? '';
						$step_descr = $step['descr'] ?? '';
						$step_image = $step['image'] ?? null;

						if (!$step_title && !$step_descr)
							continue;

						$number = ($index + 1) > 9 ? ($index + 1) : '0' . ($index + 1);
						?>
						<li class="ritual-steps__card ritual-steps-card card-box" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
							<div class="ritual-steps-card__content">
								<div class="ritual-steps-card__number title-3">
									<?php echo esc_html($number); ?>
								</div>

								<?php if ($step_title): ?>
									<h3 class="ritual-steps-card__title title-3">
										<?php echo esc_html($step_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($step_descr): ?>
									<div class="ritual-steps-card__descr descr">
										<?php echo wp_kses_post($step_descr); ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ($step_image && is_array($step_image) && !empty($step_image['ID'])): ?>
								<div class="ritual-steps-card__image image-box">
									<?php echo wp_get_attachment_image(
										$step_image['ID'],
										'full',
										false,
										[
											'class' => 'img',
											'alt' => $step_image['alt'] ?: $step_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>