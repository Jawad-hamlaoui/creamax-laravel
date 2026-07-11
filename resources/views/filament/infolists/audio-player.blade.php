<div>
    @if ($record->audio_path)
        <audio controls preload="none" style="width: 100%;">
            <source src="{{ route('admin.contact-messages.audio', $record) }}">
            Votre navigateur ne prend pas en charge la lecture audio.
        </audio>
        @if ($record->audio_duration_seconds)
            <p class="text-sm text-gray-500 mt-1">Durée : {{ $record->audio_duration_seconds }} s</p>
        @endif
    @endif
</div>
