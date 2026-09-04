<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/@studio-freight/lenis@1.0.33/dist/lenis.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Space Grotesk', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --c-bg: #F5F5F7;
            --c-card: #FFFFFF;
            --c-dark: #0A0A0A;
            --c-border: rgba(0,0,0,0.08);
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { font-family: 'Inter', sans-serif; background: var(--c-dark); }
        body { background: var(--c-dark); overflow-x: hidden; }

        /* ── Preloader ── */
        .preloader {
            position: fixed; inset: 0; z-index: 9999;
            background: var(--c-dark);
            display: flex; align-items: center; justify-content: center;
            flex-direction: column; gap: 24px;
            clip-path: inset(0 0 0% 0);
        }
        .loader-bar-track {
            width: 200px; height: 2px;
            background: rgba(255,255,255,0.1);
            border-radius: 2px; overflow: hidden;
        }
        .loader-bar {
            width: 0%; height: 100%;
            background: #3B82F6;
            border-radius: 2px;
        }
        .loader-text {
            font-family: 'Space Grotesk', sans-serif;
            color: rgba(255,255,255,0.6);
            font-size: 11px; font-weight: 500;
            letter-spacing: 0.2em; text-transform: uppercase;
        }

        /* ── Noise Overlay ── */
        .noise {
            position: fixed; inset: 0; z-index: 9998;
            pointer-events: none; opacity: 0.03;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        }

        /* ── Parallax Header ── */
        .parallax-header {
            position: relative;
            height: 50vh; min-height: 360px;
            display: flex; align-items: flex-end; justify-content: center;
            overflow: hidden;
        }
        .parallax-bg {
            position: absolute; inset: -20%;
            background: url('https://picsum.photos/seed/tech-users-network/1920/1080.jpg') center/cover no-repeat;
            will-change: transform;
            filter: brightness(0.3) saturate(0.7);
        }
        .parallax-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg,
                rgba(10,10,10,0.3) 0%,
                rgba(10,10,10,0.4) 60%,
                rgba(10,10,10,1) 100%
            );
        }
        .parallax-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
        }

        /* ── Floating Orbs ── */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            will-change: transform;
            pointer-events: none;
        }
        .orb-1 {
            width: 350px; height: 350px;
            background: #3B82F6;
            top: -15%; left: -5%;
            animation: float-orb 14s ease-in-out infinite;
        }
        .orb-2 {
            width: 280px; height: 280px;
            background: #8B5CF6;
            bottom: -10%; right: -3%;
            animation: float-orb 11s ease-in-out infinite reverse;
        }
        .orb-3 {
            width: 180px; height: 180px;
            background: #06B6D4;
            top: 30%; right: 30%;
            animation: float-orb 9s ease-in-out infinite 3s;
        }
        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(25px, -35px) scale(1.08); }
            66% { transform: translate(-18px, 15px) scale(0.94); }
        }

        /* ── Glassmorphism Card ── */
        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow:
                0 4px 30px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.08),
                inset 0 -1px 0 rgba(255, 255, 255, 0.02);
            transition: all 0.6s var(--ease-out);
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(255, 255, 255, 0.18);
            box-shadow:
                0 8px 40px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.12),
                0 0 60px rgba(59, 130, 246, 0.06);
        }

        /* ── Glass Button ── */
        .glass-btn {
            position: relative;
            display: inline-flex; align-items: center; gap: 10px;
            padding: 14px 32px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 100px;
            color: rgba(255,255,255,0.8);
            font-family: 'Inter', sans-serif;
            font-size: 12px; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            text-decoration: none;
            overflow: hidden;
            transition: all 0.5s var(--ease-out);
            cursor: pointer;
        }
        .glass-btn::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.02));
            opacity: 0;
            transition: opacity 0.5s var(--ease-out);
            border-radius: inherit;
        }
        .glass-btn:hover::before { opacity: 1; }
        .glass-btn:hover {
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
            color: rgba(255,255,255,1);
        }
        .glass-btn .btn-arrow {
            transition: transform 0.4s var(--ease-out);
        }
        .glass-btn:hover .btn-arrow {
            transform: translateX(-4px);
        }

        /* ── Glass Table ── */
        .glass-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            position: relative;
            z-index: 1;
        }
        .glass-table th {
            padding: 24px 32px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.02);
        }
        .glass-table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.04);
            transition: all 0.4s var(--ease-out);
        }
        .glass-table tbody tr:last-child {
            border-bottom: none;
        }
        .glass-table tbody tr:hover {
            background: rgba(255,255,255,0.04);
        }
        .glass-table tbody tr:hover td:first-child {
            padding-left: 40px;
            color: #60A5FA;
        }
        .glass-table td {
            padding: 20px 32px;
            font-size: 15px;
            font-weight: 400;
            color: rgba(255,255,255,0.75);
            transition: all 0.4s var(--ease-out);
        }
        .glass-table td:first-child {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 500;
            color: rgba(255,255,255,0.9);
        }
        .glass-table td:last-child {
            font-weight: 500;
            color: #60A5FA;
        }

        /* ── Back Link Floating ── */
        .back-float {
            position: fixed;
            top: 28px; left: 28px;
            z-index: 100;
            display: flex; align-items: center; gap: 8px;
            padding: 10px 20px;
            background: rgba(10,10,10,0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 100px;
            color: rgba(255,255,255,0.5);
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.1em; text-transform: uppercase;
            text-decoration: none;
            transition: all 0.4s var(--ease-out);
        }
        .back-float:hover {
            color: rgba(255,255,255,0.9);
            border-color: rgba(255,255,255,0.2);
            background: rgba(10,10,10,0.8);
        }
        .back-float .back-arrow {
            transition: transform 0.4s var(--ease-out);
        }
        .back-float:hover .back-arrow {
            transform: translateX(-3px);
        }

        /* ── Decorative Ring ── */
        .deco-ring {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.04);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ── Reveal Animations ── */
        .reveal-up {
            opacity: 0;
            transform: translateY(60px);
        }
        .reveal-scale {
            opacity: 0;
            transform: scale(0.92);
        }

        /* ── Status Tag ── */
        .status-tag {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 100px;
            font-size: 9px; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: #60A5FA;
        }
        .status-dot {
            width: 5px; height: 5px;
            background: #3B82F6;
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.7); }
        }

        /* ── Footer Glass ── */
        .footer-glass {
            background: rgba(255,255,255,0.02);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* ── Custom Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--c-dark); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.22); }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .glass-table, .glass-table thead, .glass-table tbody, .glass-table th, .glass-table td, .glass-table tr {
                display: block;
            }
            .glass-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            .glass-table tbody tr {
                border: 1px solid rgba(255,255,255,0.06);
                border-radius: 16px;
                margin-bottom: 16px;
                padding: 16px;
                background: rgba(255,255,255,0.02);
            }
            .glass-table tbody tr:hover {
                transform: none;
                background: rgba(255,255,255,0.05);
            }
            .glass-table tbody tr:hover td:first-child {
                padding-left: 32px;
            }
            .glass-table td {
                border: none;
                position: relative;
                padding: 8px 32px 8px 40%;
                text-align: right;
            }
            .glass-table td:first-child {
                padding-top: 0;
            }
            .glass-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 32px;
                font-size: 10px;
                font-weight: 600;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: rgba(255,255,255,0.4);
                text-align: left;
            }
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader-text">Loading Directory</div>
        <div class="loader-bar-track">
            <div class="loader-bar" id="loaderBar"></div>
        </div>
    </div>

    <!-- Noise -->
    <div class="noise"></div>

    <!-- Fixed Back Button -->
    <a href="<?= site_url('/') ?>" class="back-float" id="backBtn">
        <span class="back-arrow">
            <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
        </span>
        Back to Dashboard
    </a>

    <!-- ════════════════════════════════════════ -->
    <!-- PARALLAX HEADER                          -->
    <!-- ════════════════════════════════════════ -->
    <section class="parallax-header">
        <div class="parallax-bg" id="parallaxBg"></div>
        <div class="parallax-overlay"></div>
        <div class="parallax-grid"></div>

        <!-- Floating Orbs -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <!-- Decorative Rings -->
        <div class="deco-ring" style="width:500px;height:500px;bottom:-30%;left:-10%;"></div>
        <div class="deco-ring" style="width:700px;height:700px;bottom:-45%;left:-18%;"></div>

        <!-- Header Content -->
        <div style="position:relative;z-index:10;width:90%;max-width:800px;padding-bottom:48px;">
            <div class="reveal-up">
                <div class="status-tag" style="margin-bottom:20px;">
                    <span class="status-dot"></span>
                    System Active
                </div>
                <h1 style="
                    font-family: 'Space Grotesk', sans-serif;
                    font-size: clamp(32px, 5vw, 48px);
                    font-weight: 600;
                    line-height: 1.05;
                    letter-spacing: -0.04em;
                    color: rgba(255,255,255,0.95);
                    margin-bottom: 8px;
                ">Users Directory</h1>
                <p style="
                    font-size: 14px; font-weight: 300;
                    color: rgba(255,255,255,0.35);
                    letter-spacing: 0.02em;
                ">Complete registry of platform users</p>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════ -->
    <!-- USERS TABLE SECTION                      -->
    <!-- ════════════════════════════════════════ -->
    <section style="padding: 0 24px 80px; position: relative; margin-top: -40px; z-index: 20;">
        <div style="max-width: 1000px; margin: 0 auto;">

            <!-- Main Glass Card containing Table -->
            <div class="glass-card reveal-scale" style="padding: 0; overflow: hidden; position: relative;">

                <!-- Subtle corner glows -->
                <div style="
                    position: absolute; top: -60px; right: -60px;
                    width: 200px; height: 200px;
                    background: radial-gradient(circle, rgba(59,130,246,0.12), transparent 70%);
                    pointer-events: none; z-index: 0;
                "></div>
                <div style="
                    position: absolute; bottom: -40px; left: -40px;
                    width: 160px; height: 160px;
                    background: radial-gradient(circle, rgba(139,92,246,0.08), transparent 70%);
                    pointer-events: none; z-index: 0;
                "></div>

                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i data-lucide="hash" style="width:14px; height:14px; opacity:0.6;"></i>
                                    ID
                                </div>
                            </th>
                            <th>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i data-lucide="user" style="width:14px; height:14px; opacity:0.6;"></i>
                                    First Name
                                </div>
                            </th>
                            <th>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i data-lucide="user" style="width:14px; height:14px; opacity:0.6;"></i>
                                    Last Name
                                </div>
                            </th>
                            <th>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i data-lucide="mail" style="width:14px; height:14px; opacity:0.6;"></i>
                                    Email
                                </div>
                            </th>
                            <th>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <i data-lucide="at-sign" style="width:14px; height:14px; opacity:0.6;"></i>
                                    Username
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <tr class="reveal-up" style="transition-delay: <?= $index * 0.05 ?>s;">
                                <td data-label="ID"><?= htmlspecialchars($user['id']) ?></td>
                                <td data-label="First Name"><?= htmlspecialchars($user['firstname']) ?></td>
                                <td data-label="Last Name"><?= htmlspecialchars($user['lastname']) ?></td>
                                <td data-label="Email"><?= htmlspecialchars($user['email']) ?></td>
                                <td data-label="Username"><?= htmlspecialchars($user['username']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bottom Action Button -->
            <div style="text-align:center; margin-top:40px;" class="reveal-up">
                <a href="<?= site_url('/') ?>" class="glass-btn">
                    <span class="btn-arrow">
                        <i data-lucide="arrow-left" style="width:15px;height:15px;"></i>
                    </span>
                    <span style="position:relative;z-index:1;">Back to Dashboard</span>
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════════════════════════════ -->
    <!-- FOOTER                                    -->
    <!-- ════════════════════════════════════════ -->
    <footer class="footer-glass" style="padding: 32px 24px;">
        <div style="max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <span style="
                font-family: 'Space Grotesk', sans-serif;
                font-size: 12px; font-weight: 500;
                color: rgba(255,255,255,0.2);
                letter-spacing: -0.01em;
            ">Users Directory</span>
            <span style="
                font-size: 10px; font-weight: 400;
                color: rgba(255,255,255,0.12);
            ">&copy; <?= date('Y') ?> All rights reserved.</span>
        </div>
    </footer>

    <!-- ════════════════════════════════════════ -->
    <!-- SCRIPTS                                   -->
    <!-- ════════════════════════════════════════ -->
    <script>
        // ── Initialize Lucide Icons ──
        lucide.createIcons();

        // ── Lenis Smooth Scroll ──
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            smooth: true,
        });
        function raf(time) {
            lenis.raf(time);
            requestAnimationFrame(raf);
        }
        requestAnimationFrame(raf);
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add((time) => lenis.raf(time * 1000));
        gsap.ticker.lagSmoothing(0);

        // ── Preloader ──
        const tl = gsap.timeline();
        tl.to('#loaderBar', {
            width: '100%',
            duration: 1.0,
            ease: 'power2.inOut',
        })
        .to('.loader-text', {
            y: -20, opacity: 0,
            duration: 0.4,
            ease: 'power2.in',
        }, '-=0.3')
        .to('#preloader', {
            clipPath: 'inset(0 0 100% 0)',
            duration: 0.8,
            ease: 'power4.inOut',
            onComplete: () => {
                document.getElementById('preloader').style.display = 'none';
                initAnimations();
            }
        }, '-=0.1');

        // ── Back Button appears after preloader ──
        gsap.set('#backBtn', { opacity: 0, y: -10 });

        function initAnimations() {
            gsap.registerPlugin(ScrollTrigger);

            // Show back button
            gsap.to('#backBtn', {
                opacity: 1, y: 0,
                duration: 0.6,
                ease: 'power3.out',
                delay: 0.3,
            });

            // Reveal Up (Staggered for table rows automatically via inline style delay)
            gsap.utils.toArray('.reveal-up').forEach((el) => {
                gsap.to(el, {
                    y: 0, opacity: 1,
                    duration: 0.9,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 90%',
                        toggleActions: 'play none none none',
                    }
                });
            });

            // Reveal Scale
            gsap.utils.toArray('.reveal-scale').forEach((el) => {
                gsap.to(el, {
                    scale: 1, opacity: 1,
                    duration: 1.1,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                        toggleActions: 'play none none none',
                    }
                });
            });

            // ── Parallax Background ──
            gsap.to('#parallaxBg', {
                yPercent: 25,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-header',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });

            // ── Orbs Parallax ──
            gsap.to('.orb-1', {
                yPercent: -25, xPercent: 8,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-header',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });
            gsap.to('.orb-2', {
                yPercent: -12, xPercent: -6,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-header',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });
            gsap.to('.orb-3', {
                yPercent: -20, xPercent: 5,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-header',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });

            // ── Decorative Rings ──
            gsap.utils.toArray('.deco-ring').forEach((ring, i) => {
                gsap.to(ring, {
                    yPercent: -(8 + i * 6),
                    rotation: i % 2 === 0 ? 10 : -10,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '.parallax-header',
                        start: 'top top',
                        end: 'bottom top',
                        scrub: true,
                    }
                });
            });
        }
    </script>

</body>
</html>