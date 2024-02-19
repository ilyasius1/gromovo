{{--@section($gallery)--}}
    @if($gallery)
    @foreach($gallery->images as $image)
        <div class="d-flex align-items-center rounded overflow-hidden mb-3 flex-wrap">
            @isset($image->attachment)
{{--            <p>{{ dump($image->attachment?->getRelativeUrlAttribute()) }}</p>--}}
{{--            <p>{{ dump($image->attachment?->url) }}</p>--}}
{{--            <p>{{ dump($image->attachment?->url) }}</p>--}}
            <img src="{{ $image->attachment?->getRelativeUrlAttribute()  }}" alt="{{ $image->attachment?->original_name }}" class="w-100">
            @endisset
        </div>
    @endforeach
    @endif
{{--    @foreach($fields as $field)--}}

{{--    @endforeach--}}
{{--@endsection--}}
