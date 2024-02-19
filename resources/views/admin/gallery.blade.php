{{--<div class="rounded bg-white mb-3 p-3 d-grid g-0 justify-content-between" style="grid-template-columns: repeat(auto-fill, 24%);">--}}
<div class="rounded bg-white mb-3 p-3">
    <div class="mb-5 d-grid g-0 justify-content-between" style="grid-template-columns: repeat(auto-fill, 24%);">
        @if($gallery)
            {!! $gallery !!}
        @endif
    </div>
    {!! $fields ?? '' !!}
</div>
