<?php
$socials_all = get_field('contacts_socials', 'option') ?? [];
$socials = array_values(array_filter($socials_all, function ($social) {
	return !empty($social['show']) && !empty($social['link']['url']);
}));

$phones = get_field('contacts_phones', 'option') ?? [];
$emails = get_field('contacts_emails', 'option') ?? [];

$email_icon = get_field('contacts_email_icon', 'option') ?? null;
$email_descr = get_field('contacts_email_descr', 'option') ?? '';

$phone_icon = get_field('contacts_phone_icon', 'option') ?? null;
$phone_descr = get_field('contacts_phone_descr', 'option') ?? '';

if (!empty($socials) || !empty($phones) || !empty($emails)):
	?>
	<section class="section section-contacts" id="section-contacts">
		<div class="container section-contacts__container">
			<ul class="section-contacts__list grid">
				<?php if (!empty($socials)): ?>
					<?php foreach ($socials as $index =>$social):
						$social_icon = $social['icon'] ?? null;
						$social_link = $social['link'] ?? [];
						$social_title = $social['title'] ?? '';
						$social_descr = $social['descr'] ?? '';
						?>
						<li class="section-contacts__item contacts-card contacts-card--social card-box" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
							<?php if ($social_icon && is_array($social_icon) && !empty($social_icon['ID'])): ?>
								<div class="contacts-card__icon">
									<?php echo wp_get_attachment_image(
										$social_icon['ID'],
										'medium',
										false,
										[
											'class' => 'img',
											'alt' => $social_icon['alt'] ?: $social_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<div class="contacts-card__content">
								<?php if ($social_title): ?>
									<h3 class="contacts-card__title title-4">
										<?php echo esc_html($social_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($social_descr): ?>
									<div class="contacts-card__descr descr">
										<?php echo wp_kses_post($social_descr); ?>
									</div>
								<?php endif; ?>

								<a class="contacts-card__btn btn btn--stroke btn--arrow"
									href="<?php echo esc_url($social_link['url']); ?>" <?php if (!empty($social_link['target'])): ?>target="<?php echo esc_attr($social_link['target']); ?>" <?php endif; ?>>
									<?php echo esc_html($social_link['title']); ?>
								</a>
							</div>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>

				<?php if (!empty($emails)): ?>
					<li class="section-contacts__item contacts-card contacts-card--email card-box" data-aos="fade-up" data-aos-delay="300">
						<?php if ($email_icon && is_array($email_icon) && !empty($email_icon['ID'])): ?>
							<div class="contacts-card__icon">
								<?php echo wp_get_attachment_image(
									$email_icon['ID'],
									'medium',
									false,
									[
										'class' => 'img',
										'alt' => $email_icon['alt'] ?: 'Email',
										'loading' => 'lazy'
									]
								); ?>
							</div>
						<?php endif; ?>

						<div class="contacts-card__content">
							<h3 class="contacts-card__title title-4">Email</h3>

							<?php if ($email_descr): ?>
								<div class="contacts-card__descr descr">
									<?php echo wp_kses_post($email_descr); ?>
								</div>
							<?php endif; ?>

							<ul class="contacts-card__links">
								<?php foreach ($emails as $email):
									$email_value = $email['email'] ?? '';
									if (!$email_value)
										continue;
									?>
									<li>
										<a class="contacts-card__link link" href="mailto:<?php echo esc_attr($email_value); ?>">
											<?php echo esc_html($email_value); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</li>
				<?php endif; ?>

				<?php if (!empty($phones)): ?>
					<li class="section-contacts__item contacts-card contacts-card--phone card-box" data-aos="fade-up" data-aos-delay="400">
						<?php if ($phone_icon && is_array($phone_icon) && !empty($phone_icon['ID'])): ?>
							<div class="contacts-card__icon">
								<?php echo wp_get_attachment_image(
									$phone_icon['ID'],
									'medium',
									false,
									[
										'class' => 'img',
										'alt' => $phone_icon['alt'] ?: 'Телефон',
										'loading' => 'lazy'
									]
								); ?>
							</div>
						<?php endif; ?>

						<div class="contacts-card__content">
							<h3 class="contacts-card__title title-4">Телефон</h3>

							<?php if ($phone_descr): ?>
								<div class="contacts-card__descr descr">
									<?php echo wp_kses_post($phone_descr); ?>
								</div>
							<?php endif; ?>

							<ul class="contacts-card__links">
								<?php foreach ($phones as $phone):
									$phone_value = $phone['phone'] ?? '';
									if (!$phone_value)
										continue;

									$phone_clean = preg_replace('/[^0-9+]/', '', $phone_value);
									?>
									<li>
										<a class="contacts-card__link link" href="tel:<?php echo esc_attr($phone_clean); ?>">
											<?php echo esc_html($phone_value); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>