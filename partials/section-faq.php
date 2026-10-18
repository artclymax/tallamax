<?php
$page = get_queried_object();
$class = $args['class'] ?? '';
$title = get_field('section_faq_title', $page) ?? '';
$items = get_field('section_faq_items', $page) ?? [];

if ($title || !empty($items)):
	?>
	<section class="section section-faq <?= esc_attr($class); ?>" id="section-faq">
		<div class="container section-faq__container section-gap" data-aos="fade-up" data-aos-delay="100">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
			]); ?>

			<?php if (!empty($items)): ?>
				<div class="section-faq__list grid">
					<?php foreach ($items as $index => $item):
						$item_question = $item['question'] ?? '';
						$item_answer = $item['answer'] ?? '';

						if (!$item_question && !$item_answer)
							continue;
						?>
						<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
							<button class="spoiler-item__btn" data-spoiler-title type="button">
								<h3 class="spoiler-item__title"><?php echo esc_html($item_question); ?></h3>
								<span class="spoiler-item__icon"></span>
							</button>
							<div class="spoiler-item__content" data-spoiler-content>
								<div class="spoiler-item__content-wrapper">
									<div class="spoiler-item__descr descr">
										<?php echo wp_kses_post($item_answer); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>