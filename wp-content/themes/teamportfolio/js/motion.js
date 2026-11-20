(function () {
    var resumeDialog = document.querySelector(".resume-dialog");
    if (resumeDialog && typeof resumeDialog.showModal === "function") {
        var resumeImage = resumeDialog.querySelector(".resume-dialog-image");
        var resumeTitle = resumeDialog.querySelector("#resume-dialog-title");
        var resumeClose = resumeDialog.querySelector(".resume-close");

        document.querySelectorAll("[data-resume-src]").forEach(function (button) {
            button.addEventListener("click", function () {
                var memberName = button.dataset.resumeName || "Team member";
                resumeImage.src = button.dataset.resumeSrc;
                resumeImage.alt = "Resume for " + memberName;
                resumeTitle.textContent = memberName + " — Resume";
                resumeDialog.showModal();
            });
        });

        resumeClose.addEventListener("click", function () {
            resumeDialog.close();
        });

        resumeDialog.addEventListener("click", function (event) {
            if (event.target === resumeDialog) {
                resumeDialog.close();
            }
        });
    }

    var projectCarousel = document.querySelector(".project-carousel");

    if (projectCarousel) {
        var projectTrack = projectCarousel.querySelector(".project-grid");
        var projectSlides = Array.prototype.slice.call(projectTrack.querySelectorAll(".project-card"));
        var projectControls = projectCarousel.querySelector(".carousel-controls");
        var previousProject = projectCarousel.querySelector("[data-carousel-previous]");
        var nextProject = projectCarousel.querySelector("[data-carousel-next]");
        var toggleProjectAutoplay = projectCarousel.querySelector("[data-carousel-toggle]");
        var projectStatus = projectCarousel.querySelector(".carousel-status");
        var currentProject = 0;

        if (projectSlides.length > 1 && projectControls && previousProject && nextProject && toggleProjectAutoplay) {
            projectControls.hidden = false;
            var reduceCarouselMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
            var autoplayPaused = reduceCarouselMotion;
            var pointerInsideCarousel = false;
            var focusInsideCarousel = false;
            var carouselVisible = false;
            var autoplayTimer = null;

            var updateAutoplayControl = function () {
                toggleProjectAutoplay.setAttribute("aria-pressed", String(!autoplayPaused));
                toggleProjectAutoplay.textContent = autoplayPaused ? "Play slideshow" : "Pause slideshow";
            };

            var clearAutoplay = function () {
                if (autoplayTimer !== null) {
                    window.clearTimeout(autoplayTimer);
                    autoplayTimer = null;
                }
            };

            var updateProjectCarousel = function () {
                var nearestDistance = Infinity;
                projectSlides.forEach(function (slide, index) {
                    var distance = Math.abs(slide.getBoundingClientRect().left - projectTrack.getBoundingClientRect().left);
                    if (distance < nearestDistance) {
                        nearestDistance = distance;
                        currentProject = index;
                    }
                });

                projectStatus.textContent = "Project " + (currentProject + 1) + " of " + projectSlides.length + ": " + projectSlides[currentProject].querySelector("h3").textContent;
            };

            var goToProject = function (destination, announce) {
                destination = (destination + projectSlides.length) % projectSlides.length;
                projectStatus.setAttribute("aria-live", announce ? "polite" : "off");
                var targetLeft = projectTrack.scrollLeft + projectSlides[destination].getBoundingClientRect().left - projectTrack.getBoundingClientRect().left;
                projectTrack.scrollTo({
                    left: targetLeft,
                    behavior: window.matchMedia("(prefers-reduced-motion: reduce)").matches ? "auto" : "smooth"
                });
            };

            var scheduleAutoplay = function () {
                clearAutoplay();
                if (autoplayPaused || pointerInsideCarousel || focusInsideCarousel || !carouselVisible || document.hidden) {
                    return;
                }

                autoplayTimer = window.setTimeout(function () {
                    goToProject(currentProject + 1, false);
                    scheduleAutoplay();
                }, 5000);
            };

            previousProject.addEventListener("click", function () {
                goToProject(currentProject - 1, true);
                scheduleAutoplay();
            });
            nextProject.addEventListener("click", function () {
                goToProject(currentProject + 1, true);
                scheduleAutoplay();
            });
            toggleProjectAutoplay.addEventListener("click", function () {
                autoplayPaused = !autoplayPaused;
                updateAutoplayControl();
                scheduleAutoplay();
            });
            projectTrack.addEventListener("scroll", updateProjectCarousel, { passive: true });
            projectTrack.addEventListener("keydown", function (event) {
                if (event.key === "ArrowLeft" || event.key === "ArrowRight") {
                    event.preventDefault();
                    goToProject(currentProject + (event.key === "ArrowRight" ? 1 : -1), true);
                }
            });
            projectCarousel.addEventListener("pointerenter", function () {
                pointerInsideCarousel = true;
                clearAutoplay();
            });
            projectCarousel.addEventListener("pointerleave", function () {
                pointerInsideCarousel = false;
                scheduleAutoplay();
            });
            projectCarousel.addEventListener("focusin", function () {
                focusInsideCarousel = true;
                clearAutoplay();
            });
            projectCarousel.addEventListener("focusout", function (event) {
                if (!projectCarousel.contains(event.relatedTarget)) {
                    focusInsideCarousel = false;
                    scheduleAutoplay();
                }
            });
            document.addEventListener("visibilitychange", scheduleAutoplay);
            if ("IntersectionObserver" in window) {
                var carouselVisibility = new IntersectionObserver(function (entries) {
                    carouselVisible = entries[0].isIntersecting;
                    scheduleAutoplay();
                }, { threshold: 0.25 });
                carouselVisibility.observe(projectCarousel);
            } else {
                carouselVisible = true;
            }
            updateProjectCarousel();
            updateAutoplayControl();
            scheduleAutoplay();
        }
    }

    var memoryBoard = document.querySelector("[data-memory-board]");
    if (memoryBoard) {
        var memoryStatus = document.querySelector("[data-memory-status]");
        var memoryStart = document.querySelector("[data-memory-start]");
        var memorySymbols = ["🍕", "🍔", "🥤", "🍟", "🍩", "🎮", "⭐", "🍿"];
        var memoryDeck = [];
        var memoryFlipped = [];
        var memoryMatches = 0;
        var memoryMoves = 0;
        var memoryLocked = true;
        var memoryMismatchTimer = null;

        var shuffleArray = function (values) {
            for (var index = values.length - 1; index > 0; index -= 1) {
                var swapIndex = Math.floor(Math.random() * (index + 1));
                var currentValue = values[index];
                values[index] = values[swapIndex];
                values[swapIndex] = currentValue;
            }
            return values;
        };

        var renderMemoryBoard = function () {
            memoryBoard.textContent = "";
            memoryDeck.forEach(function (symbol, index) {
                var card = document.createElement("button");
                card.type = "button";
                card.className = "memory-card";
                card.textContent = "?";
                card.setAttribute("aria-label", "Hidden card");
                card.dataset.symbol = symbol;
                card.dataset.index = String(index);
                card.disabled = memoryLocked;
                card.addEventListener("click", function () {
                    if (memoryLocked || card.disabled || memoryFlipped.length === 2) {
                        return;
                    }

                    card.classList.add("is-open");
                    card.textContent = symbol;
                    card.setAttribute("aria-label", "Card " + symbol);
                    memoryFlipped.push(card);

                    if (memoryFlipped.length === 2) {
                        memoryMoves += 1;
                        var first = memoryFlipped[0];
                        var second = memoryFlipped[1];
                        if (first.dataset.symbol === second.dataset.symbol) {
                            first.classList.add("is-matched");
                            second.classList.add("is-matched");
                            first.disabled = true;
                            second.disabled = true;
                            memoryMatches += 1;
                            memoryFlipped = [];
                            if (memoryMatches === memorySymbols.length) {
                                memoryLocked = true;
                                memoryStatus.textContent = "You found every pair in " + memoryMoves + " moves!";
                                memoryStart.textContent = "Play again";
                            } else {
                                memoryStatus.textContent = "Pairs: " + memoryMatches + "/" + memorySymbols.length + " · Moves: " + memoryMoves;
                            }
                        } else {
                            memoryLocked = true;
                            memoryStatus.textContent = "No match yet · Moves: " + memoryMoves;
                            memoryMismatchTimer = window.setTimeout(function () {
                                memoryFlipped.forEach(function (flippedCard) {
                                    flippedCard.classList.remove("is-open");
                                    flippedCard.textContent = "?";
                                    flippedCard.setAttribute("aria-label", "Hidden card");
                                });
                                memoryFlipped = [];
                                memoryLocked = false;
                            }, 750);
                        }
                    }
                });
                memoryBoard.appendChild(card);
            });
        };

        memoryStart.addEventListener("click", function () {
            if (memoryMismatchTimer !== null) {
                window.clearTimeout(memoryMismatchTimer);
                memoryMismatchTimer = null;
            }
            memoryDeck = shuffleArray(memorySymbols.concat(memorySymbols));
            memoryFlipped = [];
            memoryMatches = 0;
            memoryMoves = 0;
            memoryLocked = false;
            memoryStatus.textContent = "Pairs: 0/" + memorySymbols.length + " · Moves: 0";
            memoryStart.textContent = "Restart game";
            renderMemoryBoard();
        });
        renderMemoryBoard();
    }

    var moleBoard = document.querySelector("[data-mole-board]");
    if (moleBoard) {
        var moleHoles = Array.prototype.slice.call(moleBoard.querySelectorAll("[data-mole-hole]"));
        var moleStatus = document.querySelector("[data-mole-status]");
        var moleStart = document.querySelector("[data-mole-start]");
        var moleScore = 0;
        var moleTime = 20;
        var activeMole = -1;
        var moleMoveTimer = null;
        var moleClockTimer = null;
        var molePlaying = false;

        var setActiveMole = function (nextMole) {
            moleHoles.forEach(function (hole, index) {
                var isMole = index === nextMole;
                hole.classList.toggle("is-mole", isMole);
                hole.setAttribute("aria-label", isMole ? "Mole! Whack it" : "Empty hole");
                hole.querySelector("span").textContent = isMole ? "🐹" : "·";
            });
            activeMole = nextMole;
        };

        var finishMoleGame = function () {
            molePlaying = false;
            window.clearInterval(moleMoveTimer);
            window.clearInterval(moleClockTimer);
            setActiveMole(-1);
            moleStart.disabled = false;
            moleStart.textContent = "Play again";
            moleStatus.textContent = "Time! Final score: " + moleScore;
        };

        moleHoles.forEach(function (hole, index) {
            hole.addEventListener("click", function () {
                if (!molePlaying || index !== activeMole) {
                    return;
                }
                moleScore += 1;
                moleStatus.textContent = "Score: " + moleScore + " · Time: " + moleTime + "s";
                var nextMole = Math.floor(Math.random() * moleHoles.length);
                if (nextMole === activeMole) {
                    nextMole = (nextMole + 1) % moleHoles.length;
                }
                setActiveMole(nextMole);
            });
        });

        moleStart.addEventListener("click", function () {
            window.clearInterval(moleMoveTimer);
            window.clearInterval(moleClockTimer);
            moleScore = 0;
            moleTime = 20;
            molePlaying = true;
            moleStart.disabled = true;
            moleStart.textContent = "Game running";
            moleStatus.textContent = "Score: 0 · Time: 20s";
            setActiveMole(Math.floor(Math.random() * moleHoles.length));
            moleMoveTimer = window.setInterval(function () {
                var nextMole = Math.floor(Math.random() * moleHoles.length);
                if (nextMole === activeMole) {
                    nextMole = (nextMole + 1) % moleHoles.length;
                }
                setActiveMole(nextMole);
            }, 800);
            moleClockTimer = window.setInterval(function () {
                moleTime -= 1;
                if (moleTime <= 0) {
                    finishMoleGame();
                } else {
                    moleStatus.textContent = "Score: " + moleScore + " · Time: " + moleTime + "s";
                }
            }, 1000);
        });
    }

    var puzzleBoard = document.querySelector("[data-puzzle-board]");
    if (puzzleBoard) {
        var puzzleChoice = document.querySelector("[data-puzzle-choice]");
        var puzzleStatus = document.querySelector("[data-puzzle-status]");
        var puzzleShuffle = document.querySelector("[data-puzzle-shuffle]");
        var puzzleTiles = [];
        var puzzleOrder = [];
        var puzzleMoves = 0;
        var puzzleImage = puzzleChoice.value;

        for (var tileIndex = 0; tileIndex < 9; tileIndex += 1) {
            var puzzleTile = document.createElement("button");
            puzzleTile.type = "button";
            puzzleTile.className = "puzzle-tile";
            puzzleTile.dataset.position = String(tileIndex);
            puzzleTile.addEventListener("click", function () {
                var position = Number(this.dataset.position);
                var emptyPosition = puzzleOrder.indexOf(8);
                var sameRow = Math.floor(position / 3) === Math.floor(emptyPosition / 3);
                var adjacent = (sameRow && Math.abs(position - emptyPosition) === 1) || Math.abs(position - emptyPosition) === 3;
                if (!adjacent) {
                    return;
                }

                var movedTile = puzzleOrder[position];
                puzzleOrder[position] = 8;
                puzzleOrder[emptyPosition] = movedTile;
                puzzleMoves += 1;
                renderPuzzle();
            });
            puzzleTiles.push(puzzleTile);
            puzzleBoard.appendChild(puzzleTile);
        }

        function renderPuzzle() {
            puzzleTiles.forEach(function (tile, position) {
                var piece = puzzleOrder[position];
                tile.classList.toggle("is-empty", piece === 8);
                tile.disabled = piece === 8;
                if (piece === 8) {
                    tile.style.backgroundImage = "none";
                    tile.setAttribute("aria-label", "Empty space");
                } else {
                    tile.style.backgroundImage = "url(\"" + puzzleImage + "\")";
                    tile.style.backgroundSize = "300% 300%";
                    tile.style.backgroundPosition = (piece % 3 * 50) + "% " + (Math.floor(piece / 3) * 50) + "%";
                    tile.setAttribute("aria-label", "Portrait piece " + (piece + 1) + ", position " + (position + 1));
                }
            });

            var solved = puzzleOrder.every(function (piece, position) { return piece === position; });
            puzzleStatus.textContent = solved ? "Portrait complete in " + puzzleMoves + " moves!" : "Moves: " + puzzleMoves;
        }

        var shufflePuzzle = function () {
            puzzleOrder = [0, 1, 2, 3, 4, 5, 6, 7, 8];
            var emptyPosition = 8;
            var previousEmpty = -1;
            for (var step = 0; step < 48; step += 1) {
                var possible = [emptyPosition - 3, emptyPosition + 3];
                if (emptyPosition % 3 > 0) possible.push(emptyPosition - 1);
                if (emptyPosition % 3 < 2) possible.push(emptyPosition + 1);
                possible = possible.filter(function (position) {
                    return position >= 0 && position < 9 && position !== previousEmpty;
                });
                var nextPosition = possible[Math.floor(Math.random() * possible.length)];
                puzzleOrder[emptyPosition] = puzzleOrder[nextPosition];
                puzzleOrder[nextPosition] = 8;
                previousEmpty = emptyPosition;
                emptyPosition = nextPosition;
            }
            puzzleMoves = 0;
            renderPuzzle();
        };

        puzzleChoice.addEventListener("change", function () {
            puzzleImage = puzzleChoice.value;
            shufflePuzzle();
        });
        puzzleShuffle.addEventListener("click", shufflePuzzle);
        shufflePuzzle();
    }

    var josePeek = document.querySelector(".jose-peek");
    var snowfall = document.querySelector(".christmas-snowfall");
    var joseAudio = document.querySelector(".jose-peek-audio");

    if (josePeek && !window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
        var joseSoundEnabled = false;
        var peekSides = ["left", "right"];
        var peekSideIndex = Math.floor(Math.random() * peekSides.length);

        var playJoseAudio = function () {
            if (!joseAudio || !joseSoundEnabled) {
                return;
            }

            joseAudio.volume = 0.45;
            var playback = joseAudio.play();
            if (playback && typeof playback.catch === "function") {
                playback.catch(function () {
                    joseSoundEnabled = false;
                });
            }
        };

        var enableJoseSound = function () {
            joseSoundEnabled = true;
            if (josePeek.classList.contains("is-peeking")) {
                playJoseAudio();
            }
            document.removeEventListener("pointerdown", enableJoseSound);
            document.removeEventListener("keydown", enableJoseSound);
        };

        document.addEventListener("pointerdown", enableJoseSound, { once: true, passive: true });
        document.addEventListener("keydown", enableJoseSound, { once: true });

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

                josePeek.classList.remove("peek-right");
                josePeek.style.top = "auto";
                josePeek.style.bottom = "0";
                josePeek.style.translate = "0 0";
                var peekSide = peekSides[peekSideIndex % peekSides.length];
                peekSideIndex += 1;
                if (peekSide === "right") {
                    josePeek.classList.add("peek-right");
                }

                josePeek.classList.add("is-peeking");
                document.documentElement.classList.add("christmas-mode");
                playJoseAudio();
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

        var startInitialPeek = function () {
            scheduleJosePeek(1200, 1800);
        };

        if (document.readyState === "complete") {
            startInitialPeek();
        } else {
            window.addEventListener("load", startInitialPeek, { once: true });
        }
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
