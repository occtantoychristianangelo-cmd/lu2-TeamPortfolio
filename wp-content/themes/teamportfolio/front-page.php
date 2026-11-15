<?php get_header(); ?>

<main id="main-content">
    <section class="hero" id="home">
        <div class="container hero-inner">
            <div class="hero-copy" data-reveal>
                <p class="eyebrow">A team of makers</p>
                <h1><?php echo esc_html(get_bloginfo('name')); ?></h1>
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
                <h2 id="projects-title">Two ideas, one curious team.</h2>
                <p class="section-intro">A growing collection of work that brings our team and our ideas to life.</p>
            </div>
            <div class="project-grid">
                <article class="project-card portfolio-project" data-reveal>
                    <div class="project-art portfolio-art" aria-hidden="true">
                        <span class="art-caption">THE PEOPLE BEHIND THE WORK</span>
                        <div class="portrait-row"><i>CT</i><i>EL</i><i>NO</i><i>JA</i></div>
                        <span class="art-label">A shared space to connect.</span>
                    </div>
                    <div class="project-content">
                        <p class="project-type">TEAM WEBSITE · PORTFOLIO</p>
                        <h3>TeamPortfolio</h3>
                        <p>A single portfolio for our team: meet each member, explore our projects, and find direct email and Facebook links.</p>
                        <ul class="project-points">
                            <li>Four individual member profiles</li>
                            <li>Project highlights and team contacts</li>
                            <li>Responsive layout with subtle motion</li>
                        </ul>
                        <a class="project-link" href="#team">Meet the contributors <span aria-hidden="true">↗</span></a>
                    </div>
                </article>

                <article class="project-card kiosk-project" data-reveal>
                    <div class="project-art kiosk-art" aria-hidden="true">
                        <span class="art-caption">PICK · CUSTOMIZE · ENJOY</span>
                        <div class="art-order">
                            <span class="art-burger">🍔</span>
                            <span><b>Build your meal</b><small>Choose what you’re craving</small></span>
                            <span class="art-plus">+</span>
                        </div>
                        <div class="art-order secondary-order">
                            <span class="art-burger">🍟</span>
                            <span><b>Add a side</b><small>Make it your own</small></span>
                            <span class="art-plus">+</span>
                        </div>
                        <span class="art-label">Your order, at your pace.</span>
                    </div>
                    <div class="project-content">
                        <p class="project-type">FOOD SERVICE · KIOSK CONCEPT</p>
                        <h3>WcDo</h3>
                        <p>A self-service food ordering and POS kiosk concept inspired by quick-service restaurant kiosks. Customers can browse a menu and build an order at the counter.</p>
                        <ul class="project-points">
                            <li>Browse food and drink categories</li>
                            <li>Build a meal from a clear menu</li>
                            <li>A streamlined counter-ordering flow</li>
                        </ul>
                        <a class="project-link" href="#contact">Ask us about WcDo <span aria-hidden="true">↗</span></a>
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
                    <div class="avatar avatar-one" aria-hidden="true">CT</div>
                    <h3>Christian Angelo Tantoy</h3>
                    <p class="member-description">Connect with Christian about the team portfolio and our project work.</p>
                    <div class="member-links">
                        <a href="mailto:occ.tantoy.christianangelo@gmail.com">Email Christian <span aria-hidden="true">↗</span></a>
                        <a href="https://www.facebook.com/profile.php?id=100079167701761" target="_blank" rel="noopener noreferrer">Facebook <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
                <article class="team-card" id="edejon-loquias" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>02</span></div>
                    <div class="avatar avatar-two" aria-hidden="true">EL</div>
                    <h3>Edejon Loquias</h3>
                    <p class="member-description">Connect with Edejon about the team portfolio and our project work.</p>
                    <div class="member-links">
                        <a href="mailto:occ.loquias.edejon2004@gmail.com">Email Edejon <span aria-hidden="true">↗</span></a>
                        <a href="https://www.facebook.com/share/1CbzuKs8p6/" target="_blank" rel="noopener noreferrer">Facebook <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
                <article class="team-card" id="noel-oculares" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>03</span></div>
                    <div class="avatar avatar-three" aria-hidden="true">NO</div>
                    <h3>Noel Oculares</h3>
                    <p class="member-description">Connect with Noel about the team portfolio and our project work.</p>
                    <div class="member-links">
                        <a href="mailto:occ.oculares.noel@gmail.com">Email Noel <span aria-hidden="true">↗</span></a>
                        <a href="https://www.facebook.com/share/1CDjB4vEft/" target="_blank" rel="noopener noreferrer">Facebook <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
                <article class="team-card" id="jhonicar-alpuerto" data-reveal>
                    <div class="member-topline"><span>TEAM MEMBER</span><span>04</span></div>
                    <div class="avatar avatar-four" aria-hidden="true">JA</div>
                    <h3>Jhonicar Alpuerto</h3>
                    <p class="member-description">Connect with Jhonicar about the team portfolio and our project work.</p>
                    <div class="member-links">
                        <a href="mailto:occ.alpuerto.jhonicar@gmail.com">Email Jhonicar <span aria-hidden="true">↗</span></a>
                        <a href="https://www.facebook.com/jhonicar.alpuerto.5" target="_blank" rel="noopener noreferrer">Facebook <span aria-hidden="true">↗</span></a>
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
                <p>We’d love to hear what you think about TeamPortfolio or WcDo. Reach out to any member of the team.</p>
            </div>
            <a class="button light-button" href="#team">Find a team member <span aria-hidden="true">↗</span></a>
        </div>
    </section>
</main>

<?php get_footer(); ?>
