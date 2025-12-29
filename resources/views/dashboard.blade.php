<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('videos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Create New Video') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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
                                                        <a href="{{ route('videos.download', $job) }}" class="text-indigo-600 hover:text-indigo-900">Download</a>
                                                        <a href="{{ route('videos.stream', $job) }}" target="_blank" class="text-gray-600 hover:text-gray-900">Preview</a>
                                                    @endif
                                                    
                                                    @if ($job->isFailed())
                                                        <span class="text-red-600 cursor-help" title="{{ $job->error_message }}">Error</span>
                                                    @endif

                                                    <form action="{{ route('videos.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this video?');">
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
                                <a href="{{ route('videos.index') }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">Create your first video</a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Poll for status updates
        document.addEventListener('DOMContentLoaded', () => {
            const processingJobs = @json($jobs->whereIn('status', ['pending', 'processing'])->pluck('id')->toArray());

            if (processingJobs.length > 0) {
                const interval = setInterval(() => {
                    checkStatuses(processingJobs, interval);
                }, 3000);
            }
        });

        async function checkStatuses(jobs, interval) {
            if (jobs.length === 0) {
                clearInterval(interval);
                return;
            }

            for (const jobId of [...jobs]) {
                try {
                    const res = await fetch(`/videos/${jobId}/status`);
                    if (!res.ok) continue;
                    const data = await res.json();

                    updateRow(jobId, data);

                    if (data.status === 'completed' || data.status === 'failed') {
                        const idx = jobs.indexOf(jobId);
                        if (idx > -1) jobs.splice(idx, 1);
                        
                        // If all done, reload to ensure full UI sync (optional)
                        if (jobs.length === 0) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        }

        function updateRow(jobId, data) {
            const row = document.querySelector(`tr[data-job-id="${jobId}"]`);
            if (!row) return;

            // Update status
            const statusCell = row.querySelector('.status-cell');
            if (statusCell) {
                let html = '';
                if (data.status === 'pending') {
                    html = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>';
                } else if (data.status === 'processing') {
                    html = `
                        <div class="w-full max-w-xs">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-medium text-blue-700">Processing...</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-blue-600 h-1.5 rounded-full animate-pulse" style="width: 100%"></div>
                            </div>
                        </div>`;
                } else if (data.status === 'completed') {
                    html = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>';
                } else if (data.status === 'failed') {
                    html = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>';
                }
                statusCell.innerHTML = html;
            }

            // Update duration
            if (data.duration) {
                const durationCell = row.querySelector('.duration-cell');
                if (durationCell) {
                    const mins = Math.floor(data.duration / 60).toString().padStart(2, '0');
                    const secs = (data.duration % 60).toString().padStart(2, '0');
                    durationCell.textContent = `${mins}:${secs}`;
                }
            }
            
            // Actions are harder to update dynamically without reconstructing the whole cell with CSRF tokens etc.
            // Relying on the reload in checkStatuses for final action buttons.
        }
    </script>
    @endpush
</x-app-layout>