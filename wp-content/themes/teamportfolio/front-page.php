<?php get_header(); ?>

<main id="main-content">
    <section class="hero" id="home">
        <div class="container hero-inner">
            <div class="hero-copy" data-reveal>
                <p class="eyebrow">A team of makers</p>
                <h1 aria-label="LU2 Portfolio"><span class="title-letter" aria-hidden="true" style="--letter-index: 0">L</span><span class="title-letter" aria-hidden="true" style="--letter-index: 1">U</span><span class="title-letter" aria-hidden="true" style="--letter-index: 2">2</span><span aria-hidden="true">&nbsp;</span><span class="title-letter" aria-hidden="true" style="--letter-index: 3">P</span><span class="title-letter" aria-hidden="true" style="--letter-index: 4">o</span><span class="title-letter" aria-hidden="true" style="--letter-index: 5">r</span><span class="title-letter" aria-hidden="true" style="--letter-index: 6">t</span><span class="title-letter" aria-hidden="true" style="--letter-index: 7">f</span><span class="title-letter" aria-hidden="true" style="--letter-index: 8">o</span><span class="title-letter" aria-hidden="true" style="--letter-index: 9">l</span><span class="title-letter" aria-hidden="true" style="--letter-index: 10">i</span><span class="title-letter" aria-hidden="true" style="--letter-index: 11">o</span></h1>
                <p class="subtitle">Meet four collaborators, explore the projects we’re learning from, and find a direct way to connect with the team.</p>
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
                <p class="section-intro">LU2 brings four collaborators and their work together in one place. Explore WcDo, a self-service food-ordering concept, and Resto Freeno, a restaurant-operations concept.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-item" data-reveal>
                    <span class="card-number">01 / TOGETHER</span>
                    <h3>One shared portfolio</h3>
                    <p>Meet all four contributors, learn about their roles, explore the project snapshots, and contact a team member directly.</p>
                </article>
                <article class="feature-item" data-reveal>
                    <span class="card-number">02 / THOUGHTFUL</span>
                    <h3>People-first experiences</h3>
                    <p>We value clear labels and focused flows that help people understand their options and decide what to do next.</p>
                </article>
                <article class="feature-item" data-reveal>
                    <span class="card-number">03 / PRACTICAL</span>
                    <h3>Ideas you can interact with</h3>
                    <p>Our concepts explore self-service food ordering and a clearer day-to-day view of restaurant orders, tables, and stock.</p>
                </article>
            </div>
        </div>
    </section>

        <div class="member-spotlights">
            <section class="member-spotlight" id="profile-christian" aria-labelledby="profile-christian-title" data-number="01" data-reveal>
                <div class="spotlight-inner container">
                    <div class="spotlight-copy">
                        <p class="eyebrow">Team member · 01</p>
                        <h3 id="profile-christian-title">Christian<br>Angelo Tantoy</h3>
                        <p class="spotlight-role">Programmer</p>
                        <p class="spotlight-bio">Christian enjoys programming and exploring how ideas can become working digital experiences. Outside the team, he also plays MOBA games.</p>
                        <a class="spotlight-contact" href="mailto:occ.tantoy.christianangelo@gmail.com">Email Christian <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="spotlight-photo"><img src="<?php echo esc_url(get_theme_file_uri('/assets/image/ChristianAngeloTantoy.png')); ?>" alt="Portrait of Christian Angelo Tantoy" loading="lazy" decoding="async"></div>
                </div>
            </section>

            <section class="member-spotlight alternate" id="profile-edejon" aria-labelledby="profile-edejon-title" data-number="02" data-reveal>
                <div class="spotlight-inner container">
                    <div class="spotlight-copy">
                        <p class="eyebrow">Team member · 02</p>
                        <h3 id="profile-edejon-title">Edejon<br>Loquias</h3>
                        <p class="spotlight-role">Technical Writer</p>
                        <p class="spotlight-bio">Edejon writes technical content and helps make project information clear and easy to follow.</p>
                        <a class="spotlight-contact" href="mailto:occ.loquias.edejon2004@gmail.com">Email Edejon <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="spotlight-photo"><img src="<?php echo esc_url(get_theme_file_uri('/assets/image/EdejonLoquias.png')); ?>" alt="Portrait of Edejon Loquias" loading="lazy" decoding="async"></div>
                </div>
            </section>

            <section class="member-spotlight" id="profile-noel" aria-labelledby="profile-noel-title" data-number="03" data-reveal>
                <div class="spotlight-inner container">
                    <div class="spotlight-copy">
                        <p class="eyebrow">Team member · 03</p>
                        <h3 id="profile-noel-title">Noel<br>Oculares</h3>
                        <p class="spotlight-role">System Analyst</p>
                        <p class="spotlight-bio">Noel is a curious system analyst who likes to question assumptions and understand how things work.</p>
                        <a class="spotlight-contact" href="mailto:occ.oculares.noel@gmail.com">Email Noel <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="spotlight-photo"><img src="<?php echo esc_url(get_theme_file_uri('/assets/image/NoelOculares.png')); ?>" alt="Portrait of Noel Oculares" loading="lazy" decoding="async"></div>
                </div>
            </section>

            <section class="member-spotlight alternate" id="profile-jhonicar" aria-labelledby="profile-jhonicar-title" data-number="04" data-reveal>
                <div class="spotlight-inner container">
                    <div class="spotlight-copy">
                        <p class="eyebrow">Team member · 04</p>
                        <h3 id="profile-jhonicar-title">Jhonicar<br>Alpuerto</h3>
                        <p class="spotlight-role">Project Manager</p>
                        <p class="spotlight-bio">Jhonicar follows project updates and keeps an eye on what the team should tackle next.</p>
                        <a class="spotlight-contact" href="mailto:occ.alpuerto.jhonicar@gmail.com">Email Jhonicar <span aria-hidden="true">↗</span></a>
                    </div>
                    <div class="spotlight-photo"><img src="<?php echo esc_url(get_theme_file_uri('/assets/image/JhonicarAlpuerto.png')); ?>" alt="Portrait of Jhonicar Alpuerto" loading="lazy" decoding="async"></div>
                </div>
            </section>
        </div>

    <section class="projects-section" id="projects" aria-labelledby="projects-title">
        <div class="container">
            <div class="section-heading" data-reveal>
                <p class="eyebrow">Selected projects</p>
                <h2 id="projects-title">Three projects, one curious team.</h2>
                <p class="section-intro">A growing collection of work that brings our team and our ideas to life.</p>
            </div>
            <div class="project-carousel" role="region" aria-roledescription="carousel" aria-label="Selected projects">
                <div class="project-grid" id="project-carousel-track" tabindex="0" aria-label="Project slides">
                <article class="project-card featured-project" data-reveal role="group" aria-roledescription="slide" aria-label="1 of 3: LU2 Portfolio">
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
                            <summary>Project snapshot</summary>
                            <p><strong>Purpose:</strong> Bring the four team profiles, project summaries, and contact links together in one place.</p>
                            <p><strong>For:</strong> Visitors who want to meet the team and explore its work.</p>
                            <p><strong>Preview:</strong> The image is a replaceable placeholder, not a screenshot of the finished page.</p>
                            <ol class="project-flow" aria-label="Portfolio visitor flow">
                                <li><span>01</span> Meet the team</li>
                                <li><span>02</span> Explore projects</li>
                                <li><span>03</span> Make contact</li>
                            </ol>
                        </details>
                        <a class="project-link" href="#team">Meet the contributors <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>

                <article class="project-card" data-reveal role="group" aria-roledescription="slide" aria-label="2 of 3: WcDo">
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
                        <p>WcDo is a quick-service kiosk concept for customers ordering at the counter. It explores a simple flow from browsing food categories to building a meal.</p>
                        <ul class="project-points">
                            <li>Browse food and drink categories</li>
                            <li>Build a meal from a clear menu</li>
                            <li>A streamlined counter-ordering flow</li>
                        </ul>
                        <details class="project-details">
                            <summary>Project snapshot</summary>
                            <p><strong>Audience:</strong> Customers placing an order at a quick-service restaurant.</p>
                            <p><strong>Focus:</strong> Browsing categories, building a meal, and reviewing an order at a self-service kiosk.</p>
                            <p><strong>Status:</strong> Interface concept. The preview menu and prices are illustrative, not a live service.</p>
                            <ol class="project-flow" aria-label="WcDo ordering flow">
                                <li><span>01</span> Browse categories</li>
                                <li><span>02</span> Build a meal</li>
                                <li><span>03</span> Review the order</li>
                            </ol>
                        </details>
                        <a class="project-link" href="#contact">Ask us about WcDo <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>

                <article class="project-card" data-reveal role="group" aria-roledescription="slide" aria-label="3 of 3: Resto Freeno">
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
                            <summary>Project snapshot</summary>
                            <p><strong>Audience:</strong> Restaurant teams keeping track of daily service.</p>
                            <p><strong>Focus:</strong> Bringing order flow, table sessions, and stock information into one overview.</p>
                            <p><strong>Status:</strong> Restaurant-operations interface concept.</p>
                            <ol class="project-flow" aria-label="Resto Freeno overview">
                                <li><span>01</span> Order flow</li>
                                <li><span>02</span> Table sessions</li>
                                <li><span>03</span> Stock and service</li>
                            </ol>
                        </details>
                        <a class="project-link" href="#contact">Ask us about Resto Freeno <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    </div>
                </article>
                </div>
                <div class="carousel-controls" hidden>
                    <p class="carousel-status" aria-live="polite">Project 1 of 3: LU2 Portfolio</p>
                    <div class="carousel-buttons">
                        <button class="carousel-button" type="button" data-carousel-previous aria-label="Previous project">←</button>
                        <button class="carousel-toggle" type="button" data-carousel-toggle aria-pressed="true">Pause slideshow</button>
                        <button class="carousel-button" type="button" data-carousel-next aria-label="Next project">→</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="games-section" id="games" aria-labelledby="games-title">
        <div class="container">
            <div class="section-heading" data-reveal>
                <p class="eyebrow">Take a quick break</p>
                <h2 id="games-title">Play a little.</h2>
                <p class="section-intro">Three small games built into the portfolio. Pick one, play a round, and see how you do.</p>
            </div>

            <div class="game-grid">
                <article class="game-card" data-reveal>
                    <div class="game-card-heading">
                        <span class="game-number">01</span>
                        <div><h3>Memory match</h3><p>Find all eight matching pairs.</p></div>
                    </div>
                    <div class="memory-board" data-memory-board aria-label="Memory card game board"></div>
                    <div class="game-footer">
                        <p class="game-status" data-memory-status aria-live="polite">Start a game to shuffle the cards.</p>
                        <button class="game-button" type="button" data-memory-start>Start game</button>
                    </div>
                </article>

                <article class="game-card" data-reveal>
                    <div class="game-card-heading">
                        <span class="game-number">02</span>
                        <div><h3>Whack-a-mole</h3><p>Tap the mole as many times as you can in 20 seconds.</p></div>
                    </div>
                    <div class="mole-board" data-mole-board aria-label="Whack-a-mole board">
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                        <button type="button" class="mole-hole" data-mole-hole aria-label="Empty hole"><span aria-hidden="true">·</span></button>
                    </div>
                    <div class="game-footer">
                        <p class="game-status" data-mole-status aria-live="polite">Score: 0 · Time: 20s</p>
                        <button class="game-button" type="button" data-mole-start>Start game</button>
                    </div>
                </article>

                <article class="game-card" data-reveal>
                    <div class="game-card-heading">
                        <span class="game-number">03</span>
                        <div><h3>Sliding portrait</h3><p>Put the portrait back together by sliding tiles into the empty space.</p></div>
                    </div>
                    <label class="puzzle-select-label" for="portrait-puzzle-choice">Choose a portrait</label>
                    <select class="puzzle-select" id="portrait-puzzle-choice" data-puzzle-choice>
                        <option value="<?php echo esc_url(get_theme_file_uri('/assets/image/ChristianAngeloTantoy.png')); ?>">Christian</option>
                        <option value="<?php echo esc_url(get_theme_file_uri('/assets/image/EdejonLoquias.png')); ?>">Edejon</option>
                        <option value="<?php echo esc_url(get_theme_file_uri('/assets/image/NoelOculares.png')); ?>">Noel</option>
                        <option value="<?php echo esc_url(get_theme_file_uri('/assets/image/JhonicarAlpuerto.png')); ?>">Jhonicar</option>
                    </select>
                    <div class="puzzle-board" data-puzzle-board aria-label="Sliding portrait puzzle board"></div>
                    <div class="game-footer">
                        <p class="game-status" data-puzzle-status aria-live="polite">Moves: 0</p>
                        <button class="game-button" type="button" data-puzzle-shuffle>Shuffle puzzle</button>
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
                    <p class="member-description">Christian enjoys programming and exploring how ideas can become working digital experiences. He also plays MOBA games.</p>
                    <a class="member-profile-link" href="#profile-christian">View member profile <span aria-hidden="true">↗</span></a>
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
                    <p class="member-description">Edejon writes technical content and helps make project information clear and easy to follow.</p>
                    <a class="member-profile-link" href="#profile-edejon">View member profile <span aria-hidden="true">↗</span></a>
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
                    <p class="member-description">Noel is a curious system analyst who likes to question assumptions and understand how things work.</p>
                    <a class="member-profile-link" href="#profile-noel">View member profile <span aria-hidden="true">↗</span></a>
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
                    <p class="member-description">Jhonicar follows project updates and keeps an eye on what the team should tackle next.</p>
                    <a class="member-profile-link" href="#profile-jhonicar">View member profile <span aria-hidden="true">↗</span></a>
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
            <div class="contact-copy">
                <p class="eyebrow">Start a conversation</p>
                <h2 id="contact-title">Let’s talk about what you’re building.</h2>
                <p>Have a question about WcDo or Resto Freeno, feedback on the portfolio, or an idea to explore? Send the team a note or reach out to a member directly.</p>
                <ul class="contact-topics" aria-label="Reasons to contact the team">
                    <li>Project questions</li>
                    <li>Portfolio feedback</li>
                    <li>Team introductions</li>
                </ul>
            </div>
            <div class="contact-card">
                <p class="contact-card-label">YOUR NEXT STEP</p>
                <h3>Start with an email.</h3>
                <p>Your message will reach the team so you can ask about a project, share feedback, or introduce yourself.</p>
                <div class="contact-actions">
                    <a class="button light-button" href="mailto:occ.tantoy.christianangelo@gmail.com,occ.loquias.edejon2004@gmail.com,occ.oculares.noel@gmail.com,occ.alpuerto.jhonicar@gmail.com">Email the team <svg class="action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
                    <a class="contact-secondary" href="#team">Choose a team member <span aria-hidden="true">↗</span></a>
                </div>
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
