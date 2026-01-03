{{-- <body class="min-h-screen bg-gradient-to-b from-[#060A14] via-[#050814] to-[#040712] text-slate-100"> --}}

<x-app-layout>
    <div class="px-6 pb-16 pt-16 min-h-screen bg-gradient-to-b from-[#060A14] via-[#050814] to-[#040712] text-slate-100">
        <div class="mx-auto max-w-5xl">

            <!-- Notifications -->
            <div class="mt-6 mb-8" x-data="{ showSuccess: true, showCompleted: true, showError: true, showErrors: true }">
                @if (session('success'))
                    <div x-show="showSuccess" class="relative rounded-xl bg-green-500/10 border border-green-500/20 p-4 text-green-200 mb-4">
                        <div class="pr-8">{{ session('success') }}</div>
                        <button @click="showSuccess = false" class="absolute top-4 right-4 text-green-200/50 hover:text-green-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('video_completed'))
                    @php $data = session('video_completed'); @endphp
                    <div x-show="showCompleted" class="relative rounded-xl bg-emerald-500/20 border border-emerald-500/30 p-5 text-emerald-100 mb-4 flex items-center justify-between shadow-lg shadow-emerald-900/20">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Your video is ready!</p>
                                <p class="text-emerald-300/80 text-sm">Video #{{ $data['id'] }} has been processed successfully.</p>
                                <div class="mt-3 flex gap-4 text-sm font-semibold">
                                    <a href="{{ $data['download_url'] }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500 text-black hover:bg-emerald-400 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download MP4
                                    </a>
                                    <a href="{{ $data['stream_url'] }}" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition border border-white/10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button @click="showCompleted = false" class="text-emerald-400/50 hover:text-emerald-400 p-2 rounded-lg hover:bg-emerald-400/10 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-show="showError" class="relative rounded-xl bg-red-500/10 border border-red-500/20 p-4 text-red-200 mb-4">
                        <div class="pr-8">{{ session('error') }}</div>
                        <button @click="showError = false" class="absolute top-4 right-4 text-red-200/50 hover:text-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div x-show="showErrors" class="relative rounded-xl bg-red-500/10 border border-red-500/20 p-4 text-red-200 mb-4">
                        <ul class="list-disc list-inside pr-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button @click="showErrors = false" class="absolute top-4 right-4 text-red-200/50 hover:text-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
            </div>

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
                <form id="uploadForm" action="{{ route('make-a-video.upload') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-3xl">
                    @csrf
                    
                    <!-- STEP 1: IMAGE -->
                    <section id="panel1" class="block">
                        <div
                            class="rounded-3xl border border-white/10 bg-white/[0.03] shadow-[0_20px_80px_rgba(0,0,0,0.55)] p-8">
                            <div id="imageDrop"
                                class="group relative rounded-2xl border-2 border-dashed border-white/15 bg-black/20 p-10 md:p-14 text-center transition
                       hover:border-white/25 hover:bg-black/25"
                                role="button" tabindex="0">
                                <input id="imageInput" name="image" type="file" accept="image/png,image/jpeg" class="hidden" required />

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
                            <div id="imageError" class="mt-2 text-center text-sm text-red-400">
                                @error('image') {{ $message }} @enderror
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
                                <input id="audioInput" name="audio" type="file" accept=".mp3,.wav" class="hidden" required />

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

                                    <div class="pt-2 text-xs text-white/30">Supports MP3, WAV</div>
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
                            <div id="audioError" class="mt-2 text-center text-sm text-red-400">
                                @error('audio') {{ $message }} @enderror
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
                                            Ready to generate your video.
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
                                            <span class="font-semibold">Uploading...</span>
                                            <span class="text-white/50" id="createHint">Please wait</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 h-2 w-full rounded-full bg-white/10 overflow-hidden">
                                        <div id="createBar" class="h-full w-full animate-pulse bg-emerald-400/80"></div>
                                    </div>
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
                </form>
            </div>

            <!-- Your Videos List -->
            @if(isset($jobs) && $jobs->count() > 0)
            <div class="mt-16 border-t border-white/10 pt-10">
                <h3 class="text-xl font-semibold mb-6">Your Videos</h3>
                <div class="overflow-x-auto rounded-xl border border-white/10 bg-white/[0.03]">
                    <table class="min-w-full divide-y divide-white/10 text-sm">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-white/60">ID</th>
                                <th class="px-6 py-3 text-left font-medium text-white/60">Status</th>
                                <th class="px-6 py-3 text-left font-medium text-white/60">Duration</th>
                                <th class="px-6 py-3 text-left font-medium text-white/60">Created</th>
                                <th class="px-6 py-3 text-left font-medium text-white/60">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($jobs as $job)
                                <tr data-job-id="{{ $job->id }}" class="hover:bg-white/5 transition">
                                    <td class="px-6 py-4 text-white/80">#{{ $job->id }}</td>
                                    <td class="px-6 py-4 status-badge">
                                        @if ($job->status === 'pending')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-500/10 text-yellow-300 border border-yellow-500/20">Pending</span>
                                        @elseif ($job->status === 'processing')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/20">Processing</span>
                                        @elseif ($job->status === 'completed')
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">Completed</span>
                                        @else
                                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500/10 text-red-300 border border-red-500/20">Failed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-white/60 duration-cell">
                                        {{ $job->duration ? gmdate('i:s', $job->duration) : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-white/60">
                                        {{ $job->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 font-medium space-x-2 actions-cell">
                                        @if ($job->isCompleted())
                                            <a href="{{ route('make-a-video.download', $job) }}" class="text-emerald-400 hover:text-emerald-300">Download</a>
                                            <a href="{{ route('make-a-video.stream', $job) }}" target="_blank" class="text-blue-400 hover:text-blue-300">Preview</a>
                                        @endif
                                        
                                        @if ($job->isFailed())
                                            <span class="text-red-400 cursor-help" title="{{ $job->error_message }}">Error</span>
                                        @endif

                                        <form action="{{ route('make-a-video.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this video?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>

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
        const uploadForm = document.getElementById('uploadForm');

        const createStatus = document.getElementById('createStatus');
        const createBar = document.getElementById('createBar');
        
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
            const errorEl = document.getElementById('imageError');
            if (errorEl) errorEl.textContent = '';

            if (!file) return;

            // Validate type
            const ok = ['image/jpeg', 'image/png'].includes(file.type);
            if (!ok) {
                if (errorEl) errorEl.textContent = 'Please upload a JPG or PNG image.';
                
                // Manual cleanup to preserve error
                imageInput.value = '';
                if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
                state.imageFile = null;
                state.imageUrl = null;
                imageEmpty.classList.remove('hidden');
                imagePreviewWrap.classList.add('hidden');
                toStep2.disabled = true;
                return;
            }

            // Validate size (2MB)
            const MAX_SIZE = 2 * 1024 * 1024;
            if (file.size > MAX_SIZE) {
                if (errorEl) errorEl.textContent = 'The image file size must not exceed 2MB.';
                
                // Manual cleanup to preserve error
                imageInput.value = '';
                if (state.imageUrl) URL.revokeObjectURL(state.imageUrl);
                state.imageFile = null;
                state.imageUrl = null;
                imageEmpty.classList.remove('hidden');
                imagePreviewWrap.classList.add('hidden');
                toStep2.disabled = true;
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
            const errorEl = document.getElementById('imageError');
            if (errorEl) errorEl.textContent = '';

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
            const errorEl = document.getElementById('audioError');
            if (errorEl) errorEl.textContent = '';

            if (!file) return;

            // Basic validate type
            if (!file.type.startsWith('audio/') && !file.name.endsWith('.mp3') && !file.name.endsWith('.wav')) {
                 // Relaxed check, just ensuring it's audio-ish if type is missing/weird
            }

             // Validate size (2MB)
            const MAX_SIZE = 2 * 1024 * 1024;
            if (file.size > MAX_SIZE) {
                if (errorEl) errorEl.textContent = 'The audio file size must not exceed 2MB.';
                
                // Manual cleanup to preserve error
                audioInput.value = '';
                if (state.audioUrl) URL.revokeObjectURL(state.audioUrl);
                state.audioFile = null;
                state.audioUrl = null;
                audioEmpty.classList.remove('hidden');
                audioPreviewWrap.classList.add('hidden');
                toStep3.disabled = true;
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
            const errorEl = document.getElementById('audioError');
            if (errorEl) errorEl.textContent = '';

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
            createStatus.classList.add('hidden');
            state.creating = false;
        }

        // -------------------------
        // Submit Handler
        // -------------------------
        createBtn.addEventListener('click', () => {
             if (!state.imageFile || !state.audioFile) {
                alert('Please select both image and audio first.');
                return;
            }
            
            // Show loading UI
            state.creating = true;
            createStatus.classList.remove('hidden');
            createBtn.disabled = true;
            createBtn.classList.add('opacity-50', 'cursor-not-allowed');
            createBtn.innerText = 'Uploading...';
            
            // Submit form
            uploadForm.submit();
        });

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
                if (files && files.length) {
                    onFiles(files);
                    
                    // Manually assign files to input (needed for form submit)
                    const inputId = zoneEl.id === 'imageDrop' ? 'imageInput' : 'audioInput';
                    document.getElementById(inputId).files = files;
                }
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

        // Init
        clearImage();
        clearAudio();
        setStep(1);

        // -------------------------
        // Polling
        // -------------------------
        @if(isset($jobs))
        const processingJobs = @json($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());

        if (processingJobs.length > 0) {
            setInterval(checkJobStatuses, 3000);
            checkJobStatuses();
        }

        async function checkJobStatuses() {
            const jobsToCheck = [...processingJobs];

            for (const jobId of jobsToCheck) {
                try {
                    const response = await fetch(`/make-a-video/${jobId}/status`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) continue;

                    const data = await response.json();

                    // Update the UI
                    updateJobRow(jobId, data);

                    if (data.status === 'completed' || data.status === 'failed') {
                        const index = processingJobs.indexOf(jobId);
                        if (index > -1) processingJobs.splice(index, 1);
                        
                        // If completed, trigger session flash
                        if (data.status === 'completed') {
                            try {
                                await fetch(`/make-a-video/${jobId}/notify-completion`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                });
                            } catch (e) { console.error('Notify failed', e); }
                        }

                        // Optional: Reload if all done to refresh links? 
                         if (processingJobs.length === 0) {
                            setTimeout(() => location.reload(), 500);
                        }
                    }
                } catch (error) {
                    console.error(`Error checking job ${jobId}:`, error);
                }
            }
        }

        function updateJobRow(jobId, data) {
            const row = document.querySelector(`tr[data-job-id="${jobId}"]`);
            if (!row) return;

            const statusCell = row.querySelector('.status-badge');
            if (statusCell) {
                let badgeHtml = '';
                if (data.status === 'pending') {
                    badgeHtml = '<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-500/10 text-yellow-300 border border-yellow-500/20">Pending</span>';
                } else if (data.status === 'processing') {
                    badgeHtml = '<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/20">Processing</span>';
                } else if (data.status === 'completed') {
                    badgeHtml = '<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">Completed</span>';
                } else if (data.status === 'failed') {
                    badgeHtml = '<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500/10 text-red-300 border border-red-500/20">Failed</span>';
                }
                statusCell.innerHTML = badgeHtml;
            }
            
            // Note: Actions update logic similar to index-bak could be added here
            // For brevity, relying on reload for full action buttons update
        }
        @endif
    </script>
</x-app-layout>