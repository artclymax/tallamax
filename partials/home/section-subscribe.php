<?php
$page = get_queried_object();

$title = get_field('section_subscribe_title', $page) ?? '';
$descr = get_field('section_subscribe_descr', $page) ?? '';
$form = get_field('section_subscribe_form', $page) ?? '';
$image = get_field('section_subscribe_image', $page) ?? null;
$socials = get_field('contacts_socials', 'option') ?? [];

if ($title || $descr || $form || ($image && !empty($image['ID'])) || !empty($socials)):
	?>
	<section class="section-full section-subscribe" id="section-subscribe">
		<div class="section-decor"></div>
		<div class="container section-subscribe__container">
			<div class="section-subscribe__wrapper" data-aos="fade-up">
				<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
					<div class="section-subscribe__image image-box">
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

				<div class="section-subscribe__content">
					<?php if ($title): ?>
						<h2 class="section-subscribe__title title-2"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>

					<?php if ($descr): ?>
						<div class="section-subscribe__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>

					<?php if ($form): ?>
						<div class="section-subscribe__form">
							<?php echo do_shortcode($form); ?>
						</div>
					<?php endif; ?>

					<?php if (!empty($socials)): ?>
						<ul class="section-subscribe__socials">
							<?php foreach ($socials as $social):
								$social_name = $social['link']['title'] ?? '';
								$social_url = $social['link']['url'] ?? '';
								$social_icon = $social['icon'] ?? null;

								if (!$social_url)
									continue;
								?>
								<li class="section-subscribe__social-item">
									<a class="section-subscribe__social-link" href="<?php echo esc_url($social_url); ?>">
										<?php if ($social_icon && is_array($social_icon) && !empty($social_icon['ID'])): ?>
											<span class="section-subscribe__social-icon">
												<?php echo wp_get_attachment_image(
													$social_icon['ID'],
													'medium',
													false,
													[
														'class' => 'img',
														'alt' => $social_icon['alt'] ?: $social_name,
														'loading' => 'lazy'
													]
												); ?>
											</span>
										<?php endif; ?>

										<?php if ($social_name): ?>
											<span class="section-subscribe__social-name"><?php echo esc_html($social_name); ?></span>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>