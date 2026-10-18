<?php
/**
 * Section: Что дальше?
 * Отображает этапы обработки заказа
 */

// ACF Fields
$section_title = get_field('whats_next_section_title') ?? 'Что дальше?';
$steps = get_field('whats_next_steps') ?? [];


?>

<section class="section-whats-next" id="section-whats-next">
	<div class="container section-whats-next__container section-gap">

		<?php if (!empty($section_title)): ?>
			<h2 class="section-whats-next__title title-2 descr">
				<?php echo esc_html($section_title); ?>
			</h2>
		<?php endif; ?>

		<?php if (!empty($steps)): ?>
			<ul class="section-whats-next__list grid">
				<?php foreach ($steps as $index => $step): ?>
					<li class="section-whats-next__item whats-next-step" data-aos="fade-up"
						data-aos-delay="<?php echo $index * 100; ?>">
						<div class="whats-next-step__icon">
							<?php echo wp_get_attachment_image(
								$step['icon']['ID'],
								'large',
								false,
								array(
									'class' => 'img',
									'alt' => $step['icon']['alt'] ?: ''
								)
							); ?>
						</div>
						<div class="whats-next-step__content">
							<?php if (!empty($step['step_title'])): ?>
								<h3 class="whats-next-step__title title-4">
									<?php echo esc_html($step['step_title']); ?>
								</h3>
							<?php endif; ?>

							<?php if (!empty($step['step_descr'])): ?>
								<div class="whats-next-step__descr descr">
									<?php echo wp_kses_post($step['step_descr']); ?>
								</div>
							<?php endif; ?>
						</div>
					</li>

				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>
</section>