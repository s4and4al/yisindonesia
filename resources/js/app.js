function initHeroCarousels() {
    document.querySelectorAll('[data-hero-carousel]').forEach(function (root) {
        const track = root.querySelector('[data-hero-track]');
        const slides = root.querySelectorAll('[data-hero-slide]');
        const dots = root.querySelectorAll('[data-hero-dot]');
        const prev = root.querySelector('[data-hero-prev]');
        const next = root.querySelector('[data-hero-next]');
        let index = 0;
        let timer = null;

        if (!track || slides.length < 2) return;

        function goTo(i) {
            index = (i + slides.length) % slides.length;
            track.style.transform = 'translateX(-' + (index * 100) + '%)';
            dots.forEach(function (dot, di) {
                dot.className = 'focus-ring h-2 rounded-full bg-white transition-all ' + (di === index ? 'w-6 opacity-100' : 'w-2 opacity-50');
            });
        }

        function start() {
            stop();
            timer = setInterval(function () { goTo(index + 1); }, 5000);
        }

        function stop() {
            if (timer) {
                clearInterval(timer);
                timer = null;
            }
        }

        if (prev) prev.addEventListener('click', function () { goTo(index - 1); start(); });
        if (next) next.addEventListener('click', function () { goTo(index + 1); start(); });
        dots.forEach(function (dot, di) {
            dot.addEventListener('click', function () { goTo(di); start(); });
        });

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', start);

        goTo(0);
        start();
    });
}

function initTeamCarousels() {
    document.querySelectorAll('[data-team-carousel]').forEach(function (root) {
        const viewport = root.querySelector('[data-team-viewport]');
        const track = root.querySelector('[data-team-track]');
        const slides = root.querySelectorAll('[data-team-slide]');
        const prev = root.querySelector('[data-team-prev]');
        const next = root.querySelector('[data-team-next]');
        const progress = root.querySelector('[data-team-progress]');
        const progressFill = root.querySelector('.team-carousel__progress-fill');

        if (!viewport || !track || slides.length === 0) return;

        let index = Math.floor(slides.length / 2);

        function update() {
            const activeSlide = slides[index];
            const slideCenter = activeSlide.offsetLeft + activeSlide.offsetWidth / 2;
            const offset = viewport.clientWidth / 2 - slideCenter;

            track.style.transform = 'translateX(' + offset + 'px)';
            slides.forEach(function (slide, slideIndex) {
                const isActive = slideIndex === index;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-current', isActive ? 'true' : 'false');
            });

            if (prev) prev.disabled = index === 0;
            if (next) next.disabled = index === slides.length - 1;
            if (progress) progress.setAttribute('aria-valuenow', String(index + 1));
            if (progressFill) progressFill.style.width = ((index + 1) / slides.length * 100) + '%';

            root.dataset.ready = 'true';
        }

        if (prev) {
            prev.addEventListener('click', function () {
                index = Math.max(0, index - 1);
                update();
            });
        }

        if (next) {
            next.addEventListener('click', function () {
                index = Math.min(slides.length - 1, index + 1);
                update();
            });
        }

        viewport.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft' && index > 0) {
                event.preventDefault();
                index -= 1;
                update();
            } else if (event.key === 'ArrowRight' && index < slides.length - 1) {
                event.preventDefault();
                index += 1;
                update();
            }
        });

        window.addEventListener('resize', update);
        update();
    });
}

document.addEventListener('DOMContentLoaded', function () {
    initHeroCarousels();
    initTeamCarousels();
});
