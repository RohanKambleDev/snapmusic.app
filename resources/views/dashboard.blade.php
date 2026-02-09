<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('make-a-video.index') }}" class="group relative px-6 py-2 rounded-full bg-white text-gray-900 font-bold shadow-lg hover:shadow-white/10 transition-all duration-300 hover:-translate-y-0.5">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Video
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 relative overflow-hidden">
        <!-- Background Ambient Effects -->
        <div class="fixed inset-0 pointer-events-none -z-10">
            <div class="absolute top-[-10%] right-[-10%] w-[30%] h-[30%] bg-purple-600/10 rounded-full blur-[100px] animate-blob"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-[30%] h-[30%] bg-blue-600/10 rounded-full blur-[100px] animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifications -->
            <div class="mb-8 space-y-4" x-data="{ 
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
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="relative rounded-2xl p-4 border backdrop-blur-md shadow-lg flex items-start gap-3"
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

                @if (session('video_completed'))
                    @php $data = session('video_completed'); @endphp
                    <div x-show="showCompleted" class="relative rounded-2xl bg-emerald-500/10 border border-emerald-500/20 p-5 text-emerald-100 mb-4 flex items-center justify-between shadow-2xl backdrop-blur-md">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg leading-tight text-white">Your video is ready!</p>
                                <p class="text-emerald-300/60 text-sm mt-0.5">Video #{{ $data['id'] }} has been processed successfully.</p>
                                <div class="mt-4 flex gap-3 text-sm font-semibold">
                                    <a href="{{ $data['download_url'] }}" class="flex items-center gap-1.5 px-4 py-2 rounded-full bg-emerald-500 text-black hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download
                                    </a>
                                    <a href="{{ $data['stream_url'] }}" target="_blank" class="flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/5 hover:bg-white/10 text-white transition border border-white/10 backdrop-blur-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button @click="showCompleted = false" class="text-emerald-400/50 hover:text-emerald-400 p-2 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                <!-- Errors omitted for brevity, same pattern -->
            </div>

            <!-- Filters -->
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h3 class="text-xl font-bold text-white">Your Creations</h3>
                    <p class="text-gray-500 text-sm">Manage and download your generated videos.</p>
                </div>
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-md">
                    <label for="date" class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-2">Filter:</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                           class="bg-transparent border-none text-white text-sm focus:ring-0 cursor-pointer"
                           onchange="this.form.submit()">
                    @if(request('date'))
                        <a href="{{ route('dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 font-bold mr-2">CLEAR</a>
                    @endif
                </form>
            </div>

            <div class="bg-gray-900/50 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-0">
                    @if($jobs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-white/5">
                                <thead class="bg-white/5 uppercase tracking-wider text-[10px] font-bold text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 text-left">Preview</th>
                                        <th scope="col" class="px-6 py-4 text-left">Details</th>
                                        <th scope="col" class="px-6 py-4 text-left">Status</th>
                                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach ($jobs as $job)
                                        <tr data-job-id="{{ $job->id }}" class="group hover:bg-white/[0.02] transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="relative h-16 w-28 rounded-xl overflow-hidden border border-white/10 group-hover:border-purple-500/50 transition-colors bg-black/40">
                                                    @if($job->thumbnail_path)
                                                        <img src="{{ route('make-a-video.thumbnail', $job) }}" alt="Thumbnail" class="h-full w-full object-cover">
                                                    @else
                                                        <div class="h-full w-full flex items-center justify-center text-white/10">
                                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v8a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-white">#{{ $job->id }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ $job->created_at->format('M d, Y • H:i') }}</div>
                                                <div class="text-[10px] text-purple-400/80 font-mono mt-1 duration-cell">
                                                    {{ $job->duration ? gmdate('i:s', $job->duration) : '--:--' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-cell">
                                                @if ($job->status === 'pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">
                                                        Pending
                                                    </span>
                                                @elseif ($job->status === 'processing')
                                                    <div class="w-32">
                                                        <div class="flex items-center justify-between mb-1.5">
                                                            <span class="text-[10px] font-bold text-blue-400 uppercase tracking-widest">Rendering</span>
                                                        </div>
                                                        <div class="w-full bg-white/5 rounded-full h-1 overflow-hidden">
                                                            <div class="bg-blue-500 h-full rounded-full animate-pulse shadow-[0_0_10px_rgba(59,130,246,0.5)]" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                @elseif ($job->status === 'completed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20">
                                                        Failed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium actions-cell">
                                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @if ($job->isCompleted())
                                                        <a href="{{ route('make-a-video.download', $job) }}" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-white transition border border-white/10" title="Download">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        </a>
                                                        <a href="{{ route('make-a-video.stream', $job) }}" target="_blank" class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-white transition border border-white/10" title="Preview">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        </a>
                                                    @endif
                                                    
                                                    @if ($job->isFailed())
                                                        <div class="p-2 text-red-400 cursor-help" title="{{ $job->error_message }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                    @endif

                                                    <form action="{{ route('make-a-video.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Permanently delete this video?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 hover:bg-red-500/20 text-red-400 transition border border-red-500/20" title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 border-t border-white/5">
                            {{ $jobs->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-20">
                            <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-600">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2-2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-white">No videos yet</h4>
                            <p class="text-gray-500 mt-2 max-w-xs mx-auto">Create your first video and it will appear here in your dashboard.</p>
                            @if(request('date'))
                                <a href="{{ route('dashboard') }}" class="text-purple-400 hover:text-purple-300 font-bold mt-6 inline-block">Clear all filters</a>
                            @else
                                <a href="{{ route('make-a-video.index') }}" class="mt-8 px-8 py-3 rounded-full bg-white text-black font-bold hover:scale-105 transition-transform inline-block">
                                    Start Creating
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.processingJobs = @json($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());
    </script>
    @vite(['resources/js/job-status.js'])
    @endpush
</x-app-layout>