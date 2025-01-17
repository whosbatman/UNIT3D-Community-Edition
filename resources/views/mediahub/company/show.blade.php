@extends('layout.default')

@section('title')
    <title>{{ page_title($company->name) }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $company->name }} {{ __('mediahub.networks') }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.companies.index') }}" class="breadcrumb__link">
            {{ __('mediahub.companies') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $company->name }}
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="block">
            <div style="width: 100% !important; display: table !important;">
                <div class="header mediahub" style="width: 100% !important; display: table-cell !important;">
                    <h1 class="text-center"
                        style="font-family: Shrikhand, cursive; font-size: 4em; font-weight: 400; margin: 10px 0 20px;">
                        {{ $company->name }}
                    </h1>
                    <h2 class="text-center" style="margin: 0;">{{ $company->tv_count }} {{ __('mediahub.shows') }}
                        | {{ $company->movie_count }} {{ __('mediahub.movies') }}</h2>
                    @foreach($shows as $show)
                        <div class="col-md-12">
                            <div class="card is-torrent">
                                <div class="card_head">
                                    <span class="badge-user text-bold" style="float:right;">
                                        {{ $show->number_of_seasons }} {{ __('mediahub.seasons') }}
                                    </span>
                                    <span class="badge-user text-bold" style="float:right;">
                                        {{ $show->number_of_episodes }} {{ __('mediahub.episodes') }}
                                    </span>
                                </div>
                                <div class="card_body">
                                    <div class="body_poster">
                                        <img src="{{ isset($show->poster) ? tmdb_image('poster_mid', $show->poster) : 'https://via.placeholder.com/200x300' }}"
                                             class="show-poster">
                                    </div>
                                    <div class="body_description">
                                        <h3 class="description_title">
                                            <a href="{{ route('mediahub.shows.show', ['id' => $show->id]) }}">{{ $show->name }}
                                                <span class="text-bold text-pink"> {{ substr($show->first_air_date, 0, 4) }}</span>
                                            </a>
                                        </h3>
                                        @if ($show->genres)
                                            @foreach ($show->genres as $genre)
                                                <span class="genre-label">{{ $genre->name }}</span>
                                            @endforeach
                                        @endif
                                        <p class="description_plot">
                                            {{ $show->overview }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card_footer">
                                    <div style="float: left;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if ($movies->isNotEmpty())
                        <div class="col-md-12">
                            <h2 class="text-center">Movies</h2>
                        </div>
                    @endif
                    @foreach($movies as $movie)
                        <div class="col-md-12">
                            <div class="card is-torrent">
                                <div class="card_head">
                                    <span class="badge-user text-bold" style="float:right;">
                                        <i class="far fa-fw fa-clock text-green"></i> {{ $movie->runtime }} mins
                                    </span>
                                </div>
                                <div class="card_body">
                                    <div class="body_poster">
                                        <img src="{{ isset($movie->poster) ? tmdb_image('poster_mid', $movie->poster) : 'https://via.placeholder.com/200x300' }}"
                                             class="show-poster">
                                    </div>
                                    <div class="body_description">
                                        <h3 class="description_title">
                                            <a href="{{ route('mediahub.movies.show', ['id' => $movie->id]) }}">{{ $movie->title }}
                                                <span class="text-bold text-pink"> {{ substr($movie->release_date, 0, 4) }}</span>
                                            </a>
                                        </h3>
                                        @foreach ($movie->genres as $genre)
                                            <span class="genre-label">{{ $genre->name }}</span>
                                        @endforeach
                                        <p class="description_plot">
                                            {{ $movie->overview }}
                                        </p>
                                    </div>
                                </div>
                                <div class="card_footer">
                                    <div style="float: left;">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center">
                        {{ ($company->tv_count > 25 && $company->tv_count > $company->movie_count) ? $shows->links() : $movies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
