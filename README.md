# LU2 Portfolio

LU2 Portfolio is a WordPress theme and homepage for a four-person project team. It introduces the team, highlights our projects, and gives visitors direct email and Facebook links for each member.

## Projects

### LU2 Portfolio — one shared portfolio

The portfolio brings our people and work together in one place. Visitors can read the team profiles, explore project summaries, and contact a member directly. The responsive layout uses individual team portraits, subtle on-scroll reveals, and hover interactions to make the site feel lively without getting in the way.

### BotiTea — drinks shop management system

BotiTea is a focused management system for a milk tea and drinks shop. Its staff and admin screens cover order tracking, drink product management, and staff accounts. The system centers on beverages such as milk tea and other drinks, rather than the broader restaurant operations covered by Resto Freeno. Screenshots are in `wp-content/themes/teamportfolio/assets/image/ProjectsImages/` as `BotiTea-S1.png`, `BotiTea-S2.png`, and `BotiTea-S3.png`.

### Resto Freeno — restaurant management system

Resto Freeno is a broader restaurant management system. Its screenshots are `RestoFreeno-S1.png`, `RestoFreeno-S2.png`, and `RestoFreeno-S3.png` in the same image directory.

Project cards include expandable project notes and show the supplied screenshots in a compact gallery. The LU2 project uses `LU2Portfolio.png`; BotiTea and Resto Freeno each display their three numbered screenshots.

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

The homepage has responsive project and team sections, an animated BotiTea drinks preview, and optional scroll-reveal effects. Scroll reveals are enabled when the browser supports `IntersectionObserver`; visitors who prefer reduced motion are shown the content without motion.

## Install

1. Copy `wp-content/themes/teamportfolio` into the `wp-content/themes/` directory of a WordPress installation.
2. Activate **LU2 Portfolio** under **Appearance → Themes**.
3. Set the site name and tagline under **Settings → General**.
4. Optionally create and assign a **Primary Menu** under **Appearance → Menus**. If no menu is assigned, the theme shows links to the homepage sections automatically.

The homepage uses WordPress's `front-page.php` template. Member portraits and project screenshots are stored in `wp-content/themes/teamportfolio/assets/image/`. The home page supplies description and Open Graph metadata; its social preview image uses the front page's featured image when one is set. Theme styles and the motion script are in `css/` and `js/` and are enqueued by `functions.php`.
