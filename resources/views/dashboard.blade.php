<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('make-a-video.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Create New Video') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifications -->
            <div class="mb-8" x-data="{ showSuccess: true, showCompleted: true, showError: true, showErrors: true }">
                @if (session('success'))
                    <div x-show="showSuccess" class="relative rounded-xl bg-green-500/10 border border-green-500/20 p-4 text-green-800 mb-4 shadow-sm">
                        <div class="pr-8">{{ session('success') }}</div>
                        <button @click="showSuccess = false" class="absolute top-4 right-4 text-green-600 hover:text-green-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('video_completed'))
                    @php $data = session('video_completed'); @endphp
                    <div x-show="showCompleted" class="relative rounded-xl bg-emerald-50 border border-emerald-200 p-5 text-emerald-900 mb-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 border border-emerald-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg leading-tight">Your video is ready!</p>
                                <p class="text-emerald-700/80 text-sm mt-0.5">Video #{{ $data['id'] }} has been processed successfully.</p>
                                <div class="mt-3 flex gap-4 text-sm font-semibold">
                                    <a href="{{ $data['download_url'] }}" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download MP4
                                    </a>
                                    <a href="{{ $data['stream_url'] }}" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white hover:bg-gray-50 text-gray-700 transition border border-gray-200 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button @click="showCompleted = false" class="text-emerald-400 hover:text-emerald-600 p-2 rounded-lg hover:bg-emerald-100 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-show="showError" class="relative rounded-xl bg-red-50 border border-red-100 p-4 text-red-800 mb-4 shadow-sm">
                        <div class="pr-8">{{ session('error') }}</div>
                        <button @click="showError = false" class="absolute top-4 right-4 text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div x-show="showErrors" class="relative rounded-xl bg-red-50 border border-red-100 p-4 text-red-800 mb-4 shadow-sm">
                        <ul class="list-disc list-inside pr-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button @click="showErrors = false" class="absolute top-4 right-4 text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Filters -->
            <div class="mb-6 flex justify-end">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <label for="date" class="text-sm font-medium text-gray-700">Filter by Date:</label>
                    <input type="date" name="date" id="date" value="{{ request('date') }}" 
                           class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                           onchange="this.form.submit()">
                    @if(request('date'))
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Clear</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Recent Videos</h3>

                    @if($jobs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($jobs as $job)
                                        <tr data-job-id="{{ $job->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $job->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $job->created_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-cell">
                                                @if ($job->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif ($job->status === 'processing')
                                                    <div class="w-full max-w-xs">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <span class="text-xs font-medium text-blue-700">Processing...</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                            <div class="bg-blue-600 h-1.5 rounded-full animate-pulse" style="width: 100%"></div>
                                                        </div>
                                                    </div>
                                                @elseif ($job->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Failed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 duration-cell">
                                                {{ $job->duration ? gmdate('i:s', $job->duration) : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium actions-cell">
                                                <div class="flex items-center gap-3">
                                                    @if ($job->isCompleted())
                                                        <a href="{{ route('make-a-video.download', $job) }}" class="text-indigo-600 hover:text-indigo-900">Download</a>
                                                        <a href="{{ route('make-a-video.stream', $job) }}" target="_blank" class="text-gray-600 hover:text-gray-900">Preview</a>
                                                    @endif
                                                    
                                                    @if ($job->isFailed())
                                                        <span class="text-red-600 cursor-help" title="{{ $job->error_message }}">Error</span>
                                                    @endif

                                                    <form action="{{ route('make-a-video.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $jobs->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No videos found.</p>
                            @if(request('date'))
                                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">Clear filters</a>
                            @else
                                <a href="{{ route('make-a-video.index') }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">Create your first video</a>
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