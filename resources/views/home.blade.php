@extends('layouts.app')

@section('content')

<div class="my-3 p-3 bg-white rounded shadow-sm">
    <form action="{{ route('search') }}" method="GET" class="input-group">
        <input type="search" name="query" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</div>



    <div class="d-flex justify-content-between">
        <div class="my-3 p-3 bg-white rounded shadow-sm col-8">
            <h2 class="border-bottom pb-2 mb-0">Recomendations</h2>
                @foreach ($tracks as $track)
                <div class="d-flex justify-content-between text-body-secondary pt-3">
                    <div class="d-flex">
                        <img class="me-2 rounded" style="width: 40px; height: 40px;" src="{{ $track['album']['cover_medium'] }}" alt="Обкладинка альбому" class="img-fluid">
                        <h2 class="pb-3 mb-0 lh-sm border-bottom">
                            <strong class="d-block text-gray-dark">
                                <a href="{{ route('track.detail', ['id' => $track['id']]) }}">{{ $track['title'] }}</a>
                            </strong>
                            {{ $track['artist']['name'] }} • {{ $track['album']['title'] }}
                        </h2>
                    </div>
                    <div class="d-flex align-items-center">
                        <audio controls>
                            <source src="{{ $track['preview'] }}" type="audio/mp3">
                            Ваш браузер не підтримує програвання аудіо.
                        </audio>

                        {{-- @if (Auth::check())
                        @php
                            $liked = auth()->user()->likes->contains('track_id', $track['id']);
                        @endphp
                        <button
                            type="button"
                            class="btn btn-floating rounded-circle d-flex align-items-center justify-content-center like-button"
                            data-track-id="{{ $track['id'] }}"
                            data-liked="{{ $liked ? 'true' : 'false' }}"
                            data-bs-ripple-color="dark"
                            data-bs-toggle="button"
                            style="width: 30px; height: 30px;"
                        >
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    @endif --}}

                    {{-- Display the number of likes --}}
                    {{-- @if (Auth::check() && $track->likes()->where('user_id', Auth::user()->id)->where('item_type', 'post')->count() > 0)
                    <i class="fa-solid fa-heart like-btn"></i>
                    @else
                        <i class="fa-regular fa-heart like-btn"></i>
                    @endif --}}

                    </div>
                </div>
            @endforeach





        </div>
        <div class="my-3 p-3 bg-white rounded shadow-sm col-4">
            <ul class="list-group list-group-light justify-content-center">
                <li class="list-group-item">
                    <a href="{{route('track.rank')}}"><i class="fa-regular fa-heart"></i> Most liked tracks</a>
                </li>
            </ul>
        </div>

    </div>


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeButtons = document.querySelectorAll('.like-button');

            likeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const trackId = this.getAttribute('data-track-id');
                    const isLiked = this.getAttribute('data-liked') === 'true';

                    // Ваш AJAX-запит для додавання або видалення лайка
                    const url = isLiked ? `/like/remove/${trackId}` : `/like/add/${trackId}`;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Оновіть вигляд кнопки та кількості лайків
                        if (data.success) {
                            this.setAttribute('data-liked', data.isLiked.toString());
                            this.classList.toggle('btn-danger', data.isLiked);
                            const likesCountElement = document.getElementById(`likes-count-${trackId}`);

                            if (likesCountElement) {
                                // Викликати метод для отримання кількості лайків
                                fetch(`/like/count/${trackId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        likesCountElement.innerText = data.likesCount;
                                    })
                                    .catch(error => {
                                        console.error('Помилка запиту:', error);
                                    });
                            } else {
                                console.error('Елемент з id не знайдено:', trackId);
                            }
                        } else {
                            console.error('Помилка обробки лайка');
                        }
                    })
                    .catch(error => {
                        console.error('Помилка запиту:', error);
                    });
                });
            });
        });
    </script> --}}

@endsection
