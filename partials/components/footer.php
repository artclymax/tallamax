<?php

$page = 'options';
$logo = get_field('footer_logo', $page) ?? '';
$descr = get_field('footer_descr', $page) ?: get_bloginfo('description') ?? '';
$copy = get_field('footer_copy', $page) ?? '';
$company = get_field('footer_company', $page) ?: get_bloginfo('name') ?? '';
$links = get_field('footer_links', $page) ?? [];

$socials = get_field('contacts_socials', $page) ?? [];
$emails = get_field('contacts_emails', $page) ?? [];
$phones = get_field('contacts_phones', $page) ?? [];

$decor_icon = get_template_directory_uri() . '/assets/images/decor-icon.webp';
?>
<footer class="footer" id="footer" style="--decor-icon: url('<?= esc_url($decor_icon) ?>')" >
	<span class="footer__icon"></span>
	<div class="footer__container container">

		<!-- TOP: 4 колонки -->
		<div class="footer__top" data-aos="fade-up">

			<!-- INFO -->
			<div class="footer__info">
				<div class="footer__logo logo">
					<?php mx_logo('', $logo); ?>
				</div>
				<?php if ($descr): ?>
					<div class="footer__descr descr eyebrow">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- MENU -->
			<nav class="footer__menu footer-col">
				<h3 class="footer-col__title title-3">Навигация</h3>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu',
					'container' => false,
					'menu_class' => 'footer-menu',
					'depth' => 1,
					'fallback_cb' => false,
				]);
				?>
			</nav>

			<nav class="footer__menu footer-col">
				<h3 class="footer-col__title title-3">Покупателям</h3>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer-menu-2',
					'container' => false,
					'menu_class' => 'footer-menu',
					'depth' => 1,
					'fallback_cb' => false,
				]);
				?>
			</nav>

			<!-- CONTACTS -->
			<div class="footer__menu footer-col">
				<h3 class="footer-col__title title-3">Связаться с нами</h3>
				<ul class="footer-col__contacts footer-contacts">
					<!-- socials -->
					<?php if (!empty($socials)): ?>
						<?php foreach ($socials as $soc): ?>
							<li class="footer-contacts__item footer-contacts-socials">
								<a class="footer-contacts__link icon" href="<?= esc_attr($soc['link']['url']) ?>" target="_blank"
									style="--icon-bg: url('<?= esc_url($soc['icon']['url']) ?>')">
									<?php echo esc_html($soc['link']['title']) ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					<!-- emails -->
					<?php if (!empty($emails)): ?>
						<?php foreach ($emails as $email): ?>
							<li class="footer-contacts__item footer-contacts-emails">
								<a class="footer-contacts__link icon icon--email" href="mailto:<?= esc_attr($email['email']) ?>"
									target="_blank">
									<?php echo esc_html($email['email']) ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					<!-- phones -->
					<?php if (!empty($phones)): ?>
						<?php foreach ($phones as $phone): ?>
							<li class="footer-contacts__item footer-contacts-phones">
								<a class="footer-contacts__link icon icon--phone"
									href="tel:+<?= esc_attr(correct_phone($phone['phone'])) ?>" target="_blank">
									<?php echo esc_html($phone['phone']) ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<!-- BOTTOM: копирайт + ссылки -->
		<div class="footer__bottom">

			<?php if ($copy || $company): ?>
				<div class="footer__copy">
					&copy; <?php echo esc_html($company) . ', ' . date('Y') . '. ' . esc_html($copy); ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($links)): ?>
				<div class="footer__links">
					<?php foreach ($links as $item):
						$link = $item['footer_links_link'] ?? [];
						if (empty($link['url']))
							continue;
						?>
						<a class="footer__link link" href="<?php echo esc_url($link['url']); ?>" <?php if (!empty($link['target'])): ?>target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?> 		<?php if (!empty($link['target']) && $link['target'] === '_blank'): ?>rel="noopener noreferrer" <?php endif; ?>>
							<?php echo esc_html($link['title'] ?? ''); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</footer>