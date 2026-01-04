<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Video Job Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Job ID: {{ $videoJob->id }}</h3>
                    <p>Status: {{ $videoJob->status }}</p>
                    <p>Created: {{ $videoJob->created_at }}</p>
                    
                    @if($videoJob->thumbnail_path)
                        <img src="{{ route('make-a-video.thumbnail', $videoJob) }}" alt="Thumbnail" class="mt-4 h-32 rounded">
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
