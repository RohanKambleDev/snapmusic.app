<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('make-a-video.index') }}" class="group relative px-6 py-2.5 rounded-full bg-white text-gray-900 font-bold shadow-lg hover:shadow-white/20 hover:scale-105 transition-all duration-300">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create SnapMusic
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 relative min-h-screen">
        <!-- Background Ambient Effects -->
        <div class="fixed inset-0 pointer-events-none -z-10 overflow-hidden">
            <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/10 rounded-full blur-[120px] animate-blob"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Notifications Area -->
            <div class="space-y-4" x-data="{ 
                notifications: [],
                add(msg, type = 'success', duration = 5000) {
                    const id = Date.now();
                    this.notifications.push({ id, msg, type });
                    if (duration) setTimeout(() => this.remove(id), duration);
                },
                remove(id) {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }
            }"
            @if(session('success')) x-init="add('{{ session('success') }}', 'success', 5000)" @endif
            @if(session('error')) x-init="add('{{ session('error') }}', 'error', 10000)" @endif
            >
                <template x-for="note in notifications" :key="note.id">
                    <div x-show="true" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         class="relative rounded-xl p-4 border backdrop-blur-md shadow-lg flex items-start gap-3 max-w-2xl mx-auto"
                         :class="{
                             'bg-green-500/10 border-green-500/20 text-green-200': note.type === 'success',
                             'bg-red-500/10 border-red-500/20 text-red-200': note.type === 'error'
                         }">
                        <div class="flex-shrink-0 mt-0.5">
                            <template x-if="note.type === 'success'">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </template>
                            <template x-if="note.type === 'error'">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </template>
                        </div>
                        <div class="flex-1 text-sm font-medium" x-text="note.msg"></div>
                        <button @click="remove(note.id)" class="text-current opacity-50 hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </template>

                <!-- Video Completed Notification -->
                @if (session('video_completed'))
                    @php $data = session('video_completed'); @endphp
                    <div x-data="{ show: true }" x-show="show" class="relative rounded-2xl bg-emerald-500/10 border border-emerald-500/20 p-5 text-emerald-100 flex flex-col sm:flex-row items-center justify-between shadow-2xl backdrop-blur-md gap-4 max-w-3xl mx-auto">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg leading-tight text-white">Audio Image Ready!</p>
                                <p class="text-emerald-300/60 text-sm mt-0.5">Audio Image #{{ $data['id'] }} processed successfully.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 text-sm font-semibold w-full sm:w-auto justify-end">
                            <a href="{{ $data['download_url'] }}" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-500 text-black hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20 flex-1 sm:flex-initial">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download
                            </a>
                            <a href="{{ $data['stream_url'] }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-white transition border border-white/10 backdrop-blur-sm flex-1 sm:flex-initial">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Preview
                            </a>
                            <button @click="show = false" class="text-emerald-400/50 hover:text-emerald-400 p-2 rounded-lg transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Filters & Controls -->
            <div class="bg-gray-900/50 backdrop-blur-xl border border-white/10 rounded-3xl p-4 sm:p-6 shadow-xl">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-1">Your Library</h3>
                        <p class="text-gray-400 text-sm">Manage, filter, and organize your generated audio images.</p>
                    </div>
                    
                    <form method="GET" action="{{ route('dashboard') }}" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
                        <!-- Search -->
                        <div class="relative group flex-1 sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500 group-focus-within:text-purple-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID..." 
                                   class="block w-full pl-10 pr-3 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 sm:text-sm transition-all shadow-inner">
                        </div>

                        <!-- Status Filter -->
                        <div class="relative flex-1 sm:w-40">
                            <select name="status" onchange="this.form.submit()" 
                                    class="block w-full pl-3 pr-10 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 sm:text-sm appearance-none cursor-pointer transition-all shadow-inner">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="relative flex-1 sm:w-40">
                            <select name="sort" onchange="this.form.submit()" 
                                    class="block w-full pl-3 pr-10 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 sm:text-sm appearance-none cursor-pointer transition-all shadow-inner">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest First</option>
                                <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                            </div>
                        </div>

                        @if(request()->anyFilled(['search', 'status', 'date']) || request('sort') !== 'created_at')
                            <a href="{{ route('dashboard') }}" class="flex items-center justify-center px-4 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl border border-red-500/20 transition-colors text-sm font-medium whitespace-nowrap">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Video Grid -->
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($jobs as $job)
                        <div class="video-card group relative bg-gray-900/40 backdrop-blur-md border border-white/5 rounded-2xl overflow-hidden hover:border-purple-500/30 hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 flex flex-col" data-job-id="{{ $job->id }}">
                            
                            <!-- Thumbnail Area -->
                            <div class="aspect-video relative overflow-hidden bg-black/50">
                                @if($job->thumbnail_path)
                                    <img src="{{ route('make-a-video.thumbnail', $job) }}" alt="Video Thumbnail" class="w-full h-full object-cover object-left-top transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-white/10 group-hover:text-white/20 transition-colors">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                @endif

                                <!-- Duration Badge (Bottom Right) -->
                                <div class="absolute bottom-3 right-3">
                                    <span class="px-2 py-1 rounded bg-black/60 text-white text-[10px] font-mono backdrop-blur-sm">
                                        {{ $job->duration ? gmdate('i:s', $job->duration) : '--:--' }}
                                    </span>
                                </div>

                                @if($job->isCompleted())
                                    <a href="{{ route('make-a-video.stream', $job) }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white/30 hover:scale-110 transition-all shadow-lg border border-white/20">
                                            <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        </div>
                                    </a>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-bold text-white text-sm truncate mr-2">Audio Image #{{ $job->id }}</h4>
                                    
                                    <!-- Status Badge -->
                                    <div class="status-badge text-right ml-auto shrink-0">
                                        @if ($job->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 shadow-sm">
                                                <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Pending
                                            </span>
                                        @elseif ($job->status === 'processing')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20 shadow-sm">
                                                <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Processing
                                            </span>
                                        @elseif ($job->status === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm">
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20 shadow-sm">
                                                Failed
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-[11px] text-gray-500 font-medium">{{ $job->created_at->format('M d, Y • h:i A') }}</p>
                                
                                <div class="mt-auto pt-4 flex items-center justify-between gap-2 border-t border-white/5">
                                    @if($job->isCompleted())
                                        <a href="{{ route('make-a-video.download', $job) }}" class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg bg-white/5 hover:bg-white/10 text-xs font-medium text-white transition-colors border border-white/5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Download
                                        </a>
                                    @endif

                                    <form action="{{ route('make-a-video.destroy', $job) }}" method="POST" class="{{ $job->isCompleted() ? '' : 'w-full' }}" onsubmit="return confirm('Permanently delete this audio image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Delete Audio Image" class="w-full flex items-center justify-center gap-1.5 py-2 rounded-lg bg-red-500/5 hover:bg-red-500/10 text-xs font-medium text-red-400 transition-colors border border-red-500/10 hover:border-red-500/20" title="Delete Audio Image">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            @if(!$job->isCompleted()) Delete @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-24 h-24 bg-gray-800/50 rounded-full flex items-center justify-center mb-6 ring-4 ring-white/5">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v8a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No audio images found</h3>
                    <p class="text-gray-400 max-w-sm mx-auto mb-8">
                        @if(request()->anyFilled(['search', 'status', 'date']))
                            We couldn't find any audio images matching your filters. Try adjusting your search criteria.
                        @else
                            Start your journey by creating your first audio image. It's fast, easy, and free.
                        @endif
                    </p>
                    
                    @if(request()->anyFilled(['search', 'status', 'date']))
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-semibold transition border border-white/10">
                            Clear Filters
                        </a>
                    @else
                        <a href="{{ route('make-a-video.index') }}" class="px-8 py-3 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold shadow-lg shadow-purple-600/20 hover:shadow-purple-600/40 hover:scale-105 transition-all">
                            Create SnapMusic Now
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        window.processingJobs = @json($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());
    </script>
    @vite(['resources/js/job-status.js'])
    @endpush
</x-app-layout>