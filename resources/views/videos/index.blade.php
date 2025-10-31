<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Video Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Upload Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Upload Media Files</h3>
                    <form action="{{ route('videos.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Image File (JPG/PNG, max 10MB)
                            </label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept=".jpg,.jpeg,.png"
                                required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audio Upload -->
                        <div>
                            <label for="audio" class="block text-sm font-medium text-gray-700 mb-2">
                                Audio File (MP3/WAV, max 10MB)
                            </label>
                            <input
                                type="file"
                                name="audio"
                                id="audio"
                                accept=".mp3,.wav"
                                required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            >
                            @error('audio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Upload & Generate Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Video Jobs List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your Videos</h3>

                    @if ($jobs->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($jobs as $job)
                                        <tr data-job-id="{{ $job->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                #{{ $job->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap status-badge">
                                                @if ($job->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif ($job->status === 'processing')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Processing
                                                    </span>
                                                @elseif ($job->status === 'completed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Completed
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Failed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 duration-cell">
                                                @if ($job->duration)
                                                    {{ gmdate('i:s', $job->duration) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $job->created_at->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 actions-cell">
                                                @if ($job->isCompleted())
                                                    <a href="{{ route('videos.download', $job) }}" class="text-blue-600 hover:text-blue-900">
                                                        Download
                                                    </a>
                                                    <a href="{{ route('videos.stream', $job) }}" target="_blank" class="text-green-600 hover:text-green-900">
                                                        Preview
                                                    </a>
                                                @endif

                                                @if ($job->isFailed())
                                                    <span class="text-red-600" title="{{ $job->error_message }}">
                                                        Error
                                                    </span>
                                                @endif

                                                <form action="{{ route('videos.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
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
                    @else
                        <p class="text-gray-500 text-center py-8">
                            No videos yet. Upload your first image and audio file to get started!
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Real-time job status polling
        const processingJobs = @json($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());

        if (processingJobs.length > 0) {
            // Poll every 3 seconds
            const pollInterval = setInterval(checkJobStatuses, 3000);

            // Also check immediately
            checkJobStatuses();
        }

        async function checkJobStatuses() {
            const jobsToCheck = [...processingJobs];

            for (const jobId of jobsToCheck) {
                try {
                    const response = await fetch(`/videos/${jobId}/status`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) continue;

                    const data = await response.json();

                    // Update the UI based on status
                    updateJobRow(jobId, data);

                    // If job is completed or failed, remove from polling list
                    if (data.status === 'completed' || data.status === 'failed') {
                        const index = processingJobs.indexOf(jobId);
                        if (index > -1) {
                            processingJobs.splice(index, 1);
                        }

                        // If no more jobs to poll, reload page to show updated list
                        if (processingJobs.length === 0) {
                            setTimeout(() => location.reload(), 1000);
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

            // Update status badge
            const statusCell = row.querySelector('.status-badge');
            if (statusCell) {
                let badgeHtml = '';
                if (data.status === 'pending') {
                    badgeHtml = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>';
                } else if (data.status === 'processing') {
                    badgeHtml = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Processing...</span>';
                } else if (data.status === 'completed') {
                    badgeHtml = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>';
                } else if (data.status === 'failed') {
                    badgeHtml = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>';
                }
                statusCell.innerHTML = badgeHtml;
            }

            // Update duration
            const durationCell = row.querySelector('.duration-cell');
            if (durationCell && data.duration) {
                const minutes = Math.floor(data.duration / 60);
                const seconds = data.duration % 60;
                durationCell.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }

            // Update actions
            const actionsCell = row.querySelector('.actions-cell');
            if (actionsCell && data.status === 'completed') {
                actionsCell.innerHTML = `
                    <a href="/videos/${jobId}/download" class="text-blue-600 hover:text-blue-900">Download</a>
                    <a href="/videos/${jobId}/stream" target="_blank" class="text-green-600 hover:text-green-900">Preview</a>
                    <form action="/videos/${jobId}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this video?');">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                `;
            } else if (actionsCell && data.status === 'failed') {
                const errorTitle = data.error_message ? data.error_message.substring(0, 100) : 'Processing failed';
                actionsCell.innerHTML = `
                    <span class="text-red-600" title="${errorTitle}">Error</span>
                    <form action="/videos/${jobId}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this video?');">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                `;
            }
        }
    </script>
    @endpush
</x-app-layout>
