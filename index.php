<?php get_header(); ?>
<?php get_template_part('partials/components/hero-page', null, ['class' => 'hero-page-index']) ?>

<?php if (have_posts()): ?>
	<?php while (have_posts()):
		the_post(); ?>
		<section class="index-section" data-aos="fade-up">
			<div class="container descr ">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
<?php else: ?>
	<section class="index-section" data-aos="fade-up">
		<div class="container descr ">
			<p>Записей не найдено.</p>
		</div>
	</section>
<?php endif; ?>


<?php get_footer(); ?>