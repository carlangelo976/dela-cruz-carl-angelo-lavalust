<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Home</title>
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
            background: #22C55E;
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

        /* ── Parallax Section ── */
        .parallax-hero {
            position: relative;
            height: 100vh; width: 100%;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .parallax-bg {
            position: absolute; inset: -20%;
            background: url('https://picsum.photos/seed/student-campus/1920/1080.jpg') center/cover no-repeat;
            will-change: transform;
            filter: brightness(0.35) saturate(0.8);
        }
        .parallax-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, 
                rgba(10,10,10,0.4) 0%, 
                rgba(10,10,10,0.2) 40%,
                rgba(10,10,10,0.6) 100%
            );
        }
        .parallax-grid {
            position: absolute; inset: 0;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 75%);
        }

        /* ── Floating Orbs ── */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            will-change: transform;
            pointer-events: none;
        }
        .orb-1 {
            width: 400px; height: 400px;
            background: #22C55E;
            top: -10%; right: -5%;
            animation: float-orb 12s ease-in-out infinite;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: #3B82F6;
            bottom: -5%; left: -5%;
            animation: float-orb 15s ease-in-out infinite reverse;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: #A855F7;
            top: 40%; left: 50%;
            animation: float-orb 10s ease-in-out infinite 2s;
        }
        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -40px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        /* ── Glassmorphism Card ── */
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            box-shadow: 
                0 4px 30px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                inset 0 -1px 0 rgba(255, 255, 255, 0.02);
            transition: all 0.6s var(--ease-out);
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 8px 40px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.15),
                0 0 60px rgba(34, 197, 94, 0.05);
            transform: translateY(-4px);
        }

        /* ── Glass Button ── */
        .glass-btn {
            position: relative;
            display: inline-flex; align-items: center; gap: 10px;
            padding: 16px 36px;
            background: rgba(34, 197, 94, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 100px;
            color: #22C55E;
            font-family: 'Inter', sans-serif;
            font-size: 13px; font-weight: 600;
            letter-spacing: 0.08em; text-transform: uppercase;
            text-decoration: none;
            overflow: hidden;
            transition: all 0.5s var(--ease-out);
            cursor: pointer;
        }
        .glass-btn::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(34,197,94,0.3), rgba(34,197,94,0.05));
            opacity: 0;
            transition: opacity 0.5s var(--ease-out);
            border-radius: inherit;
        }
        .glass-btn:hover::before { opacity: 1; }
        .glass-btn:hover {
            border-color: rgba(34, 197, 94, 0.6);
            box-shadow: 0 0 30px rgba(34, 197, 94, 0.15);
            transform: translateY(-2px);
            color: #4ADE80;
        }
        .glass-btn .btn-arrow {
            transition: transform 0.4s var(--ease-out);
        }
        .glass-btn:hover .btn-arrow {
            transform: translateX(4px);
        }

        /* ── Status Badge ── */
        .status-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            background: rgba(34, 197, 94, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 100px;
            font-size: 10px; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: #22C55E;
        }
        .status-dot {
            width: 6px; height: 6px;
            background: #22C55E;
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        /* ── Info Cards Row ── */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        @media (max-width: 768px) {
            .info-cards { grid-template-columns: 1fr; }
        }
        .info-glass {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 28px;
            transition: all 0.5s var(--ease-out);
        }
        .info-glass:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        .info-glass .info-icon {
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 12px;
            margin-bottom: 16px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
        }
        .info-glass .info-label {
            font-size: 10px; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 6px;
        }
        .info-glass .info-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px; font-weight: 600;
            color: rgba(255,255,255,0.9);
        }

        /* ── Scroll Indicator ── */
        .scroll-indicator {
            position: absolute;
            bottom: 40px; left: 50%;
            transform: translateX(-50%);
            display: flex; flex-direction: column;
            align-items: center; gap: 8px;
            color: rgba(255,255,255,0.3);
            font-size: 10px; font-weight: 500;
            letter-spacing: 0.2em; text-transform: uppercase;
        }
        .scroll-line {
            width: 1px; height: 40px;
            background: linear-gradient(180deg, rgba(255,255,255,0.4), transparent);
            animation: scroll-pulse 2s ease-in-out infinite;
        }
        @keyframes scroll-pulse {
            0%, 100% { opacity: 1; transform: scaleY(1); }
            50% { opacity: 0.3; transform: scaleY(0.6); }
        }

        /* ── Second Parallax Section ── */
        .parallax-section-2 {
            position: relative;
            min-height: 60vh;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .parallax-bg-2 {
            position: absolute; inset: -20%;
            background: url('https://picsum.photos/seed/library-books/1920/1080.jpg') center/cover no-repeat;
            will-change: transform;
            filter: brightness(0.25) saturate(0.6);
        }
        .parallax-overlay-2 {
            position: absolute; inset: 0;
            background: linear-gradient(180deg,
                rgba(10,10,10,0.9) 0%,
                rgba(10,10,10,0.5) 50%,
                rgba(10,10,10,1) 100%
            );
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
        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
        }

        /* ── Decorative Ring ── */
        .deco-ring {
            position: absolute;
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        /* ── Footer Glass ── */
        .footer-glass {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        /* ── Custom Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--c-dark); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.25); }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader-text">Loading Portal</div>
        <div class="loader-bar-track">
            <div class="loader-bar" id="loaderBar"></div>
        </div>
    </div>

    <!-- Noise -->
    <div class="noise"></div>

    <!-- ════════════════════════════════════════ -->
    <!-- HERO PARALLAX SECTION                     -->
    <!-- ════════════════════════════════════════ -->
    <section class="parallax-hero">
        <!-- Parallax Background -->
        <div class="parallax-bg" id="parallaxBg1"></div>
        <div class="parallax-overlay"></div>
        <div class="parallax-grid"></div>

        <!-- Floating Orbs -->
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <!-- Decorative Rings -->
        <div class="deco-ring" style="width:600px;height:600px;top:50%;left:50%;transform:translate(-50%,-50%);"></div>
        <div class="deco-ring" style="width:800px;height:800px;top:50%;left:50%;transform:translate(-50%,-50%);"></div>

        <!-- Main Glass Card — ORIGINAL CONTENT INSIDE -->
        <div class="glass-card reveal-scale" style="max-width: 580px; width: 90%; padding: 56px 48px; position: relative; z-index: 10;">
            
            <!-- Status Badge -->
            <div class="status-badge" style="margin-bottom: 32px;">
                <span class="status-dot"></span>
                Active Student
            </div>

            <!-- ORIGINAL H1 -->
            <h1 style="
                font-family: 'Space Grotesk', sans-serif;
                font-size: clamp(36px, 5vw, 52px);
                font-weight: 600;
                line-height: 1.05;
                letter-spacing: -0.04em;
                color: rgba(255,255,255,0.95);
                margin-bottom: 20px;
            ">Student Home</h1>

            <!-- ORIGINAL P -->
            <p style="
                font-family: 'Inter', sans-serif;
                font-size: 16px;
                font-weight: 300;
                line-height: 1.7;
                color: rgba(255,255,255,0.5);
                margin-bottom: 40px;
            ">Welcome to my Student Information Page.</p>

            <!-- ORIGINAL A LINK — styled as glass button -->
            <a href="<?= site_url('student/profile') ?>" class="glass-btn">
                <span style="position:relative;z-index:1;">View Student Profile</span>
                <span class="btn-arrow" style="position:relative;z-index:1;">
                    <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
                </span>
            </a>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ════════════════════════════════════════ -->
    <!-- INFO CARDS SECTION                        -->
    <!-- ════════════════════════════════════════ -->
    <section style="padding: 120px 24px; position: relative; background: var(--c-dark);">
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <!-- Section Label -->
            <div class="reveal-up" style="margin-bottom: 48px;">
                <span style="
                    font-size: 10px; font-weight: 600;
                    letter-spacing: 0.2em; text-transform: uppercase;
                    color: rgba(255,255,255,0.3);
                    display: block; margin-bottom: 16px;
                ">Quick Overview</span>
                <h2 style="
                    font-family: 'Space Grotesk', sans-serif;
                    font-size: clamp(28px, 4vw, 42px);
                    font-weight: 600;
                    line-height: 1.1;
                    letter-spacing: -0.03em;
                    color: rgba(255,255,255,0.9);
                ">Your Dashboard<br>at a Glance</h2>
            </div>

            <!-- Info Cards Grid -->
            <div class="info-cards">
                <div class="info-glass reveal-up" style="transition-delay: 0s;">
                    <div class="info-icon">
                        <i data-lucide="book-open" style="width:20px;height:20px;color:rgba(255,255,255,0.5);"></i>
                    </div>
                    <div class="info-label">Enrolled Courses</div>
                    <div class="info-value">6 Active</div>
                </div>
                <div class="info-glass reveal-up" style="transition-delay: 0.1s;">
                    <div class="info-icon">
                        <i data-lucide="calendar-check" style="width:20px;height:20px;color:rgba(255,255,255,0.5);"></i>
                    </div>
                    <div class="info-label">Attendance</div>
                    <div class="info-value">94.2%</div>
                </div>
                <div class="info-glass reveal-up" style="transition-delay: 0.2s;">
                    <div class="info-icon">
                        <i data-lucide="trophy" style="width:20px;height:20px;color:rgba(255,255,255,0.5);"></i>
                    </div>
                    <div class="info-label">GPA</div>
                    <div class="info-value">3.78</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════ -->
    <!-- SECOND PARALLAX SECTION                   -->
    <!-- ════════════════════════════════════════ -->
    <section class="parallax-section-2">
        <div class="parallax-bg-2" id="parallaxBg2"></div>
        <div class="parallax-overlay-2"></div>

        <div style="position: relative; z-index: 10; max-width: 1000px; width: 90%; padding: 80px 0;">
            <div class="glass-card reveal-up" style="padding: 48px; display: flex; align-items: center; gap: 32px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <span style="
                        font-size: 10px; font-weight: 600;
                        letter-spacing: 0.2em; text-transform: uppercase;
                        color: rgba(255,255,255,0.3);
                        display: block; margin-bottom: 12px;
                    ">Quick Access</span>
                    <h3 style="
                        font-family: 'Space Grotesk', sans-serif;
                        font-size: 24px; font-weight: 600;
                        line-height: 1.2;
                        letter-spacing: -0.02em;
                        color: rgba(255,255,255,0.9);
                        margin-bottom: 12px;
                    ">Need to check your full profile details?</h3>
                    <p style="
                        font-size: 14px; font-weight: 300;
                        line-height: 1.6;
                        color: rgba(255,255,255,0.4);
                    ">Access your personal information, academic records, and more from your dedicated profile page.</p>
                </div>
                <div style="flex-shrink: 0;">
                    <a href="<?= site_url('student/profile') ?>" class="glass-btn">
                        <span style="position:relative;z-index:1;">Go to Profile</span>
                        <span class="btn-arrow" style="position:relative;z-index:1;">
                            <i data-lucide="external-link" style="width:15px;height:15px;"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════════════════════════════════ -->
    <!-- FOOTER                                    -->
    <!-- ════════════════════════════════════════ -->
    <footer class="footer-glass" style="padding: 40px 24px;">
        <div style="max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <span style="
                font-family: 'Space Grotesk', sans-serif;
                font-size: 13px; font-weight: 500;
                color: rgba(255,255,255,0.25);
                letter-spacing: -0.01em;
            ">Student Portal</span>
            <span style="
                font-size: 11px; font-weight: 400;
                color: rgba(255,255,255,0.15);
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

        // Sync Lenis with GSAP ScrollTrigger
        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add((time) => lenis.raf(time * 1000));
        gsap.ticker.lagSmoothing(0);

        // ── Preloader ──
        const tl = gsap.timeline();
        tl.to('#loaderBar', {
            width: '100%',
            duration: 1.2,
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

        // ── Main Animations ──
        function initAnimations() {
            gsap.registerPlugin(ScrollTrigger);

            // Reveal animations
            gsap.utils.toArray('.reveal-up').forEach((el) => {
                gsap.to(el, {
                    y: 0, opacity: 1,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                        toggleActions: 'play none none none',
                    }
                });
            });

            gsap.utils.toArray('.reveal-scale').forEach((el) => {
                gsap.to(el, {
                    scale: 1, opacity: 1,
                    duration: 1.2,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 85%',
                        toggleActions: 'play none none none',
                    }
                });
            });

            gsap.utils.toArray('.reveal-left').forEach((el) => {
                gsap.to(el, {
                    x: 0, opacity: 1,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                        toggleActions: 'play none none none',
                    }
                });
            });

            // ── Parallax 1 (Hero BG) ──
            gsap.to('#parallaxBg1', {
                yPercent: 20,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });

            // ── Parallax 2 (Second Section BG) ──
            gsap.to('#parallaxBg2', {
                yPercent: 15,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-section-2',
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                }
            });

            // ── Orbs Parallax ──
            gsap.to('.orb-1', {
                yPercent: -30,
                xPercent: 10,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });
            gsap.to('.orb-2', {
                yPercent: -15,
                xPercent: -8,
                ease: 'none',
                scrollTrigger: {
                    trigger: '.parallax-hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true,
                }
            });

            // ── Decorative Rings Parallax ──
            gsap.utils.toArray('.deco-ring').forEach((ring, i) => {
                gsap.to(ring, {
                    yPercent: -(10 + i * 8),
                    rotation: i % 2 === 0 ? 15 : -15,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '.parallax-hero',
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