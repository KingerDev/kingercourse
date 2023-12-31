<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen
            allowfullscreen></iframe>
    <h3>{{ $video->title }} ({{ $video->getReadableDuration() }})</h3>
    <p>{{ $video->description }}</p>
    @if($video->alreadyWatchedByCurrentUser())
        <button wire:click="markVideoAsNotCompleted">Mark as not completed</button>
    @else
        <button wire:click="markVideoAsCompleted">Mark as completed</button>
    @endif

    <ul>
        @foreach($courseVideos as $video)
            <li>
                @if($this->isCurrentVideo($video))
                    {{ $video->title }}
                @else
                    <a href="{{ route('page.course-videos', ['course' => $video->course, 'video' => $video]) }}">
                        {{ $video->title }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>