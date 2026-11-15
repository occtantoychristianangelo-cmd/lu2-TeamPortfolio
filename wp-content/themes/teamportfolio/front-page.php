<?php get_header(); ?>

<main>
    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-copy">
                <p class="eyebrow">Creative team portfolio</p>
                <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
                <p class="subtitle">
                    <?php echo esc_html(get_bloginfo('description') ?: 'We design, build, and launch experiences that help teams grow.'); ?>
                </p>
                <div class="cta-row">
                    <a class="button primary" href="#projects">View projects</a>
                    <a class="button secondary" href="<?php echo esc_url(home_url('/contact')); ?>">Get in touch</a>
                </div>
            </div>

            <div class="hero-visual" aria-label="Interactive studio preview">
                <div class="visual-orb orb-one"></div>
                <div class="visual-orb orb-two"></div>

                <div class="dashboard-card main-panel">
                    <div class="panel-head">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                    </div>
                    <div class="bar-chart">
                        <span style="--bar-height: 30%;"></span>
                        <span style="--bar-height: 45%;"></span>
                        <span style="--bar-height: 62%;"></span>
                        <span style="--bar-height: 82%;"></span>
                        <span style="--bar-height: 100%;"></span>
                    </div>
                    <div class="mini-metrics">
                        <div>
                            <small>Revenue</small>
                            <strong>+28%</strong>
                        </div>
                        <div>
                            <small>Launch</small>
                            <strong>12 wks</strong>
                        </div>
                    </div>
                </div>

                <div class="floating-tag tag-top">Brand Strategy</div>
                <div class="floating-tag tag-bottom">UX + Web</div>

                <div class="stat-card hero-card">
                    <strong>8+</strong>
                    <span>Years designing digital products</span>
                </div>
                <div class="stat-card muted hero-card card-shift">
                    <strong>45</strong>
                    <span>Projects launched worldwide</span>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="features">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">What we do</p>
                <h2>Simple solutions for ambitious teams</h2>
            </div>

            <div class="feature-grid">
                <article class="feature-item">
                    <h3>Brand Strategy</h3>
                    <p>We turn rough ideas into clear positioning and memorable identities.</p>
                </article>
                <article class="feature-item">
                    <h3>Web Design</h3>
                    <p>Beautiful, conversion-focused interfaces built to work across every screen.</p>
                </article>
                <article class="feature-item">
                    <h3>Development</h3>
                    <p>Clean builds, solid performance, and experiences that feel effortless to use.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="team-showcase">
        <div class="container">
            <div class="section-heading split-heading">
                <div>
                    <p class="eyebrow">Our team</p>
                    <h2>We are 4 creative minds behind every launch.</h2>
                </div>
                <a class="text-link" href="#">Meet the team</a>
            </div>

            <div class="team-grid">
                <article class="team-card">
                    <div class="avatar avatar-one">AL</div>
                    <h3>Ava Lee</h3>
                    <p>Brand Strategist</p>
                </article>
                <article class="team-card">
                    <div class="avatar avatar-two">MK</div>
                    <h3>Milo Kim</h3>
                    <p>Product Designer</p>
                </article>
                <article class="team-card">
                    <div class="avatar avatar-three">SR</div>
                    <h3>Sophia Reed</h3>
                    <p>Frontend Developer</p>
                </article>
                <article class="team-card">
                    <div class="avatar avatar-four">JT</div>
                    <h3>Jules Tran</h3>
                    <p>Creative Director</p>
                </article>
            </div>
        </div>
    </section>

    <section class="latest-posts">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Latest updates</p>
                <h2>Recent work & insights</h2>
            </div>

            <?php
            $posts = new WP_Query(
                array(
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                )
            );

            if ($posts->have_posts()) :
                ?>
                <div class="posts-grid">
                    <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                        <article <?php post_class('post-item'); ?>>
                            <p class="post-meta"><?php echo esc_html(get_the_date()); ?></p>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                        </article>
                    <?php endwhile; ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="empty-state">Add some posts to populate this section.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
