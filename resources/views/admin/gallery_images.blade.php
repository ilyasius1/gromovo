@if($gallery)
@foreach($gallery->images as $image)
    <div class="d-flex align-items-center rounded overflow-hidden mb-3 flex-wrap">
        @isset($image->attachment)
        <img src="{{ $image->attachment?->getRelativeUrlAttribute()  }}" alt="{{ $image->attachment?->original_name }}" class="w-100">
        @endisset
    </div>
@endforeach
@endif
