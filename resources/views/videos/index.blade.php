{{-- resources/views/snapmusic/wizard.blade.php --}}
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SnapMusic – Create</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-b from-[#060A14] via-[#050814] to-[#040712] text-slate-100">
    <!-- Top bar -->
    {{-- <header class="px-6 pt-6">
    <div class="mx-auto max-w-6xl flex items-center gap-3">
      <div class="h-9 w-9 rounded-full bg-gradient-to-br from-emerald-400 to-cyan-400 flex items-center justify-center shadow-[0_0_25px_rgba(16,185,129,0.25)]">
        <div class="h-5 w-5 rounded-full border-2 border-white/80 flex items-center justify-center">
          <div class="h-2 w-2 rounded-full bg-white/90"></div>
        </div>
      </div>
      <div class="text-lg font-semibold tracking-wide">SnapMusic</div>

    <nav class="hidden md:flex items-center gap-8 text-sm text-gray-600">

    @if (Route::has('login'))
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="hover:text-black"
            >
                Dashboard
            </a>
        @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal"
            >
                Log in
            </a>

            @if (Route::has('register'))
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal">
                    Register
                </a>
            @endif
        @endauth
    @endif

  </nav>
  </div>
    <div class="mx-auto mt-6 max-w-6xl border-t border-white/10"></div>
  </header> --}}

    <header class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <div class="flex items-center gap-2 font-semibold text-lg">
            <a href="/" class="hover:text-white">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-emerald-600">SnapMusic</div>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-8 text-sm text-gray-600">
            {{-- <a href="#" class="hover:text-black">Use Cases</a>
    <a href="#" class="hover:text-black">How it Works</a>
    <a href="/videos" class="px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-green-400 text-black font-medium">
      make a video
    </a> --}}
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-green-400 text-black font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="px-6 pb-16">
        <div class="mx-auto max-w-5xl">
            <!-- Stepper -->
            <div class="mt-10 flex items-center justify-center">
                <div class="w-full max-w-2xl">
                    <div class="flex items-center justify-center gap-4">
                        <!-- Step 1 -->
                        <div class="flex items-center gap-3">
                            <div id="stepDot1"
                                class="h-9 w-9 rounded-full bg-yellow-500 text-black font-semibold flex items-center justify-center">
                                1</div>
                            <div id="stepLabel1" class="text-sm text-white/90">Image</div>
                        </div>

                        <div class="h-px w-16 bg-white/15"></div>

                        <!-- Step 2 -->
                        <div class="flex items-center gap-3">
                            <div id="stepDot2"
                                class="h-9 w-9 rounded-full bg-white/10 text-white/70 font-semibold flex items-center justify-center">
                                2</div>
                            <div id="stepLabel2" class="text-sm text-white/70">Audio</div>
                        </div>

                        <div class="h-px w-16 bg-white/15"></div>

                        <!-- Step 3 -->
                        <div class="flex items-center gap-3">
                            <div id="stepDot3"
                                class="h-9 w-9 rounded-full bg-white/10 text-white/70 font-semibold flex items-center justify-center">
                                3</div>
                            <div id="stepLabel3" class="text-sm text-white/70">Create</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div class="mt-12 text-center">
                <h1 id="pageTitle" class="text-4xl font-semibold tracking-tight">Upload Your Photo</h1>
                <p id="pageSubtitle" class="mt-3 text-white/50 text-sm"></p>
            </div>

            <!-- Panels -->
            <div class="mt-10 flex justify-center">
                <div class="w-full max-w-3xl">
                    <!-- STEP 1: IMAGE -->
                    <section id="panel1" class="block">
                        <div
                            class="rounded-3xl border border-white/10 bg-white/[0.03] shadow-[0_20px_80px_rgba(0,0,0,0.55)] p-8">
                            <div id="imageDrop"
                                class="group relative rounded-2xl border-2 border-dashed border-white/15 bg-black/20 p-10 md:p-14 text-center transition
                       hover:border-white/25 hover:bg-black/25"
                                role="button" tabindex="0">
                                <input id="imageInput" type="file" accept="image/png,image/jpeg" class="hidden" />

                                <!-- Default content -->
                                <div id="imageEmpty" class="space-y-4">
                                    <div
                                        class="mx-auto h-16 w-16 rounded-2xl bg-white/5 flex items-center justify-center">
                                        <!-- Image icon (inline SVG) -->
                                        <svg class="h-9 w-9 text-white/50" viewBox="0 0 24 24" fill="none"
                                            aria-hidden="true">
                                            <path
                                                d="M4 7a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7Z"
                                                stroke="currentColor" stroke-width="1.5" />
                                            <path
                                                d="M8 14l2.2-2.2a1 1 0 0 1 1.4 0L14 14.2a1 1 0 0 0 1.4 0L16 13.6a1 1 0 0 1 1.4 0L20 16"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M15.5 9.2a1.2 1.2 0 1 1-2.4 0 1.2 1.2 0 0 1 2.4 0Z"
                                                fill="currentColor" opacity="0.7" />
                                        </svg>
                                    </div>

                                    <div class="text-white/85 text-base">Drag &amp; drop your photo here</div>
                                    <div class="text-white/40 text-sm">or click to browse</div>

                                    <button id="imageBrowseBtn" type="button"
                                        class="mt-2 inline-flex items-center justify-center rounded-full bg-white/10 px-6 py-2 text-sm text-white/90
                           hover:bg-white/15 border border-white/10">
                                        Browse Files
                                    </button>

                                    <div class="pt-2 text-xs text-white/30">Supports JPG, PNG</div>
                                </div>

                                <!-- Preview content -->
                                <div id="imagePreviewWrap" class="hidden">
                                    <div class="flex flex-col items-center gap-4">
                                        <div
                                            class="w-full max-w-lg overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                                            <img id="imagePreview" alt="Selected photo preview"
                                                class="w-full h-[240px] object-contain bg-black/40" />
                                        </div>

                                        <div class="text-sm text-white/70">
                                            <span class="font-medium text-white/85">Selected:</span>
                                            <span id="imageMeta"></span>
                                        </div>

                                        <div class="flex flex-wrap gap-3 justify-center">
                                            <button id="imageReplaceBtn" type="button"
                                                class="rounded-full bg-white/10 px-5 py-2 text-sm text-white/90 hover:bg-white/15 border border-white/10">
                                                Replace
                                            </button>
                                            <button id="imageRemoveBtn" type="button"
                                                class="rounded-full bg-red-500/10 px-5 py-2 text-sm text-red-200 hover:bg-red-500/15 border border-red-500/20">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Drop highlight -->
                                <div id="imageDropHint"
                                    class="pointer-events-none absolute inset-0 rounded-2xl ring-0 ring-emerald-400/30 transition">
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between">
                                <div class="text-xs text-white/35">Step 1 of 3</div>
                                <button id="toStep2" type="button" disabled
                                    class="rounded-full bg-yellow-500/90 px-7 py-2.5 text-sm font-semibold text-black
                         hover:bg-yellow-500 disabled:opacity-40 disabled:cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 2: AUDIO -->
                    <section id="panel2" class="hidden">
                        <div
                            class="rounded-3xl border border-white/10 bg-white/[0.03] shadow-[0_20px_80px_rgba(0,0,0,0.55)] p-8">
                            <div id="audioDrop"
                                class="group relative rounded-2xl border-2 border-dashed border-white/15 bg-black/20 p-10 md:p-14 text-center transition
                       hover:border-white/25 hover:bg-black/25"
                                role="button" tabindex="0">
                                <input id="audioInput" type="file" accept="audio/*" class="hidden" />

                                <div id="audioEmpty" class="space-y-4">
                                    <div
                                        class="mx-auto h-16 w-16 rounded-2xl bg-white/5 flex items-center justify-center">
                                        <!-- Audio icon -->
                                        <svg class="h-9 w-9 text-white/50" viewBox="0 0 24 24" fill="none"
                                            aria-hidden="true">
                                            <path d="M9 18V6l10-2v12" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M9 18a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" fill="currentColor"
                                                opacity="0.7" />
                                            <path d="M19 16a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" fill="currentColor"
                                                opacity="0.7" />
                                        </svg>
                                    </div>

                                    <div class="text-white/85 text-base">Drag &amp; drop your audio here</div>
                                    <div class="text-white/40 text-sm">or click to browse</div>

                                    <button id="audioBrowseBtn" type="button"
                                        class="mt-2 inline-flex items-center justify-center rounded-full bg-white/10 px-6 py-2 text-sm text-white/90
                           hover:bg-white/15 border border-white/10">
                                        Browse Files
                                    </button>

                                    <div class="pt-2 text-xs text-white/30">Supports MP3, WAV, M4A (any audio/*)</div>
                                </div>

                                <div id="audioPreviewWrap" class="hidden">
                                    <div class="flex flex-col items-center gap-4">
                                        <div
                                            class="w-full max-w-lg rounded-2xl border border-white/10 bg-black/30 p-4">
                                            <div class="text-sm text-white/70">
                                                <span class="font-medium text-white/85">Selected:</span>
                                                <span id="audioMeta"></span>
                                            </div>
                                            <audio id="audioPlayer" controls class="mt-3 w-full"></audio>
                                        </div>

                                        <div class="flex flex-wrap gap-3 justify-center">
                                            <button id="audioReplaceBtn" type="button"
                                                class="rounded-full bg-white/10 px-5 py-2 text-sm text-white/90 hover:bg-white/15 border border-white/10">
                                                Replace
                                            </button>
                                            <button id="audioRemoveBtn" type="button"
                                                class="rounded-full bg-red-500/10 px-5 py-2 text-sm text-red-200 hover:bg-red-500/15 border border-red-500/20">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="audioDropHint"
                                    class="pointer-events-none absolute inset-0 rounded-2xl ring-0 ring-emerald-400/30 transition">
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between">
                                <button id="backTo1" type="button"
                                    class="rounded-full bg-white/10 px-6 py-2.5 text-sm text-white/90 hover:bg-white/15 border border-white/10">
                                    Back
                                </button>

                                <div class="flex items-center gap-4">
                                    <div class="text-xs text-white/35">Step 2 of 3</div>
                                    <button id="toStep3" type="button" disabled
                                        class="rounded-full bg-yellow-500/90 px-7 py-2.5 text-sm font-semibold text-black
                           hover:bg-yellow-500 disabled:opacity-40 disabled:cursor-not-allowed">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- STEP 3: CREATE -->
                    <section id="panel3" class="hidden">
                        <div
                            class="rounded-3xl border border-white/10 bg-white/[0.03] shadow-[0_20px_80px_rgba(0,0,0,0.55)] p-8">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="rounded-2xl border border-white/10 bg-black/20 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-white/10 text-sm text-white/80">Photo</div>
                                    <img id="finalImage" class="w-full h-56 object-contain bg-black/40"
                                        alt="Final selected photo" />
                                </div>

                                <div class="rounded-2xl border border-white/10 bg-black/20">
                                    <div class="px-4 py-3 border-b border-white/10 text-sm text-white/80">Audio</div>
                                    <div class="p-4">
                                        <div class="text-sm text-white/70">
                                            <span class="font-medium text-white/85">File:</span>
                                            <span id="finalAudioMeta"></span>
                                        </div>
                                        <audio id="finalAudioPlayer" controls class="mt-3 w-full"></audio>

                                        <div class="mt-4 text-xs text-white/35">
                                            Prototype note: “Create” is simulated here. In Laravel, submit the
                                            image+audio to your backend to render MP4.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Create controls -->
                            <div class="mt-8 flex flex-col gap-4">
                                <div id="createStatus"
                                    class="hidden rounded-2xl border border-white/10 bg-black/20 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="text-sm text-white/80">
                                            <span class="font-semibold">Creating video…</span>
                                            <span class="text-white/50" id="createHint">This is a demo
                                                progress.</span>
                                        </div>
                                        <div class="text-xs text-white/50" id="createPct">0%</div>
                                    </div>
                                    <div class="mt-3 h-2 w-full rounded-full bg-white/10 overflow-hidden">
                                        <div id="createBar" class="h-full w-0 bg-emerald-400/80"></div>
                                    </div>
                                </div>

                                <div id="createDone"
                                    class="hidden rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-4">
                                    <div class="text-sm text-emerald-100 font-semibold">Video ready (demo)</div>
                                    <div class="mt-1 text-xs text-emerald-100/70">
                                        Replace this with a real download URL returned by your Laravel controller.
                                    </div>
                                    <a id="downloadBtn" href="#"
                                        class="mt-3 inline-flex w-fit rounded-full bg-emerald-400/90 px-6 py-2 text-sm font-semibold text-black hover:bg-emerald-400">
                                        Download MP4
                                    </a>
                                </div>

                                <div class="flex items-center justify-between">
                                    <button id="backTo2" type="button"
                                        class="rounded-full bg-white/10 px-6 py-2.5 text-sm text-white/90 hover:bg-white/15 border border-white/10">
                                        Back
                                    </button>

                                    <div class="flex items-center gap-4">
                                        <div class="text-xs text-white/35">Step 3 of 3</div>
                                        <button id="createBtn" type="button"
                                            class="rounded-full bg-yellow-500/90 px-7 py-2.5 text-sm font-semibold text-black hover:bg-yellow-500">
                                            Create Video
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Tiny footer hint -->
                    <div class="mt-6 text-center text-xs text-white/30">
                        Tip: Click the dashed area to open file picker. Drag & drop also works.
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // -------------------------
        // Simple wizard state
        // -------------------------
        const state = {
            step: 1,
            imageFile: null,
            imageUrl: null,
            audioFile: null,
            audioUrl: null,
            creating: false,
            createTimer: null,
            createPct: 0
        };

        // Elements
        const panel1 = document.getElementById('panel1');
        const panel2 = document.getElementById('panel2');
        const panel3 = document.getElementById('panel3');

        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        const stepDot1 = document.getElementById('stepDot1');
        const stepDot2 = document.getElementById('stepDot2');
        const stepDot3 = document.getElementById('stepDot3');
        const stepLabel1 = document.getElementById('stepLabel1');
        const stepLabel2 = document.getElementById('stepLabel2');
        const stepLabel3 = document.getElementById('stepLabel3');

        // Step 1 (image)
        const imageDrop = document.getElementById('imageDrop');
        const imageDropHint = document.getElementById('imageDropHint');
        const imageInput = document.getElementById('imageInput');
        const imageBrowseBtn = document.getElementById('imageBrowseBtn');
        const imageEmpty = document.getElementById('imageEmpty');
        const imagePreviewWrap = document.getElementById('imagePreviewWrap');
        const imagePreview = document.getElementById('imagePreview');
        const imageMeta = document.getElementById('imageMeta');
        const imageReplaceBtn = document.getElementById('imageReplaceBtn');
        const imageRemoveBtn = document.getElementById('imageRemoveBtn');
        const toStep2 = document.getElementById('toStep2');

        // Step 2 (audio)
        const audioDrop = document.getElementById('audioDrop');
        const audioDropHint = document.getElementById('audioDropHint');
        const audioInput = document.getElementById('audioInput');
        const audioBrowseBtn = document.getElementById('audioBrowseBtn');
        const audioEmpty = document.getElementById('audioEmpty');
        const audioPreviewWrap = document.getElementById('audioPreviewWrap');
        const audioMeta = document.getElementById('audioMeta');
        const audioPlayer = document.getElementById('audioPlayer');
        const audioReplaceBtn = document.getElementById('audioReplaceBtn');
        const audioRemoveBtn = document.getElementById('audioRemoveBtn');
        const backTo1 = document.getElementById('backTo1');
        const toStep3 = document.getElementById('toStep3');

        // Step 3 (create)
        const backTo2 = document.getElementById('backTo2');
        const finalImage = document.getElementById('finalImage');
        const finalAudioMeta = document.getElementById('finalAudioMeta');
        const finalAudioPlayer = document.getElementById('finalAudioPlayer');
        const createBtn = document.getElementById('createBtn');

        const createStatus = document.getElementById('createStatus');
        const createBar = document.getElementById('createBar');
        const createPctEl = document.getElementById('createPct');
        const createDone = document.getElementById('createDone');
        const downloadBtn = document.getElementById('downloadBtn');

        // -------------------------
        // Helpers
        // -------------------------
        function fmtBytes(bytes) {
            if (!bytes && bytes !== 0) return '';
            const units = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            let n = bytes;
            while (n >= 1024 && i < units.length - 1) {
                n /= 1024;
                i++;
            }
            return `${n.toFixed(i === 0 ? 0 : 1)} ${units[i]}`;
        }

        function setStep(step) {
            state.step = step;

            // Panels
            panel1.classList.toggle('hidden', step !== 1);
            panel2.classList.toggle('hidden', step !== 2);
            panel3.classList.toggle('hidden', step !== 3);

            // Title
            if (step === 1) {
                pageTitle.textContent = 'Upload Your Photo';
                pageSubtitle.textContent = '';
            } else if (step === 2) {
                pageTitle.textContent = 'Upload Your Audio';
                pageSubtitle.textContent = '';
            } else {
                pageTitle.textContent = 'Create Your Video';
                pageSubtitle.textContent = '';
                syncFinalPreview();
            }

            // Stepper UI
            const active = (dot, label) => {
                dot.className =
                    'h-9 w-9 rounded-full bg-yellow-500 text-black font-semibold flex items-center justify-center';
                label.className = 'text-sm text-white/90';
            };
            const done = (dot, label) => {
                dot.className =
                    'h-9 w-9 rounded-full bg-emerald-400/90 text-black font-semibold flex items-center justify-center';
                label.className = 'text-sm text-white/90';
            };
            const idle = (dot, label) => {
                dot.className =
                    'h-9 w-9 rounded-full bg-white/10 text-white/70 font-semibold flex items-center justify-center';
                label.className = 'text-sm text-white/70';
            };

            // Step states
            if (step === 1) {
                active(stepDot1, stepLabel1);
                idle(stepDot2, stepLabel2);
                idle(stepDot3, stepLabel3);
            } else if (step === 2) {
                done(stepDot1, stepLabel1);
                active(stepDot2, stepLabel2);
                idle(stepDot3, stepLabel3);
            } else {
                done(stepDot1, stepLabel1);
                done(stepDot2, stepLabel2);
                active(stepDot3, stepLabel3);
            }
        }

        function setImage(file) {
            if (!file) return;

            // Validate
            const ok = ['image/jpeg', 'image/png'].includes(file.type);
            if (!ok) {
                alert('Please upload a JPG or PNG image.');
                return;
            }

            // Cleanup old url
            if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);

            state.imageFile = file;
            state.imageUrl = URL.createObjectURL(file);

            imagePreview.src = state.imageUrl;
            imageMeta.textContent = `${file.name} • ${fmtBytes(file.size)}`;

            imageEmpty.classList.add('hidden');
            imagePreviewWrap.classList.remove('hidden');
            toStep2.disabled = false;
        }

        function clearImage() {
            if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
            state.imageFile = null;
            state.imageUrl = null;

            imageInput.value = '';
            imagePreview.src = '';
            imageMeta.textContent = '';

            imageEmpty.classList.remove('hidden');
            imagePreviewWrap.classList.add('hidden');
            toStep2.disabled = true;
        }

        function setAudio(file) {
            if (!file) return;

            // Basic validate: must be audio/*
            if (!file.type.startsWith('audio/')) {
                alert('Please upload a valid audio file (audio/*).');
                return;
            }

            if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);

            state.audioFile = file;
            state.audioUrl = URL.createObjectURL(file);

            audioMeta.textContent = `${file.name} • ${fmtBytes(file.size)}`;
            audioPlayer.src = state.audioUrl;

            audioEmpty.classList.add('hidden');
            audioPreviewWrap.classList.remove('hidden');
            toStep3.disabled = false;
        }

        function clearAudio() {
            if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);
            state.audioFile = null;
            state.audioUrl = null;

            audioInput.value = '';
            audioPlayer.src = '';
            audioMeta.textContent = '';

            audioEmpty.classList.remove('hidden');
            audioPreviewWrap.classList.add('hidden');
            toStep3.disabled = true;
        }

        function syncFinalPreview() {
            finalImage.src = state.imageUrl || '';
            finalAudioMeta.textContent = state.audioFile ? `${state.audioFile.name} • ${fmtBytes(state.audioFile.size)}` :
                '';
            finalAudioPlayer.src = state.audioUrl || '';

            // reset create UI
            createDone.classList.add('hidden');
            createStatus.classList.add('hidden');
            createBar.style.width = '0%';
            createPctEl.textContent = '0%';
            state.createPct = 0;
            state.creating = false;
            if (state.createTimer) clearInterval(state.createTimer);
            state.createTimer = null;
        }

        function simulateCreate() {
            if (!state.imageFile || !state.audioFile) {
                alert('Please select both image and audio first.');
                return;
            }
            if (state.creating) return;

            state.creating = true;
            createDone.classList.add('hidden');
            createStatus.classList.remove('hidden');
            createBtn.disabled = true;
            createBtn.classList.add('opacity-50', 'cursor-not-allowed');

            state.createPct = 0;
            createBar.style.width = '0%';
            createPctEl.textContent = '0%';

            state.createTimer = setInterval(() => {
                // progress steps
                const bump = Math.floor(Math.random() * 10) + 6; // 6..15
                state.createPct = Math.min(100, state.createPct + bump);
                createBar.style.width = `${state.createPct}%`;
                createPctEl.textContent = `${state.createPct}%`;

                if (state.createPct >= 100) {
                    clearInterval(state.createTimer);
                    state.createTimer = null;
                    state.creating = false;

                    createStatus.classList.add('hidden');
                    createDone.classList.remove('hidden');

                    // demo download
                    downloadBtn.href = '#';
                    downloadBtn.onclick = (e) => {
                        e.preventDefault();
                        alert('Demo: Replace this with a real MP4 download URL from your Laravel backend.');
                    };

                    createBtn.disabled = false;
                    createBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }, 250);
        }

        // -------------------------
        // Drag & Drop bindings
        // -------------------------
        function bindDropZone(zoneEl, hintEl, onFiles) {
            const highlight = (on) => hintEl.classList.toggle('ring-4', on);

            zoneEl.addEventListener('dragover', (e) => {
                e.preventDefault();
                highlight(true);
            });
            zoneEl.addEventListener('dragleave', () => highlight(false));
            zoneEl.addEventListener('drop', (e) => {
                e.preventDefault();
                highlight(false);
                const files = e.dataTransfer?.files;
                if (files && files.length) onFiles(files);
            });
        }

        // Step 1 handlers
        imageDrop.addEventListener('click', () => imageInput.click());
        imageDrop.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                imageInput.click();
            }
        });
        imageBrowseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            imageInput.click();
        });
        imageReplaceBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            imageInput.click();
        });
        imageRemoveBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            clearImage();
        });

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (file) setImage(file);
        });

        bindDropZone(imageDrop, imageDropHint, (files) => setImage(files[0]));

        toStep2.addEventListener('click', () => setStep(2));

        // Step 2 handlers
        audioDrop.addEventListener('click', () => audioInput.click());
        audioDrop.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                audioInput.click();
            }
        });
        audioBrowseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            audioInput.click();
        });
        audioReplaceBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            audioInput.click();
        });
        audioRemoveBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            clearAudio();
        });

        audioInput.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (file) setAudio(file);
        });

        bindDropZone(audioDrop, audioDropHint, (files) => setAudio(files[0]));

        backTo1.addEventListener('click', () => setStep(1));
        toStep3.addEventListener('click', () => setStep(3));

        // Step 3 handlers
        backTo2.addEventListener('click', () => setStep(2));
        createBtn.addEventListener('click', simulateCreate);

        // Init
        clearImage();
        clearAudio();
        setStep(1);
    </script>
</body>

</html>
