<?php /* Custom development page — matches homepage design system */ ?>
<!-- Hero -->
<section class="relative overflow-hidden bg-navy pb-20 pt-28 text-white">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-primary/30 blur-[120px]"></div>
        <div class="absolute bottom-0 right-0 h-[340px] w-[340px] rounded-full bg-violet/25 blur-[110px]"></div>
        <div class="absolute inset-0 opacity-[0.06]"
             style="background-image:linear-gradient(to right,#fff 1px,transparent 1px),linear-gradient(to bottom,#fff 1px,transparent 1px);background-size:44px 44px;"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-5 text-center lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-primary-200 backdrop-blur">
            <i class="fa-solid fa-code"></i> Custom software, built for you
        </span>
        <h1 class="mt-6 font-display text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
            <?= esc(setting('customdev_heading', 'Custom software development')) ?>
        </h1>
        <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-slate-300">
            <?= esc(setting('customdev_sub', 'Off-the-shelf does not fit every business. We design and build tailored web, desktop and mobile solutions around your exact workflow.')) ?>
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="#quote" class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-violet px-7 py-4 text-base font-bold text-white shadow-glow transition hover:-translate-y-0.5">
                Get a free quote <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="<?= site_url_path('/products') ?>" class="inline-flex items-center gap-2 rounded-2xl border border-white/20 bg-white/5 px-6 py-4 text-base font-semibold text-white backdrop-blur transition hover:bg-white/10">
                Browse ready-made products
            </a>
        </div>
    </div>
</section>

<!-- Services -->
<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">What we build</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Development services</h2>
            <p class="mt-4 text-slate-500">From concept to deployment — robust software that drives your business forward.</p>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-3">
            <?php
            $services = [
                ['icon' => 'fa-solid fa-display', 'title' => 'Web application development',
                 'desc' => 'Custom web apps with modern stacks — CodeIgniter, Laravel, React and Vue.',
                 'points' => ['Responsive design', 'API integration', 'Real-time features']],
                ['icon' => 'fa-solid fa-laptop-code', 'title' => 'Desktop application development',
                 'desc' => 'Powerful Windows applications with offline capability and hardware integration.',
                 'points' => ['Offline functionality', 'Hardware integration', 'Database management']],
                ['icon' => 'fa-solid fa-cart-shopping', 'title' => 'E-commerce solutions',
                 'desc' => 'Complete online stores with payments, inventory and order processing.',
                 'points' => ['Payment gateways', 'Inventory management', 'Multi-vendor support']],
            ];
            foreach ($services as $si => $s): ?>
                <div class="group relative overflow-hidden rounded-3xl border border-slate-100 bg-gradient-to-b from-slate-50 to-white p-8 transition hover:-translate-y-2 hover:shadow-glow"
                     data-aos="fade-up" data-aos-delay="<?= $si * 120 ?>">
                    <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-gradient-to-br from-primary/10 to-violet/10 blur-2xl"></div>
                    <span class="relative grid h-14 w-14 place-items-center rounded-2xl bg-gradient-to-br from-primary to-violet text-xl text-white shadow-soft">
                        <i class="<?= $s['icon'] ?>"></i>
                    </span>
                    <h3 class="relative mt-6 font-display text-xl font-bold text-slate-900"><?= esc($s['title']) ?></h3>
                    <p class="relative mt-3 text-sm leading-7 text-slate-500"><?= esc($s['desc']) ?></p>
                    <ul class="relative mt-5 space-y-2">
                        <?php foreach ($s['points'] as $pt): ?>
                            <li class="flex items-center gap-2.5 text-sm text-slate-600">
                                <i class="fa-solid fa-circle-check text-xs text-accent"></i> <?= esc($pt) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Process -->
<section class="bg-navy py-24 text-white">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-emerald-400">How we work</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Our development process</h2>
            <p class="mt-4 text-slate-400">A structured approach that keeps your project on time and on budget.</p>
        </div>

        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <?php
            $steps = [
                ['fa-solid fa-magnifying-glass-chart', 'Discovery & planning', 'We analyze your requirements and create a detailed project roadmap.'],
                ['fa-solid fa-pen-ruler', 'Design & prototyping', 'Wireframes and interactive prototypes for your approval before a line of code.'],
                ['fa-solid fa-code', 'Development & testing', 'Agile sprints with regular demos, testing and quality assurance.'],
                ['fa-solid fa-rocket', 'Deployment & support', 'Smooth launch, training for your team, and ongoing maintenance.'],
            ];
            foreach ($steps as $i => [$icon, $title, $desc]): ?>
                <div class="relative text-center" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <div class="relative mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-white/[0.06] ring-1 ring-white/10">
                        <i class="<?= $icon ?> text-2xl text-primary-300"></i>
                        <span class="absolute -right-2 -top-2 grid h-7 w-7 place-items-center rounded-full bg-gradient-to-br from-primary to-violet text-xs font-extrabold shadow-soft"><?= $i + 1 ?></span>
                    </div>
                    <h3 class="mt-5 font-display text-lg font-bold"><?= esc($title) ?></h3>
                    <p class="mt-2 text-sm leading-6 text-slate-400"><?= esc($desc) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Tech stack -->
<section class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">
        <div class="mx-auto max-w-2xl text-center" data-aos="fade-up">
            <p class="text-sm font-bold uppercase tracking-widest text-primary">Tech stack</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Technologies we master</h2>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            <?php
            $stack = [
                ['fa-solid fa-fire', 'CodeIgniter', 'text-red-500'],
                ['fa-brands fa-laravel', 'Laravel', 'text-red-600'],
                ['fa-solid fa-database', 'MySQL', 'text-primary'],
                ['fa-brands fa-react', 'React', 'text-sky-500'],
                ['fa-brands fa-vuejs', 'Vue.js', 'text-emerald-500'],
                ['fa-brands fa-php', 'PHP', 'text-indigo-400'],
            ];
            foreach ($stack as $si => [$icon, $name, $color]): ?>
                <div class="group flex flex-col items-center gap-3 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1.5 hover:border-primary-200 hover:shadow-soft"
                     data-aos="zoom-in" data-aos-delay="<?= $si * 60 ?>">
                    <i class="<?= $icon ?> text-3xl <?= $color ?> transition group-hover:scale-110"></i>
                    <span class="text-xs font-bold text-slate-700"><?= esc($name) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Quote form -->
<section class="relative overflow-hidden bg-gradient-to-br from-primary via-violet to-primary-700 py-24 text-white" id="quote">
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]" aria-hidden="true"
         style="background-image:radial-gradient(#fff 1px,transparent 1px);background-size:26px 26px;"></div>
    <div class="relative mx-auto max-w-3xl px-5 lg:px-8">
        <div class="text-center">
            <h2 class="font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Ready to start your project?</h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-primary-100">Tell us what you need — we'll reply with a free quote within 24 hours.</p>
        </div>

        <?php if ($msg = session()->getFlashdata('success')): ?>
            <div data-flash class="mt-8 rounded-2xl border border-emerald-300/40 bg-emerald-400/15 px-5 py-4 text-sm font-medium text-emerald-50">
                <i class="fa-solid fa-circle-check mr-2"></i><?= esc($msg) ?>
            </div>
        <?php endif; ?>
        <?php if ($msg = session()->getFlashdata('error')): ?>
            <div data-flash class="mt-8 rounded-2xl border border-red-300/40 bg-red-500/15 px-5 py-4 text-sm font-medium text-red-50">
                <i class="fa-solid fa-circle-exclamation mr-2"></i><?= esc($msg) ?>
            </div>
        <?php endif; ?>
        <?php if ($errs = session()->getFlashdata('errors')): ?>
            <div data-flash class="mt-8 rounded-2xl border border-red-300/40 bg-red-500/15 px-5 py-4 text-sm text-red-50">
                <?php foreach ((array) $errs as $e): ?><p><?= esc($e) ?></p><?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('custom-development/quote') ?>" class="mt-10 space-y-5 rounded-3xl border border-white/20 bg-white/10 p-8 shadow-xl backdrop-blur">
            <?= csrf_field() ?>
            <input type="hidden" name="form_started_at" value="<?= time() ?>">
            <div style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <input type="text" name="name" required placeholder="Full name" value="<?= esc(old('name')) ?>"
                       class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                <input type="text" name="company" placeholder="Company name" value="<?= esc(old('company')) ?>"
                       class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                <input type="email" name="email" required placeholder="Email address" value="<?= esc(old('email')) ?>"
                       class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                <input type="tel" name="phone" placeholder="Phone / WhatsApp" value="<?= esc(old('phone')) ?>"
                       class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
            </div>

            <select name="project_type" required
                    class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                <option value="">Select project type…</option>
                <?php foreach (['web-app' => 'Web application', 'desktop-app' => 'Desktop application', 'ecommerce' => 'E-commerce website', 'mobile-app' => 'Mobile application', 'custom-software' => 'Custom software', 'other' => 'Other'] as $v => $label): ?>
                    <option value="<?= $v ?>" <?= old('project_type') === $v ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>

            <div class="grid gap-5 sm:grid-cols-2">
                <select name="budget"
                        class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                    <option value="">Budget range (optional)…</option>
                    <?php foreach (['under-100k' => 'Under PKR 100k', '100k-500k' => 'PKR 100k – 500k', '500k-2m' => 'PKR 500k – 2M', '2m-plus' => 'PKR 2M+'] as $v => $label): ?>
                        <option value="<?= $v ?>" <?= old('budget') === $v ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="timeline"
                        class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40">
                    <option value="">Timeline (optional)…</option>
                    <?php foreach (['urgent' => 'ASAP / urgent', '1-3-months' => '1–3 months', '3-6-months' => '3–6 months', 'flexible' => 'Flexible'] as $v => $label): ?>
                        <option value="<?= $v ?>" <?= old('timeline') === $v ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <textarea name="description" rows="4" required placeholder="Tell us about your project — goals, users, must-have features…"
                      class="w-full rounded-xl border border-white/25 bg-white/90 px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-white focus:outline-none focus:ring-2 focus:ring-white/40"><?= esc(old('description')) ?></textarea>

            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-base font-bold text-primary shadow-xl transition hover:-translate-y-0.5 hover:shadow-2xl">
                Get my free quote <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>
</section>
