<?php
$page = get_queried_object();

$title = get_field('section_our_values_title', $page) ?? '';
$list = get_field('section_our_values_list', $page) ?? [];

if ($title || !empty($list)):
	?>
	<section class="section section-our-values" id="section-our-values">
		<div class="container section-our-values__container section-gap" data-aos="fade-up" data-aos-delay="100">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
			]); ?>

			<?php if (!empty($list)): ?>
				<ul class="section-our-values__list grid">
					<?php foreach ($list as $index => $item):
						$item_icon = $item['icon'] ?? null;
						$item_title = $item['title'] ?? '';
						$item_descr = $item['descr'] ?? '';

						if (!$item_title && !$item_descr)
							continue;
						?>
						<li class="section-our-values__item section-our-values-item card-box" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
							<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
								<div class="section-our-values-item__icon">
									<?php echo wp_get_attachment_image(
										$item_icon['ID'],
										'medium',
										false,
										[
											'class' => 'img',
											'alt' => $item_icon['alt'] ?: $item_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<div class="section-our-values-item__content">
								<?php if ($item_title): ?>
									<h3 class="section-our-values-item__title title-4">
										<?php echo esc_html($item_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($item_descr): ?>
									<div class="section-our-values-item__descr descr">
										<?php echo wp_kses_post($item_descr); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>