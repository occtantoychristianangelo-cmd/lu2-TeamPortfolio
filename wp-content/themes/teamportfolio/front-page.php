<?php get_header(); ?>

<main id="main-content">
    <section class="hero" id="home">
        <div class="container hero-inner">
            <div class="hero-copy" data-reveal>
                <p class="eyebrow">A team of makers</p>
                <h1 aria-label="LU2 Portfolio"><span class="title-letter" aria-hidden="true" style="--letter-index: 0">L</span><span class="title-letter" aria-hidden="true" style="--letter-index: 1">U</span><span class="title-letter" aria-hidden="true" style="--letter-index: 2">2</span><span aria-hidden="true">&nbsp;</span><span class="title-letter" aria-hidden="true" style="--letter-index: 3">P</span><span class="title-letter" aria-hidden="true" style="--letter-index: 4">o</span><span class="title-letter" aria-hidden="true" style="--letter-index: 5">r</span><span class="title-letter" aria-hidden="true" style="--letter-index: 6">t</span><span class="title-letter" aria-hidden="true" style="--letter-index: 7">f</span><span class="title-letter" aria-hidden="true" style="--letter-index: 8">o</span><span class="title-letter" aria-hidden="true" style="--letter-index: 9">l</span><span class="title-letter" aria-hidden="true" style="--letter-index: 10">i</span><span class="title-letter" aria-hidden="true" style="--letter-index: 11">o</span></h1>
                <p class="subtitle">
                    Four collaborators bringing our people, ideas, and digital projects together in one place.
                </p>
                <div class="cta-row">
                    <a class="button primary" href="#projects">Explore our projects</a>
                    <a class="button secondary" href="#team">Meet the team</a>
                </div>
            </div>

            <div class="hero-visual" aria-label="Preview of the WcDo food ordering kiosk" data-reveal>
                <div class="visual-orb orb-one"></div>
                <div class="visual-orb orb-two"></div>
                <div class="kiosk-card">
                    <div class="kiosk-topline">
                        <span class="kiosk-mark" aria-hidden="true">W</span>
                        <span>WcDo <small>ORDER KIOSK</small></span>
                        <span class="kiosk-status"><i></i> Ready to order</span>
                    </div>
                    <p class="kiosk-greeting">Good food, your way.</p>
                    <div class="kiosk-menu">
                        <div class="menu-item"><span class="menu-emoji" aria-hidden="true">🍔</span><span><strong>Burgers</strong><small>Made for your appetite</small></span><b>→</b></div>
                        <div class="menu-item"><span class="menu-emoji" aria-hidden="true">🍟</span><span><strong>Sides</strong><small>Make it a meal</small></span><b>→</b></div>
                        <div class="menu-item"><span class="menu-emoji" aria-hidden="true">🥤</span><span><strong>Drinks</strong><small>A refreshing finish</small></span><b>→</b></div>
                    </div>
                    <div class="kiosk-footer"><span>Choose a category to get started</span><span class="kiosk-arrow" aria-hidden="true">↗</span></div>
                </div>
                <span class="floating-tag tag-top">Our projects</span>
                <span class="floating-tag tag-bottom">Made together</span>
            </div>
        </div>
    </section>

    <section class="features" aria-labelledby="approach-title">
        <div class="container">
            <div class="section-heading" data-reveal>
                <p class="eyebrow">What brings us together</p>
                <h2 id="approach-title">Good ideas, made more useful.</h2>
                <p class="section-intro">We use this portfolio to share the people behind our work and the projects we’re learning from.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-item" data-reveal>
                    <span class="card-number">01 / TOGETHER</span>
                    <h3>One shared portfolio</h3>
                    <p>A home for our four team members, project stories, and ways to get in touch.</p>
                </article>
                <article class="feature-item" data-reveal>
                    <span class="card-number">02 / THOUGHTFUL</span>
                    <h3>People-first experiences</h3>
                    <p>Clear, welcoming interfaces that help people find their way around and take action.</p>
                </article>
                <article class="feature-item" data-reveal>
                    <span class="card-number">03 / PRACTICAL</span>
                    <h3>Ideas you can interact with</h3>
                    <p>From a team introduction to a food-ordering kiosk concept, we explore useful digital products.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="projects-section" id="projects" aria-labelledby="projects-title">
        <div class="container">
            <div class="section-heading" data-reveal>
                <p class="eyebrow">Selected projects</p>
                <h2 id="projects-title">Three projects, one curious team.</h2>
                <p class="section-intro">A growing collection of work that brings our team and our ideas to life.</p>
            </div>
            <div class="project-grid">
                <article class="project-card featured-project" data-reveal>
                    <div class="project-art">
                        <img
                            class="project-preview"
                            src="<?php echo esc_url(get_theme_file_uri('/assets/image/project-screenshot-template.svg')); ?>"
                            alt="Screenshot placeholder for the LU2 Portfolio project"
                            width="1200"
                            height="760"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="preview-badge">SCREENSHOT PLACEHOLDER</span>
                    </div>
                    <div class="project-content">
                        <p class="project-type">TEAM WEBSITE · PORTFOLIO</p>
                        <h3>LU2 Portfolio</h3>
                        <p>A single portfolio for our team: meet each member, explore our projects, and find direct email and Facebook links.</p>
                        <ul class="project-points">
                            <li>Four individual member profiles</li>
                            <li>Project highlights and team contacts</li>
                            <li>Responsive layout with subtle motion</li>
                        </ul>
                        <details class="project-details">
                            <summary>About this project</summary>
                            <p>LU2 Portfolio is the shared home for the team, project summaries, and direct contact links.</p>
                        </details>
                        <a class="project-link" href="#team">Meet the contributors <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>

                <article class="project-card" data-reveal>
                    <div class="project-art">
                        <img
                            class="project-preview"
                            src="<?php echo esc_url(get_theme_file_uri('/assets/image/wcdo-preview.svg')); ?>"
                            alt="Illustrated preview of the WcDo self-service ordering kiosk"
                            width="1200"
                            height="760"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="preview-badge">KIOSK CONCEPT</span>
                    </div>
                    <div class="project-content">
                        <p class="project-type">FOOD SERVICE · KIOSK CONCEPT</p>
                        <h3>WcDo</h3>
                        <p>WcDo explores a simple counter-ordering experience: customers browse food categories, build a meal, and review an order at a self-service kiosk.</p>
                        <ul class="project-points">
                            <li>Browse food and drink categories</li>
                            <li>Build a meal from a clear menu</li>
                            <li>A streamlined counter-ordering flow</li>
                        </ul>
                        <details class="project-details">
                            <summary>About this project</summary>
                            <p>WcDo is a self-service ordering and POS kiosk concept. This portfolio preview is illustrative; the sample menu and prices are not a live service.</p>
                        </details>
                        <a class="project-link" href="#contact">Ask us about WcDo <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>

                <article class="project-card" data-reveal>
                    <div class="project-art">
                        <img
                            class="project-preview"
                            src="<?php echo esc_url(get_theme_file_uri('/assets/image/resto-freeno-preview.svg')); ?>"
                            alt="Illustrated overview of the Resto Freeno restaurant operations interface"
                            width="1200"
                            height="760"
                            loading="lazy"
                            decoding="async"
                        >
                        <span class="preview-badge">OPERATIONS CONCEPT</span>
                    </div>
                    <div class="project-content">
                        <p class="project-type">RESTAURANT OPERATIONS · CONCEPT</p>
                        <h3>Resto Freeno</h3>
                        <p>Resto Freeno explores how restaurant teams can see orders, table sessions, and stock information together during daily service.</p>
                        <ul class="project-points">
                            <li>Order flow overview</li>
                            <li>Table session visibility</li>
                            <li>Stock and service at a glance</li>
                        </ul>
                        <details class="project-details">
                            <summary>About this project</summary>
                            <p>Resto Freeno is a restaurant-operations interface concept. Its preview is intended to show an overview of orders, table sessions, and stock and service information.</p>
                        </details>
                        <a class="project-link" href="#contact">Ask us about Resto Freeno <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="team-showcase" id="team" aria-labelledby="team-title">
        <div class="container">
            <div class="section-heading split-heading" data-reveal>
                <div>
                    <p class="eyebrow">The people behind it</p>
                    <h2 id="team-title">Four names. One team.</h2>
                </div>
                <p class="team-note">Say hello, connect on Facebook, or reach out about what we’re building.</p>
            </div>

            <div class="team-grid">
                <article class="team-card" id="christian-angelo-tantoy" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>01</span></div>
                    <div class="member-photo">
                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/image/ChristianAngeloTantoy.png')); ?>" alt="Portrait of Christian Angelo Tantoy" loading="lazy">
                        <span class="photo-index">01</span>
                    </div>
                    <h3>Christian Angelo Tantoy</h3>
                    <p class="member-role">Programmer</p>
                    <p class="member-description">Christian enjoys programming and playing MOBA games.</p>
                    <div class="member-links">
                        <a href="mailto:occ.tantoy.christianangelo@gmail.com"><svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><span>Email Christian</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                        <a href="https://www.facebook.com/profile.php?id=100079167701761" target="_blank" rel="noopener noreferrer"><svg class="social-icon facebook-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.3v3h2.8v8h3.4Z"/></svg><span>Facebook</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
                <article class="team-card" id="edejon-loquias" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>02</span></div>
                    <div class="member-photo">
                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/image/EdejonLoquias.png')); ?>" alt="Portrait of Edejon Loquias" loading="lazy">
                        <span class="photo-index">02</span>
                    </div>
                    <h3>Edejon Loquias</h3>
                    <p class="member-role">Technical Writer</p>
                    <p class="member-description">Edejon writes technical content and is the youngest member of the group.</p>
                    <div class="member-links">
                        <a href="mailto:occ.loquias.edejon2004@gmail.com"><svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><span>Email Edejon</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                        <a href="https://www.facebook.com/share/1CbzuKs8p6/" target="_blank" rel="noopener noreferrer"><svg class="social-icon facebook-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.3v3h2.8v8h3.4Z"/></svg><span>Facebook</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
                <article class="team-card" id="noel-oculares" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>03</span></div>
                    <div class="member-photo">
                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/image/NoelOculares.png')); ?>" alt="Portrait of Noel Oculares" loading="lazy">
                        <span class="photo-index">03</span>
                    </div>
                    <h3>Noel Oculares</h3>
                    <p class="member-role">System Analyst</p>
                    <p class="member-description">Noel is curious by nature and likes to question assumptions.</p>
                    <div class="member-links">
                        <a href="mailto:occ.oculares.noel@gmail.com"><svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><span>Email Noel</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                        <a href="https://www.facebook.com/share/1CDjB4vEft/" target="_blank" rel="noopener noreferrer"><svg class="social-icon facebook-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.3v3h2.8v8h3.4Z"/></svg><span>Facebook</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
                <article class="team-card" id="jhonicar-alpuerto" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>04</span></div>
                    <div class="member-photo">
                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/image/JhonicarAlpuerto.png')); ?>" alt="Portrait of Jhonicar Alpuerto" loading="lazy">
                        <span class="photo-index">04</span>
                    </div>
                    <h3>Jhonicar Alpuerto</h3>
                    <p class="member-role">Project Manager</p>
                    <p class="member-description">Jhonicar likes to keep up with project updates and ask what’s next.</p>
                    <div class="member-links">
                        <a href="mailto:occ.alpuerto.jhonicar@gmail.com"><svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg><span>Email Jhonicar</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                        <a href="https://www.facebook.com/jhonicar.alpuerto.5" target="_blank" rel="noopener noreferrer"><svg class="social-icon facebook-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.5 1.6-1.5h1.7V3.9c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V10H7.3v3h2.8v8h3.4Z"/></svg><span>Facebook</span><svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="contact-section" id="contact" aria-labelledby="contact-title">
        <div class="container contact-inner" data-reveal>
            <div>
                <p class="eyebrow">Start a conversation</p>
                <h2 id="contact-title">Have a question or an idea?</h2>
                <p>We’d love to hear what you think about our projects. Reach out to the whole team or contact a member directly.</p>
            </div>
            <div class="contact-actions">
                <a class="button light-button" href="mailto:occ.tantoy.christianangelo@gmail.com,occ.loquias.edejon2004@gmail.com,occ.oculares.noel@gmail.com,occ.alpuerto.jhonicar@gmail.com">Email the team <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                <a class="contact-secondary" href="#team">Or choose a member</a>
            </div>
        </div>
    </section>

    <div class="christmas-snowfall" aria-hidden="true"></div>
    <div class="jose-peek" aria-hidden="true">
        <img src="<?php echo esc_url(get_theme_file_uri('/assets/image/jose.png')); ?>" alt="" decoding="async">
    </div>
    <audio class="jose-peek-audio" src="<?php echo esc_url(get_theme_file_uri('/assets/audio/snowflakessound.mp3')); ?>" preload="auto" aria-hidden="true"></audio>
</main>

<?php get_footer(); ?>
