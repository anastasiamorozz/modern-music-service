@extends('layouts.app')

@section('content')

    <div class="my-3 p-3">
        <h1 class="display-5 fw-bold">{{ $trackDetails['title'] }}</h1>
        <div class="d-flex">

            <img class="me-2 rounded-circle" style="width: 40px; height: 40px;" src="{{ $trackDetails['artist']['picture_small'] }}" alt="Обкладинка альбому">
            <div class="d-flex">
                <p class="fs-4">{{ $trackDetails['artist']['name'] }}</p>
            </div>
        </div>
    </div>

    <div class="container-fluid d-flex justify-content-between">
        <div class="col-md-4">
            <div class=" border rounded-3">
                <img class="me-2 rounded" src="{{ $trackDetails['album']['cover_big'] }}" style="width: 510px; height: 500px;" alt="Обкладинка альбому" class="img-fluid">
            </div>
        </div>
        <div class="col-md-8 p-3">
                @if (!$userLikedTrack)
                <form action="{{ route('like.add', ['trackId' => $trackDetails['id']]) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-light"><i class="fa-regular fa-heart"></i> Like ({{$likes}})</button>
                </form>
            @else
                <form action="{{ route('like.remove', ['trackId' => $trackDetails['id']]) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-light"><i class="fa-solid fa-heart"></i> Unlike ({{$likes}})</button>
                </form>
            @endif


            <h1 class="fs-4 mb-4">Play song fragment <a href="{{ $trackDetails['link'] }}">(search this on Deezer)</a></h1>
            <audio controls class="w-100">
                <source src="{{ $trackDetails['preview'] }}" type="audio/mp3">
                Ваш браузер не підтримує програвання аудіо.
            </audio>
            <p>


                <div>


                    @auth
                    <hr class="my-4">
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-1">
                        @csrf
                        <input type="hidden" name="track_id" value="{{ $trackDetails['id'] }}">

                        <div class="mb-3">
                            <textarea class="form-control" name="content" id="comment" rows="3" placeholder="Type here..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-secondary w-100">Add comment</button>
                    </form>

                    @else
                        <p>Для коментування потрібно <a href="{{ route('login') }}">увійти</a>.</p>
                    @endauth

                    @foreach ($comments as $comment)
                    <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $comment->user->name }}</strong>
                            @if (auth()->check() && auth()->user()->id === $comment->user_id)
                                <form action="{{ route('comment.destroy', ['id' => $comment->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-dark btn-rounded"><i class="fa-solid fa-trash"></i></button>
                                </form>
                        @endif
                        </div>
                        <p>{{ $comment->content }}</p>

                    @endforeach
                </div>
                {{-- <div class="d-flex">
                    @auth
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <div class="input-group my-3 ">
                            <input type="text" class="form-control" placeholder="Add a comment...">
                        </div>
                    </form>

                    @endauth
                </div>
                @foreach ($comments as $comment)
                    <p>{{ $comment->content }} - {{ $comment->user->name }}</p>
                @endforeach --}}
            </p>
        </div>
    </div>

    {{-- <h1>{{ $trackDetails['title'] }}</h1>

    <p>Виконавець: {{ $trackDetails['artist']['name'] }}</p>
    <p>Альбом: {{ $trackDetails['album']['title'] }}</p>
    <p>Час треку: {{ $trackDetails['duration'] }} секунд</p>

    <audio controls>
        <source src="{{ $trackDetails['preview'] }}" type="audio/mp3">
        Ваш браузер не підтримує програвання аудіо.
    </audio> --}}
@endsection
