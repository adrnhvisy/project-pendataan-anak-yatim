<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Anak Yatim Terpadu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accent: { DEFAULT: '#004ac6', soft: '#eaf1ff', deep: '#00338d' },
                        ink: { DEFAULT: '#15181C', soft: '#4A5057', faint: '#8A9099' },
                        paper: { DEFAULT: '#F7F6F3', raised: '#FFFFFF' },
                        line: '#E4E1D9',
                    },
                    fontFamily: {
                        sans: ['-apple-system', 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 1px 2px rgba(21,24,28,0.04), 0 12px 32px rgba(21,24,28,0.06)',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --ink: #15181C;
            --ink-soft: #4A5057;
            --ink-faint: #8A9099;
            --paper: #F7F6F3;
            --paper-raised: #FFFFFF;
            --line: #E4E1D9;
            --accent: #004ac6;
            --accent-soft: #E5EEE9;
            --accent-deep: #00338d;
            --wrap: 1120px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background: var(--paper);
            color: var(--ink);
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        .wrap {
            max-width: var(--wrap);
            margin: 0 auto;
            padding: 0 24px;
        }

        header.navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(247, 246, 243, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 1px 2px rgba(0, 74, 198, 0.15), 0 6px 16px rgba(0, 74, 198, 0.18);
            transition: transform .15s ease, box-shadow .15s ease, background .15s ease;
        }

        .btn-primary:hover {
            background: var(--accent-deep);
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 74, 198, 0.25), 0 12px 28px rgba(0, 74, 198, 0.22);
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.97);
        }

        section.hero {
            padding: 72px 0 64px;
            border-bottom: 1px solid var(--line);
            background: radial-gradient(60% 55% at 82% 12%, rgba(0, 74, 198, 0.08), transparent 60%), var(--paper);
        }

        .hero-inner {
            display: grid;
            grid-template-columns: 1fr;
            gap: 44px;
            align-items: center;
        }

        h1 {
            font-size: 34px;
            line-height: 1.15;
            letter-spacing: -0.02em;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .highlight {
            color: var(--accent);
        }

        .hero-sub {
            font-size: 16px;
            color: var(--ink-soft);
            margin-bottom: 28px;
        }

        .hero-cta-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .feature-icon-wrap {
            transition: transform .3s ease, background-color .3s ease;
        }

        /* scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* mobile menu */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
        }

        #mobile-menu.open {
            max-height: 240px;
        }

        /* count-up number nudge */
        .stat-number {
            font-variant-numeric: tabular-nums;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 48px;
            }

            .hero-sub {
                font-size: 17.5px;
                max-width: 480px;
            }

            .hero-inner {
                grid-template-columns: 1.05fr 0.95fr;
                gap: 56px;
            }

            section.hero {
                padding: 96px 0 72px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }
        }
    </style>
</head>

<body>

    <!-- ========== NAVBAR ========== -->
    <header class="navbar">
        <div class="wrap navbar-inner">
            <div class="flex items-center gap-2.5 font-bold text-base sm:text-lg tracking-tight text-ink">
                <div
                    class="w-9 h-9 sm:w-10 sm:h-10 bg-accent rounded-xl flex items-center justify-center text-white shadow-md shadow-accent/20 overflow-hidden shrink-0">
                    @if(get_setting('logo_web'))
                        <img src="{{ asset('storage/' . get_setting('logo_web')) }}" alt="Logo"
                            class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    @endif
                </div>
                <span class="leading-tight">
                    {{ get_setting('nama_aplikasi', 'SAHABAT') }}
                    <span
                        class="text-accent hidden sm:inline">{{ get_setting('nama_panjang_aplikasi', 'Sistem Hibah Yatim') }}</span>
                </span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <span class="hidden sm:inline">Masuk ke Sistem</span>
                    <span class="sm:hidden">Masuk</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- ========== MAIN ========== -->
    <main>
        <section class="hero relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-72 h-72 sm:w-96 sm:h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute top-1/2 -left-20 w-56 h-56 sm:w-72 sm:h-72 bg-accent/5 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="wrap hero-inner relative">

                <!-- BAGIAN KIRI -->
                <div class="hero-copy reveal">
                    <span
                        class="inline-flex items-center gap-2 text-xs font-semibold text-accent-deep bg-accent-soft px-3 py-1.5 rounded-full mb-6 border border-accent/20">
                        <span class="relative flex w-1.5 h-1.5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full w-1.5 h-1.5 bg-accent"></span>
                        </span>
                        Sistem terverifikasi dan aman
                    </span>

                    <h1>Pendataan yang <span class="highlight">akurat</span> untuk kesejahteraan anak yatim.</h1>
                    <p class="hero-sub">
                        Sistem terpusat untuk mendata, memverifikasi, dan mengelola bantuan bagi anak yatim secara
                        transparan dan aman.
                    </p>

                    <div class="hero-cta-row">
                        <a href="{{ route('login') }}" class="btn btn-primary">Mulai Kelola Data</a>
                        <a href="#fitur"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-ink-soft hover:text-accent-deep transition-colors">
                            Lihat fitur
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-6 gap-y-3 mt-10 pt-6 border-t border-line">
                        <div class="flex items-center gap-2 text-accent-deep">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs text-ink-soft font-medium">Data terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-2 text-accent-deep">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs text-ink-soft font-medium">Sinkron waktu nyata</span>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN KANAN: Kartu Ringkasan Data -->
                <div class="reveal" style="transition-delay:.1s">
                    <div class="relative max-w-md mx-auto md:mx-0">

                        <div
                            class="bg-paper-raised border border-line rounded-2xl shadow-soft p-5 sm:p-6 relative z-10">
                            <div class="flex items-center justify-between mb-5">
                                <span class="text-xs font-semibold text-ink-faint uppercase tracking-wide">Ringkasan
                                    data</span>
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full bg-accent-soft text-accent-deep font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                                    Live
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div
                                    class="flex items-center gap-3 p-3 rounded-xl bg-paper border border-line hover:border-accent/40 hover:-translate-y-0.5 transition-all duration-200">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-accent-soft flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4.5 h-4.5 text-accent-deep" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 flex items-center justify-between">
                                        <span class="text-sm font-medium text-ink">Total terdata</span>
                                        <span
                                            class="text-sm font-bold text-accent-deep stat-number">{{ number_format($totalAnak, 0, ',', '.') }}
                                            anak</span>
                                    </div>
                                </div>

                                <div
                                    class="p-3 rounded-xl bg-paper border border-line hover:border-accent/40 transition-colors duration-200">
                                    <div class="flex items-center gap-3 mb-2.5">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-accent flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.5 12.75l6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 flex items-center justify-between">
                                            <span class="text-sm font-medium text-ink">Dokumen terverifikasi</span>
                                            <span
                                                class="text-sm font-bold text-accent-deep stat-number">{{ $persentaseVerifikasi }}%</span>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 bg-line rounded-full overflow-hidden ml-12"
                                        style="width: calc(100% - 3rem);">
                                        <div class="progress-bar h-full bg-accent rounded-full transition-all duration-1000 ease-out"
                                            style="width: 0%" data-target="{{ $persentaseVerifikasi }}"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center gap-3 p-3 rounded-xl bg-paper border border-line hover:border-accent/40 hover:-translate-y-0.5 transition-all duration-200">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-accent-soft flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4.5 h-4.5 text-accent-deep" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 flex items-center justify-between">
                                        <span class="text-sm font-medium text-ink">Kelurahan tercakup</span>
                                        <span
                                            class="text-sm font-bold text-accent-deep stat-number">{{ $totalKelurahan }}
                                            wilayah</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </section>

        <!-- FITUR -->
        <section class="features py-16 sm:py-24 bg-paper" id="fitur">
            <div class="wrap">
                <div class="text-center max-w-xl mx-auto mb-12 sm:mb-14 reveal">
                    <span class="text-xs font-bold text-accent-deep uppercase tracking-widest">Fitur utama</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-ink mt-2">Kelola data secara terpadu</h2>
                    <p class="text-ink-soft text-sm mt-3">Tiga langkah yang menjaga data anak yatim tetap rapi,
                        terverifikasi, dan mudah dilaporkan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-line border border-line rounded-2xl overflow-hidden reveal"
                    style="transition-delay:.1s">

                    <div
                        class="group relative bg-paper-raised p-6 sm:p-8 border-l-4 border-l-accent transition duration-300 hover:bg-accent-soft/40">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="feature-icon-wrap w-11 h-11 rounded-full bg-accent-soft flex items-center justify-center flex-shrink-0 group-hover:bg-accent group-hover:rotate-6">
                                <svg class="w-5 h-5 text-accent-deep group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-ink-faint">Langkah 01</span>
                        </div>
                        <h3 class="text-lg font-bold text-ink mb-2">Pendataan akurat</h3>
                        <p class="text-sm text-ink-soft leading-relaxed">Catat data NIK, KK, dan domisili anak yatim
                            dengan sistem yang rapi.</p>
                    </div>

                    <div
                        class="group relative bg-paper-raised p-6 sm:p-8 border-l-4 border-l-accent transition duration-300 hover:bg-accent-soft/40">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="feature-icon-wrap w-11 h-11 rounded-full bg-accent-soft flex items-center justify-center flex-shrink-0 group-hover:bg-accent group-hover:rotate-6">
                                <svg class="w-5 h-5 text-accent-deep group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-ink-faint">Langkah 02</span>
                        </div>
                        <h3 class="text-lg font-bold text-ink mb-2">Verifikasi dokumen</h3>
                        <p class="text-sm text-ink-soft leading-relaxed">Proses verifikasi dokumen kependudukan yang
                            ketat dan terukur.</p>
                    </div>

                    <div
                        class="group relative bg-paper-raised p-6 sm:p-8 border-l-4 border-l-accent transition duration-300 hover:bg-accent-soft/40">
                        <div class="flex items-center gap-3 mb-5">
                            <div
                                class="feature-icon-wrap w-11 h-11 rounded-full bg-accent-soft flex items-center justify-center flex-shrink-0 group-hover:bg-accent group-hover:rotate-6">
                                <svg class="w-5 h-5 text-accent-deep group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 13.5V21h18v-7.5M3 13.5L12 3l9 10.5M3 13.5h18" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-ink-faint">Langkah 03</span>
                        </div>
                        <h3 class="text-lg font-bold text-ink mb-2">Laporan wilayah</h3>
                        <p class="text-sm text-ink-soft leading-relaxed">Dapatkan statistik jumlah anak yatim
                            berdasarkan kelurahan dan kecamatan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========== SEGMEN TIM PENGEMBANG ========== -->
        <section class="relative py-16 sm:py-24 bg-white border-t border-line overflow-hidden">
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                style="background-image: radial-gradient(circle, #004ac6 1px, transparent 1px); background-size: 24px 24px;">
            </div>

            <div class="absolute inset-0 flex items-center justify-center opacity-[0.04] pointer-events-none z-0">
                <!-- 
            Pastikan file 'logo-pnp.png' sudah kamu letakkan di folder 'public/images/'
        -->
                <img src="{{ asset('storage/logo-pnp/4e94f6a69798aa0b85cd631ef335a08b.jpg') }}" alt="Logo Politeknik Negeri Padang"
                    class="w-[500px] h-auto object-contain">
            </div>

            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-12 sm:mb-16 reveal">
                    <span class="text-xs font-bold text-accent-deep uppercase tracking-widest">Di balik sistem
                        ini</span>
                    <h2 class="text-2xl sm:text-3xl font-bold text-ink mt-2">Tim pengembang</h2>
                    <p class="text-ink-soft text-sm mt-3">Mahasiswa Politeknik Negeri Padang PSDKU Pelalawan</p>
                </div>

                <div class="max-w-md mx-auto mb-12 sm:mb-16 reveal">
                    <div
                        class="relative bg-gradient-to-br from-accent to-accent-deep rounded-2xl p-7 sm:p-8 text-center shadow-lg shadow-accent/20 transition-transform duration-300 hover:-translate-y-1">
                        <span
                            class="inline-block text-[11px] font-bold text-white/70 uppercase tracking-widest mb-4">Dosen
                            pembimbing</span>
                        <div
                            class="w-16 h-16 rounded-full bg-white/15 border-2 border-white/30 flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-white">FO</span>
                        </div>
                        <p class="text-lg font-bold text-white mb-1">Fadhilah Oriyasmi, S.Kom., M.Kom</p>
                        <a href="https://instagram.com/oriyasmi" target="_blank"
                            class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-white/90 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                            @oriyasmi
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 sm:gap-6">

                    <div
                        class="group bg-paper-raised p-6 sm:p-7 rounded-2xl border-2 border-accent/20 hover:border-accent/50 hover:shadow-xl hover:-translate-y-1.5 transition duration-300 text-center reveal">
                        <span
                            class="inline-block bg-accent text-white text-[11px] px-3 py-1 rounded-full font-bold tracking-wide mb-5">KETUA</span>
                        <div
                            class="w-16 h-16 rounded-full bg-accent-soft flex items-center justify-center mx-auto mb-4 group-hover:bg-accent group-hover:scale-105 transition duration-300">
                            <span class="text-lg font-bold text-accent-deep group-hover:text-white transition">AH</span>
                        </div>
                        <h4 class="text-base font-bold text-ink mb-3">Adrian Havis Yandisa</h4>
                        <a href="https://instagram.com/adrnhvisy" target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 text-sm font-medium text-ink-faint hover:text-accent transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                            @adrnhvisy
                        </a>
                    </div>

                    <div class="group bg-paper-raised p-6 sm:p-7 rounded-2xl border-2 border-line hover:border-accent/50 hover:shadow-xl hover:-translate-y-1.5 transition duration-300 text-center reveal"
                        style="transition-delay:.1s">
                        <span
                            class="inline-block bg-paper text-ink-soft text-[11px] px-3 py-1 rounded-full font-bold tracking-wide mb-5">ANGGOTA</span>
                        <div
                            class="w-16 h-16 rounded-full bg-accent-soft flex items-center justify-center mx-auto mb-4 group-hover:bg-accent group-hover:scale-105 transition duration-300">
                            <span class="text-lg font-bold text-accent-deep group-hover:text-white transition">AY</span>
                        </div>
                        <h4 class="text-base font-bold text-ink mb-3">Ahmad Yusuf Nainggolan</h4>
                        <a href="https://instagram.com/ahmadyusu190" target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 text-sm font-medium text-ink-faint hover:text-accent transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                            @ahmadyusu190
                        </a>
                    </div>

                    <div class="group bg-paper-raised p-6 sm:p-7 rounded-2xl border-2 border-line hover:border-accent/50 hover:shadow-xl hover:-translate-y-1.5 transition duration-300 text-center reveal sm:col-span-2 md:col-span-1"
                        style="transition-delay:.2s">
                        <span
                            class="inline-block bg-paper text-ink-soft text-[11px] px-3 py-1 rounded-full font-bold tracking-wide mb-5">ANGGOTA</span>
                        <div
                            class="w-16 h-16 rounded-full bg-accent-soft flex items-center justify-center mx-auto mb-4 group-hover:bg-accent group-hover:scale-105 transition duration-300">
                            <span class="text-lg font-bold text-accent-deep group-hover:text-white transition">RR</span>
                        </div>
                        <h4 class="text-base font-bold text-ink mb-3">Rizki Ramadhanti Sapitri</h4>
                        <a href="https://instagram.com/rrzdyns" target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 text-sm font-medium text-ink-faint hover:text-accent transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                            @rrzdyns
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-line py-10 text-center text-ink-faint">
        <p class="text-sm">&copy; {{ date('Y') }} Sistem Pendataan Anak Yatim</p>
        <p class="text-sm mt-1">Dikembangkan oleh Tim Mahasiswa - Politeknik Negeri Padang PSDKU Pelalawan</p>
    </footer>

    <script>
        // Scroll reveal
        var revealEls = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            revealEls.forEach(function (el) { io.observe(el); });
        } else {
            revealEls.forEach(function (el) { el.classList.add('is-visible'); });
        }

        // Progress bar animasi saat masuk viewport
        var bar = document.querySelector('.progress-bar');
        if (bar) {
            var barIo = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        bar.style.width = bar.dataset.target + '%';
                        barIo.unobserve(bar);
                    }
                });
            }, { threshold: 0.4 });
            barIo.observe(bar);
        }
    </script>

</body>

</html>