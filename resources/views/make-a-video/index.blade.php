<x-app-layout>
    <div class="min-h-screen bg-gray-950 text-white" x-data="videoWizard()">
        
        <!-- Background Ambient Effects -->
        <div class="fixed inset-0 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-purple-600/10 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 pb-12 pt-4">
            
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-5xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">
                    Create Your SnapMusic
                </h1>
                <p class="mt-4 text-gray-400">Turn your image and audio into a viral SnapMusic in 3 simple steps.</p>
            </div>

            <!-- Wizard Progress -->
            <div class="mb-12" x-show="step < 4">
                <div class="flex items-center justify-center max-w-2xl mx-auto">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                             :class="step >= 1 ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.5)]' : 'bg-gray-800 text-gray-500'">
                            1
                        </div>
                        <span class="mt-2 text-xs font-medium uppercase tracking-wider" :class="step >= 1 ? 'text-purple-400' : 'text-gray-600'">Image</span>
                    </div>
                    
                    <div class="flex-1 h-0.5 mx-4 transition-all duration-300" :class="step >= 2 ? 'bg-purple-600' : 'bg-gray-800'"></div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                             :class="step >= 2 ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.5)]' : 'bg-gray-800 text-gray-500'">
                            2
                        </div>
                        <span class="mt-2 text-xs font-medium uppercase tracking-wider" :class="step >= 2 ? 'text-purple-400' : 'text-gray-600'">Audio</span>
                    </div>

                    <div class="flex-1 h-0.5 mx-4 transition-all duration-300" :class="step >= 3 ? 'bg-purple-600' : 'bg-gray-800'"></div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center relative z-10">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-300"
                             :class="step >= 3 ? 'bg-purple-600 text-white shadow-[0_0_15px_rgba(147,51,234,0.5)]' : 'bg-gray-800 text-gray-500'">
                            3
                        </div>
                        <span class="mt-2 text-xs font-medium uppercase tracking-wider" :class="step >= 3 ? 'text-purple-400' : 'text-gray-600'">Review</span>
                    </div>
                </div>
            </div>

            <!-- Error Notification -->
            <div x-show="errorMessage" x-transition class="mb-8 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-200 flex items-center justify-between">
                <span x-text="errorMessage"></span>
                <button @click="errorMessage = ''" class="text-red-400 hover:text-white">&times;</button>
            </div>

            <!-- Main Content Area: Glass Container -->
            <div class="bg-gray-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-12 shadow-2xl overflow-hidden min-h-[400px]">
                
                <!-- Step 1: Image Upload -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col justify-center items-center h-full">
                    <div class="w-full text-center" @dragover.prevent @drop.prevent="handleImageDrop($event)">
                        <input type="file" x-ref="imageInput" class="hidden" accept="image/*" @change="handleImage($event)">
                        
                        <div x-show="!imagePreview && !imageStored">
                            <div class="w-20 h-20 bg-purple-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-purple-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Upload an Image</h3>
                            <p class="text-gray-400 mb-8">Drag & drop your JPG/PNG here, or browse files.</p>
                            <button @click="triggerImageUpload" class="px-8 py-3 rounded-full bg-white text-gray-900 font-bold hover:bg-gray-200 transition-colors transform hover:scale-105 active:scale-95">
                                Select Image
                            </button>
                        </div>

                        <!-- Preview or Stored State -->
                        <div x-show="imagePreview || imageStored" class="flex flex-col items-center">
                            <div class="relative w-full max-w-md aspect-square rounded-xl overflow-hidden shadow-2xl border border-white/10 group bg-black/40 flex items-center justify-center">
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="max-w-full max-h-full object-contain">
                                </template>
                                <template x-if="!imagePreview && imageStored">
                                    <div class="text-gray-400 flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Image Saved</span>
                                    </div>
                                </template>

                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="triggerImageUpload" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg text-white border border-white/20 backdrop-blur-md">Change Image</button>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button @click="uploadStep1" :disabled="uploading" class="px-10 py-3 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                                    <span x-show="uploading" class="animate-spin h-5 w-5 border-2 border-white rounded-full border-t-transparent"></span>
                                    <span x-text="uploading ? 'Uploading...' : 'Continue &rarr;'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Audio Upload -->
                <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col justify-center items-center h-full">
                    <div class="w-full text-center" @dragover.prevent @drop.prevent="handleAudioDrop($event)">
                        <input type="file" x-ref="audioInput" class="hidden" accept="audio/*" @change="handleAudio($event)">
                        
                        <div x-show="!audioFile && !audioStored">
                            <div class="w-20 h-20 bg-blue-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 text-blue-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-2">Add Your Audio</h3>
                            <p class="text-gray-400 mb-8">Drag & drop MP3/WAV, or click to browse.</p>
                            <div class="flex gap-4 justify-center">
                                <button @click="step = 1" class="px-6 py-3 rounded-full bg-gray-800 text-gray-300 font-semibold hover:bg-gray-700 transition-colors">
                                    &larr; Back
                                </button>
                                <button @click="triggerAudioUpload" class="px-8 py-3 rounded-full bg-white text-gray-900 font-bold hover:bg-gray-200 transition-colors transform hover:scale-105 active:scale-95">
                                    Select Audio
                                </button>
                            </div>
                        </div>

                        <div x-show="audioFile || audioStored" class="flex flex-col items-center w-full">
                            <div class="w-full max-w-md p-6 rounded-2xl bg-white/5 border border-white/10 mb-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                                        🎵
                                    </div>
                                    <div class="text-left overflow-hidden">
                                        <div class="font-medium text-white truncate" x-text="audioName || 'Audio File'"></div>
                                        <div class="text-xs text-gray-500" x-text="audioStored ? 'Stored in Session' : 'Ready to upload'"></div>
                                    </div>
                                    <button @click="triggerAudioUpload" class="ml-auto text-xs text-blue-400 hover:text-blue-300 underline">Change</button>
                                </div>
                                <audio x-ref="audioPreview" controls class="w-full" x-show="audioFile"></audio>
                            </div>
                            
                            <div class="flex gap-4">
                                <button @click="step = 1" class="px-6 py-3 rounded-full bg-gray-800 text-gray-300 font-semibold hover:bg-gray-700 transition-colors">
                                    &larr; Back
                                </button>
                                <button @click="uploadStep2" :disabled="uploading" class="px-10 py-3 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all transform hover:-translate-y-1 disabled:opacity-50 flex items-center gap-2">
                                     <span x-show="uploading" class="animate-spin h-5 w-5 border-2 border-white rounded-full border-t-transparent"></span>
                                     <span x-text="uploading ? 'Uploading...' : 'Review &rarr;'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Review -->
                <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-10" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col h-full py-4">
                    <h2 class="text-3xl font-bold text-center mb-10">Review Your Snap & the Music</h2>
                    
                    <div class="grid md:grid-cols-2 gap-10 mb-12 items-start">
                        <!-- Image Preview -->
                        <div class="flex flex-col items-center">
                            <div class="text-xs text-gray-500 uppercase tracking-widest mb-3 font-bold">Visual Asset</div>
                            <div class="w-full aspect-square bg-black/60 rounded-2xl border border-white/10 overflow-hidden flex items-center justify-center shadow-inner">
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="max-w-full max-h-full object-contain">
                                </template>
                                <template x-if="!imagePreview">
                                     <div class="text-gray-500 flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Image Ready</span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Audio Details -->
                        <div class="flex flex-col justify-center h-full">
                            <div class="text-xs text-gray-500 uppercase tracking-widest mb-3 font-bold">Audio Track</div>
                            <div class="bg-white/5 rounded-2xl p-6 border border-white/10 flex flex-col gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-xl">🔊</div>
                                    <div class="overflow-hidden">
                                        <div class="text-white font-bold truncate" x-text="audioName || 'Uploaded Audio'"></div>
                                        <div class="text-gray-500 text-xs mt-0.5">MP4 Video will match this duration</div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed border-t border-white/5 pt-4">
                                    The uploaded image will be looped to create a high-quality H.264 MP4 video. Perfect for social sharing.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-6 pt-4">
                        
                        <template x-if="isLoggedIn">
                             <div class="flex gap-6">
                                <button @click="step = 2" class="px-8 py-3 rounded-full bg-gray-800 text-gray-300 font-bold hover:bg-gray-700 transition-all">
                                    Edit Assets
                                </button>
                                <button @click="submitFinal" :disabled="uploading" class="px-12 py-3 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg shadow-green-500/30 hover:shadow-green-500/50 transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50">
                                    <span x-show="!uploading">✨ Create SnapMusic Now</span>
                                    <span x-show="uploading">Processing...</span>
                                </button>
                             </div>
                        </template>

                        <template x-if="!isLoggedIn">
                            <div class="text-center w-full max-w-md bg-white/5 p-6 rounded-2xl border border-yellow-500/30">
                                <h3 class="text-xl font-bold text-yellow-100 mb-4">Account Required</h3>
                                <p class="text-gray-400 mb-6">You're almost there! Please log in or register to process your video. Your files are safe.</p>
                                <div class="flex gap-4 justify-center">
                                    <a href="{{ route('login') }}" class="px-8 py-3 rounded-full bg-white text-gray-900 font-bold hover:bg-gray-200 transition-colors">
                                        Log In
                                    </a>
                                    <a href="{{ route('register') }}" class="px-8 py-3 rounded-full bg-transparent border border-white/30 text-white font-bold hover:bg-white/10 transition-colors">
                                        Register
                                    </a>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>

                <!-- Step 4: Processing (Status) -->
                <div x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-300" class="flex flex-col justify-center items-center h-full text-center">
                    
                    <!-- Processing State -->
                    <div x-show="jobStatus !== 'completed' && jobStatus !== 'failed'">
                        <div class="relative w-28 h-28 mx-auto mb-8">
                            <div class="absolute inset-0 rounded-full border-4 border-white/5"></div>
                            <div class="absolute inset-0 rounded-full border-4 border-t-green-400 border-r-green-400 border-b-transparent border-l-transparent animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-5xl animate-pulse">⚙️</div>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-white" x-text="statusMessage"></h3>
                        <p class="text-gray-400 max-w-xs mx-auto">Our workers are weaving your assets into a masterpiece. Stay close!</p>
                    </div>

                </div>

                <!-- Step 5: Result (Success/Fail) -->
                <div x-show="step === 5" x-cloak x-transition:enter="transition ease-out duration-300" class="flex flex-col h-full py-4">
                    <!-- Success -->
                    <div x-show="jobStatus === 'completed'" class="flex flex-col items-center text-center h-full">
                        <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center text-4xl mb-6 shadow-lg shadow-green-500/20 border border-green-500/30">
                            🎉
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-2">SnapMusic is ready</h3>
                        <p class="text-gray-400 mb-10">Your SnapMusic has been generated and is ready to share.</p>
                        
                        <div class="w-full max-w-3xl flex justify-center mb-10">
                            <div class="relative rounded-2xl overflow-hidden shadow-[0_0_50px_-12px_rgba(0,0,0,0.5)] border border-white/10 bg-black group flex justify-center w-full min-h-[300px]">
                                <video :src="videoUrl" controls class="max-h-[60vh] w-auto object-contain"></video>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 justify-center w-full">
                            <a :href="downloadUrl" class="px-8 py-4 rounded-full bg-white text-gray-900 font-bold hover:bg-gray-200 transition-all flex items-center gap-2 shadow-xl hover:-translate-y-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download MP4
                            </a>
                            
                            <button @click="shareVideo" class="px-8 py-4 rounded-full bg-blue-600 text-white font-bold hover:bg-blue-500 transition-all flex items-center gap-2 shadow-xl hover:-translate-y-1">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                Share SnapMusic
                            </button>

                            <button @click="reset" class="px-8 py-4 rounded-full bg-white/5 text-white font-semibold hover:bg-white/10 transition-all border border-white/10 backdrop-blur-sm">
                                Create New
                            </button>
                        </div>
                    </div>

                    <!-- Failed -->
                    <div x-show="jobStatus === 'failed'" class="flex flex-col justify-center items-center h-full text-center">
                        <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center text-4xl mb-6 border border-red-500/30">
                            ❌
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-3">Processing Failed</h3>
                        <p class="text-red-300 mb-10 max-w-md mx-auto leading-relaxed" x-text="errorMessage"></p>
                        
                        <button @click="step = 1; jobStatus='idle'; errorMessage=''" class="px-10 py-3 rounded-full bg-white/10 text-white font-bold hover:bg-white/20 transition-all border border-white/10">
                            Try Again
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('videoWizard', () => ({
                step: {{ $wizardData['step'] ?? 1 }},
                isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
                
                imageFile: null,
                imagePreview: {!! isset($wizardData['image']) ? "'" . route('make-a-video.preview-image') . '?t=' . time() . "'" : 'null' !!},
                imageStored: {{ isset($wizardData['image']) ? 'true' : 'false' }},
                
                audioFile: null,
                audioName: {!! isset($wizardData['audio_name']) ? "'" . e($wizardData['audio_name']) . "'" : 'null' !!},
                audioStored: {{ isset($wizardData['audio']) ? 'true' : 'false' }},

                uploading: false,
                uploadProgress: 0,
                jobId: null,
                jobStatus: 'idle', 
                statusMessage: '',
                errorMessage: '',
                videoUrl: null,
                downloadUrl: null,

                init() {
                    // If we restored session to Step 3, ensure we reflect that files are ready
                    if (this.step >= 3) {
                        this.imageStored = true;
                        this.audioStored = true;
                    }
                },

                triggerImageUpload() { this.$refs.imageInput.click(); },

                handleImage(event) { this.processImage(event.target.files[0]); },
                handleImageDrop(event) { this.processImage(event.dataTransfer.files[0]); },

                processImage(file) {
                    if (!file) return;
                    if (!file.type.startsWith('image/')) {
                        this.errorMessage = "Please select a valid image file.";
                        return;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        this.errorMessage = "Image is too large (Max 5MB).";
                        return;
                    }
                    
                    this.errorMessage = '';
                    this.imageFile = file;
                    this.imageStored = false; // Reset stored status as we have a new file
                    
                    const reader = new FileReader();
                    reader.onload = (e) => { this.imagePreview = e.target.result; };
                    reader.readAsDataURL(file);

                    // Auto upload logic can go here if we wanted immediate upload, 
                    // but we will stick to "Continue" button for explicit action
                },

                async uploadStep1() {
                    // If we have a stored image and no new file, just proceed
                    if (this.imageStored && !this.imageFile) {
                        this.step = 2;
                        return;
                    }

                    if (!this.imageFile) {
                        this.errorMessage = "Please select an image.";
                        return;
                    }

                    this.uploading = true;
                    this.errorMessage = '';
                    
                    const formData = new FormData();
                    formData.append('image', this.imageFile);

                    try {
                        const response = await fetch('{{ route('make-a-video.step1') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        });

                        if (!response.ok) {
                            const data = await response.json();
                            throw new Error(data.message || 'Image upload failed');
                        }

                        // Success
                        this.imageStored = true;
                        this.step = 2;

                    } catch (e) {
                        this.errorMessage = e.message;
                    } finally {
                        this.uploading = false;
                    }
                },

                triggerAudioUpload() { this.$refs.audioInput.click(); },

                handleAudio(event) { this.processAudio(event.target.files[0]); },
                handleAudioDrop(event) { this.processAudio(event.dataTransfer.files[0]); },

                processAudio(file) {
                    if (!file) return;
                    if (!file.type.startsWith('audio/') && !file.name.match(/\.(mp3|wav|m4a)$/i)) {
                        this.errorMessage = "Please select a valid audio file.";
                        return;
                    }
                    if (file.size > 10 * 1024 * 1024) {
                        this.errorMessage = "Audio file is too large (Max 10MB).";
                        return;
                    }
                    
                    this.errorMessage = '';
                    this.audioFile = file;
                    this.audioName = file.name;
                    this.audioStored = false;
                    
                    const url = URL.createObjectURL(file);
                    this.$nextTick(() => {
                        if(this.$refs.audioPreview) {
                            this.$refs.audioPreview.src = url;
                        }
                    });
                },

                async uploadStep2() {
                     // If we have stored audio and no new file, just proceed
                     if (this.audioStored && !this.audioFile) {
                        this.step = 3;
                        return;
                    }

                    if (!this.audioFile) {
                        this.errorMessage = "Please select an audio file.";
                        return;
                    }

                    this.uploading = true;
                    this.errorMessage = '';
                    
                    const formData = new FormData();
                    formData.append('audio', this.audioFile);

                    try {
                        const response = await fetch('{{ route('make-a-video.step2') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        });

                        if (!response.ok) {
                            const data = await response.json();
                            throw new Error(data.message || 'Audio upload failed');
                        }

                        // Success
                        this.audioStored = true;
                        this.step = 3;

                    } catch (e) {
                        this.errorMessage = e.message;
                    } finally {
                        this.uploading = false;
                    }
                },

                async submitFinal() {
                    this.step = 4;
                    this.uploading = true;
                    this.statusMessage = 'Starting processing...';
                    
                    try {
                        const response = await fetch('{{ route('make-a-video.process') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        
                        if (!response.ok) {
                            const data = await response.json();
                            throw new Error(data.message || 'Processing failed');
                        }
                        
                        const data = await response.json();
                        this.jobId = data.job_id;
                        this.startPolling();
                        
                    } catch (e) {
                        this.uploading = false;
                        this.step = 3;
                        this.errorMessage = e.message;
                    }
                },

                startPolling() {
                    this.uploading = false;
                    this.jobStatus = 'pending';
                    this.statusMessage = 'Queued for processing...';
                    
                    const poll = setInterval(async () => {
                        try {
                            const res = await fetch(`/make-a-video/${this.jobId}/status`);
                            if (!res.ok) throw new Error('Status check failed');
                            
                            const data = await res.json();
                            
                            if (data.status === 'processing') {
                                this.jobStatus = 'processing';
                                this.statusMessage = 'Rendering your SnapMusic (this usually takes 10-30s)...';
                            } else if (data.status === 'completed') {
                                clearInterval(poll);
                                this.jobStatus = 'completed';
                                this.videoUrl = `/make-a-video/${this.jobId}/stream`;
                                this.downloadUrl = `/make-a-video/${this.jobId}/download`;
                                this.step = 5;
                            } else if (data.status === 'failed') {
                                clearInterval(poll);
                                this.jobStatus = 'failed';
                                this.errorMessage = data.error_message || 'Video processing failed.';
                                this.step = 5;
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }, 2000);
                },

                reset() {
                    this.step = 1;
                    this.imageFile = null;
                    this.imagePreview = null;
                    this.imageStored = false;
                    this.audioFile = null;
                    this.audioName = null;
                    this.audioStored = false;
                    this.uploading = false;
                    this.jobId = null;
                    this.jobStatus = 'idle';
                    this.videoUrl = null;
                    this.downloadUrl = null;
                    this.errorMessage = '';
                },

                async shareVideo() {
                    if (!this.downloadUrl) {
                        alert('Video URL not available yet.');
                        return;
                    }
                    
                    const shareUrl = window.location.origin + this.downloadUrl;
                    
                    try {
                        if (navigator.share) {
                            await navigator.share({
                                title: 'My SnapMusic Video',
                                text: 'Check out this video I made with SnapMusic!',
                                url: shareUrl
                            });
                        } else {
                            await navigator.clipboard.writeText(shareUrl);
                            alert('SnapMusic link copied to clipboard!');
                        }
                    } catch (err) {
                        console.error('Share failed:', err);
                        alert('Could not share video. Please try manually copying the URL.');
                    }
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>