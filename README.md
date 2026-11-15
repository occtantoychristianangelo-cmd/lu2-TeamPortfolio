# LU2 Portfolio

LU2 Portfolio is a WordPress theme and homepage for a four-person project team. It introduces the team, highlights our projects, and gives visitors direct email and Facebook links for each member.

## Projects

### LU2 Portfolio — one shared portfolio

The portfolio brings our people and work together in one place. Visitors can read the team profiles, explore project summaries, and contact a member directly. The responsive layout uses individual team portraits, subtle on-scroll reveals, and hover interactions to make the site feel lively without getting in the way.

### WcDo — food ordering kiosk concept

WcDo is a point-of-sale and self-service ordering kiosk concept inspired by quick-service restaurant kiosks such as McDonald's. It is intended to let customers browse food and drink categories, build an order, and move through a straightforward counter-ordering experience. The illustrated concept artwork is `wp-content/themes/teamportfolio/assets/image/wcdo-preview.svg`. The project is presented here as a concept; the sample menu and prices are illustrative, and this portfolio does not claim that payment processing, kitchen management, or a production POS backend is implemented.

### Resto Freeno — restaurant operations concept

Resto Freeno is a restaurant operations interface concept that presents order flow, table sessions, and stock and service information in one overview. Its concept artwork is `wp-content/themes/teamportfolio/assets/image/resto-freeno-preview.svg`.

Project cards include expandable project notes and replaceable screenshot areas. They currently use `wp-content/themes/teamportfolio/assets/image/project-screenshot-template.svg`; replace each project's image `src` in `front-page.php` with its own screenshot when available. The screenshot template is designed for landscape images around 1200 × 760 pixels.

## Team

| Name | Email | Facebook |
| --- | --- | --- |
| Christian Angelo Tantoy | [occ.tantoy.christianangelo@gmail.com](mailto:occ.tantoy.christianangelo@gmail.com) | [Profile](https://www.facebook.com/profile.php?id=100079167701761) |
| Edejon Loquias | [occ.loquias.edejon2004@gmail.com](mailto:occ.loquias.edejon2004@gmail.com) | [Profile](https://www.facebook.com/share/1CbzuKs8p6/) |
| Noel Oculares | [occ.oculares.noel@gmail.com](mailto:occ.oculares.noel@gmail.com) | [Profile](https://www.facebook.com/share/1CDjB4vEft/) |
| Jhonicar Alpuerto | [occ.alpuerto.jhonicar@gmail.com](mailto:occ.alpuerto.jhonicar@gmail.com) | [Profile](https://www.facebook.com/jhonicar.alpuerto.5) |

### Member profiles

- **Christian Angelo Tantoy — Programmer:** enjoys programming and playing MOBA games.
- **Edejon Loquias — Technical Writer:** the youngest member of the group.
- **Noel Oculares — System Analyst:** curious and likes to question assumptions.
- **Jhonicar Alpuerto — Project Manager:** likes to stay up to date on project progress.

## Design and motion

The visual theme follows the supplied palette:

- Ink: `#0c0a08`
- Forest green: `#2a3723`
- Sage: `#b9bba8`
- Warm off-white: `#e8e5dd`
- Sand: `#dcbc98`

The homepage has responsive project and team sections, animated kiosk artwork, and optional scroll-reveal effects. Scroll reveals are enabled when the browser supports `IntersectionObserver`; visitors who prefer reduced motion are shown the content without motion.

## Install

1. Copy `wp-content/themes/teamportfolio` into the `wp-content/themes/` directory of a WordPress installation.
2. Activate **LU2 Portfolio** under **Appearance → Themes**.
3. Set the site name and tagline under **Settings → General**.
4. Optionally create and assign a **Primary Menu** under **Appearance → Menus**. If no menu is assigned, the theme shows links to the homepage sections automatically.

The homepage uses WordPress's `front-page.php` template. Member portraits and project screenshot templates are stored in `wp-content/themes/teamportfolio/assets/image/`. The home page supplies description and Open Graph metadata; its social preview image uses the front page's featured image when one is set. Theme styles and the motion script are in `css/` and `js/` and are enqueued by `functions.php`.
