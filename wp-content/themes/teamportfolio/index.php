<?php get_header(); ?>

<main id="main-content" class="site-main container">
    <?php if (have_posts()) : ?>
        <header class="page-header">
            <h1><?php bloginfo('name'); ?></h1>
        </header>

        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('post-card'); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No content yet. Add your first post or set a static homepage.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
