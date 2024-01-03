@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between">
    <div class="my-3 p-3 bg-white rounded shadow-sm col-12">
        <h2 class="border-bottom pb-2 mb-0">Most liked</h2>
        @foreach ($trackDetails as $index => $track)
            <div class="d-flex justify-content-between text-body-secondary pt-3">
                <div class="d-flex">
                    <span class=" m-2">{{ $index + 1 }}</span>
                    <img class="me-2 rounded" style="width: 40px; height: 40px;" src="{{ $track['album']['cover_medium'] }}" alt="Обкладинка альбому" class="img-fluid">
                    <h2 class="pb-3 mb-0 lh-sm border-bottom">
                        <strong class="d-block text-gray-dark">
                            <a href="{{ route('track.detail', ['id' => $track['id']]) }}">{{ $track['title'] }}</a>
                        </strong>
                        {{ $track['artist']['name'] }} • {{ $track['album']['title'] }}
                    </h2>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
