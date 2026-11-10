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

document.addEventListener('DOMContentLoaded', initHeroCarousels);
