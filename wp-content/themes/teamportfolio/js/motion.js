(function () {
    var josePeek = document.querySelector(".jose-peek");
    var snowfall = document.querySelector(".christmas-snowfall");
    var joseAudio = document.querySelector(".jose-peek-audio");

    if (josePeek && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        if (snowfall) {
            var flakeSource = josePeek.querySelector("img").src.replace("jose.png", "snowflake.svg");

            for (var flakeIndex = 0; flakeIndex < 28; flakeIndex += 1) {
                var flake = document.createElement("span");
                flake.className = "snowflake";
                flake.style.setProperty("--flake-mask", "url(\"" + flakeSource + "\")");
                flake.setAttribute("aria-hidden", "true");
                flake.style.left = Math.random() * 100 + "vw";
                var isLargeFlake = flakeIndex % 7 === 0;
                var flakeSize = isLargeFlake ? 40 + Math.random() * 12 : 16 + Math.random() * 20;
                flake.style.setProperty("--flake-size", flakeSize + "px");
                flake.style.setProperty("--flake-opacity", 0.45 + Math.random() * 0.5);
                flake.style.setProperty("--flake-duration", 6 + Math.random() * 6 + "s");
                flake.style.setProperty("--flake-delay", -Math.random() * 10 + "s");
                flake.style.setProperty("--flake-drift", -55 + Math.random() * 110 + "px");
                snowfall.appendChild(flake);
            }
        }

        var scheduleJosePeek = function (minimum, maximum) {
            var delay = minimum + Math.random() * (maximum - minimum);

            window.setTimeout(function () {
                if (document.visibilityState !== "visible") {
                    scheduleJosePeek(5000, 12000);
                    return;
                }

                josePeek.classList.add("is-peeking");
                document.documentElement.classList.add("christmas-mode");
                if (joseAudio) {
                    joseAudio.volume = 0.45;
                    var playback = joseAudio.play();
                    if (playback && typeof playback.catch === "function") {
                        playback.catch(function () {});
                    }
                }
                window.setTimeout(function () {
                    josePeek.classList.remove("is-peeking");
                    document.documentElement.classList.remove("christmas-mode");
                    if (joseAudio) {
                        joseAudio.pause();
                        joseAudio.currentTime = 0;
                    }
                    scheduleJosePeek(40000, 85000);
                }, 3000);
            }, delay);
        };

        scheduleJosePeek(12000, 30000);
    }

    var elements = document.querySelectorAll("[data-reveal]");

    if (!("IntersectionObserver" in window) || window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        return;
    }

    document.documentElement.classList.add("has-scroll-reveal");

    var observer = new IntersectionObserver(function (entries, currentObserver) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-visible");
                currentObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    elements.forEach(function (element) {
        observer.observe(element);
    });
})();
