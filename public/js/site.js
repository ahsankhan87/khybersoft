/* Khybersoft – site micro-interactions (no build step required) */
(function () {
    'use strict';

    /* ---------- Announcement bar dismissal (localStorage) ---------- */
    document.addEventListener('DOMContentLoaded', function () {
        var bar = document.getElementById('announcement-bar');
        if (bar) {
            var key = 'ks_ann_' + (bar.dataset.hash || 'v1');
            if (localStorage.getItem(key) === 'closed') {
                bar.remove();
            } else {
                var btn = bar.querySelector('[data-close-announcement]');
                if (btn) btn.addEventListener('click', function () {
                    localStorage.setItem(key, 'closed');
                    bar.remove();
                });
            }
        }

        /* ---------- Animated counters (stats section) ---------- */
        var counters = document.querySelectorAll('[data-counter]');
        if (counters.length && 'IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    var el = entry.target;
                    io.unobserve(el);
                    animate(el);
                });
            }, { threshold: 0.4 });
            counters.forEach(function (c) { io.observe(c); });
        } else {
            counters.forEach(animate);
        }

        function animate(el) {
            var target = parseFloat(el.dataset.counter || '0');
            var decimals = (el.dataset.counter.split('.')[1] || '').length;
            var dur = 1600, t0 = null;
            function step(ts) {
                if (!t0) t0 = ts;
                var p = Math.min((ts - t0) / dur, 1);
                var eased = 1 - Math.pow(1 - p, 3); // easeOutCubic
                el.textContent = (target * eased).toFixed(decimals);
                if (p < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        /* ---------- Demo video modal (Alpine-friendly) ---------- */
        window.ksOpenDemo = function (url) {
            var wrap = document.getElementById('demo-modal');
            var frame = document.getElementById('demo-frame');
            if (!wrap || !frame) return;
            var yt = url.match(/(?:v=|youtu\.be\/)([\w-]{6,})/);
            frame.src = yt ? 'https://www.youtube-nocookie.com/embed/' + yt[1] + '?autoplay=1' : url;
            wrap.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };
        window.ksCloseDemo = function () {
            var wrap = document.getElementById('demo-modal');
            var frame = document.getElementById('demo-frame');
            if (wrap && frame) { frame.src = ''; wrap.classList.add('hidden'); document.body.style.overflow = ''; }
        };

        /* ---------- Back to top ---------- */
        var top = document.getElementById('back-to-top');
        if (top) {
            window.addEventListener('scroll', function () {
                top.classList.toggle('opacity-0', window.scrollY < 500);
                top.classList.toggle('pointer-events-none', window.scrollY < 500);
            }, { passive: true });
            top.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
        }

        /* ---------- Chart.js sparkline in hero mockup ---------- */
        var spark = document.getElementById('hero-sparkline');
        if (spark && window.Chart) {
            new Chart(spark, {
                type: 'line',
                data: {
                    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    datasets: [{
                        data: [42, 55, 48, 71, 66, 89, 97],
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79,70,229,0.12)',
                        fill: true, tension: 0.45, pointRadius: 0, borderWidth: 2
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } },
                    animation: { duration: 1500 }
                }
            });
        }
    });
})();
