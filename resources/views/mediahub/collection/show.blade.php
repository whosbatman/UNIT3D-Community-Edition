@extends('layout.default')

@section('title')
    <title>{{ page_title($collection->name) }} </title>
@endsection

@section('meta')
    <meta name="description" content="{{ $collection->name }}">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.index') }}" class="breadcrumb__link">
            {{ __('mediahub.title') }}
        </a>
    </li>
    <li class="breadcrumbV2">
        <a href="{{ route('mediahub.collections.index') }}" class="breadcrumb__link">
            {{ __('mediahub.collections') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $collection->name }}
    </li>
@endsection

@section('content')
    <div class="torrent box container single">
        <div class="movie-wrapper">
            <div class="movie-overlay"></div>

            <div class="movie-poster">
                <img src="{{ $collection->poster ? tmdb_image('poster_big', $collection->poster) : 'https://via.placeholder.com/400x600' }}"
                     class="img-responsive" id="meta-poster">
            </div>

            <div class="meta-info">
                <div class="tags">
                    {{ __('mediahub.collections') }}
                </div>

                <div class="movie-backdrop"
                     style="background-image: url('{{ $collection->backdrop ? tmdb_image('back_big', $collection->backdrop) : 'https://via.placeholder.com/960x540' }}');"></div>

                <div class="movie-top">
                    <h1 class="movie-heading">
                        <span class="text-bold">{{ $collection->name }}</span>
                    </h1>

                    <div class="movie-overview">
                        {{ $collection->overview }}
                    </div>
                </div>
                <div class="movie-bottom">
                    <a href="{{ route('torrents', ['collectionId' => $collection->id]) }}" role="button"
                       class="btn btn-sm btn-labeled btn-success">
                    <span class='btn-label'>
                        <i class='{{ config('other.font-awesome') }} fa-eye'></i> Collection Torrents List
                    </span>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <div class="panel panel-chat shoutbox">
            <div class="panel-heading">
                <h4><i class="{{ config("other.font-awesome") }} fa-film"></i> Movies</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-striped">
                    <tbody>
                    <tr>
                        <td>
                            <section class="recommendations">
                                @foreach($collection->movie->sortBy('release_date') as $movie)
                                    <div class="item mini backdrop mini_card col-md-3">
                                        <div class="image_content">
                                            @php
                                                $torrent_temp = App\Models\Torrent::where('tmdb', '=', $movie->id)
                                                ->whereIn('category_id', function ($query) {
                                                $query->select('id')->from('categories')->where('movie_meta', '=', true);
                                                })->first()
                                            @endphp
                                            <a href="{{ route('torrents.similar', ['category_id' => $torrent_temp->category_id, 'tmdb' => $movie->id]) }}">
                                                <div>
                                                    <img class="backdrop"
                                                         src="{{ tmdb_image('poster_mid', $movie->poster) }}">
                                                </div>
                                                <div style=" margin-top: 8px;">
                                                    <span class="badge-extra"><i
                                                                class="fas fa-calendar text-purple"></i> {{ __('common.year') }}: {{ substr($movie->release_date, 0, 4) }}</span>
                                                    <span class="badge-extra"><i class="fas fa-star text-gold"></i> {{ __('torrent.rating') }}: {{ $movie->vote_average }}</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </section>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="torrent box container" id="comments">
        <!-- Comments -->
        <div class="clearfix"></div>
        <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="panel panel-chat shoutbox">
                    <div class="panel-heading">
                        <h4>
                            <i class="{{ config('other.font-awesome') }} fa-comment"></i> {{ __('common.comments') }}
                        </h4>
                    </div>
                    <div class="panel-body no-padding">
                        <ul class="media-list comments-list">
                            @if (count($collection->comments) == 0)
                                <div class="text-center"><h4 class="text-bold text-danger"><i
                                                class="{{ config('other.font-awesome') }} fa-frown"></i> {{ __('common.no-comments') }}
                                        !</h4>
                                </div>
                            @else
                                @foreach ($collection->comments as $comment)
                                    <li class="media" style="border-left: 5px solid #01BC8C;">
                                        <div class="media-body">
                                            @if ($comment->anon == 1)
                                                <a href="#" class="pull-left" style="padding-right: 10px;">
                                                    <img src="{{ url('img/profile.png') }}" class="img-avatar-48">
                                                    <strong>{{ strtoupper(__('common.anonymous')) }}</strong></a> @if (auth()->user()->id == $comment->user->id || auth()->user()->group->is_modo)
                                                    <a href="{{ route('users.show', ['username' => $comment->user->username]) }}"
                                                       style="color:{{ $comment->user->group->color }};">(<span><i
                                                                    class="{{ $comment->user->group->icon }}"></i> {{ $comment->user->username }}</span>)</a> @endif
                                            @else
                                                <a href="{{ route('users.show', ['username' => $comment->user->username]) }}"
                                                   class="pull-left" style="padding-right: 10px;">
                                                    @if ($comment->user->image != null)
                                                        <img src="{{ url('files/img/' . $comment->user->image) }}"
                                                             alt="{{ $comment->user->username }}" class="img-avatar-48"></a>
                                                @else
                                                    <img src="{{ url('img/profile.png') }}"
                                                         alt="{{ $comment->user->username }}" class="img-avatar-48"></a>
                                                @endif
                                                <strong><a
                                                            href="{{ route('users.show', ['username' => $comment->user->username]) }}"
                                                            style="color:{{ $comment->user->group->color }};"><span><i
                                                                    class="{{ $comment->user->group->icon }}"></i> {{ $comment->user->username }}</span></a></strong> @endif
                                            <span class="text-muted"><small><em>{{ $comment->created_at->toDayDateTimeString() }} ({{ $comment->created_at->diffForHumans() }})</em></small></span>
                                            @if ($comment->user_id == auth()->id() || auth()->user()->group->is_modo)
                                                <div class="pull-right" style="display: inline-block;">
                                                    <a data-toggle="modal"
                                                       data-target="#modal-comment-edit-{{ $comment->id }}">
                                                        <button class="btn btn-circle btn-info">
                                                            <i class="{{ config('other.font-awesome') }} fa-pencil"></i>
                                                        </button>
                                                    </a>
                                                    <form action="{{ route('comment_delete', ['comment_id' => $comment->id]) }}"
                                                          method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-circle btn-danger">
                                                            <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            <div class="pt-5">
                                                @joypixels($comment->getContentHtml())
                                            </div>
                                        </div>
                                    </li>
                                    @include('partials.modals', ['comment' => $comment])
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Comments -->
            <br>
            <!-- Add comment -->
            <div class="col-md-12">
                <form role="form" method="POST" action="{{ route('comment_collection', ['id' => $collection->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">{{ __('common.your-comment') }}:</label>
                        <span class="badge-extra">BBCode {{ __('common.is-allowed') }}</span>
                        <span class="pull-right" x-data="{ emoji: false }">
                            <img src="{{ url('img/emoji-add.png') }}" width="32px" x-on:click="emoji = ! emoji">

                            <div style="position: absolute; z-index: 1;" x-show="emoji" @click.away="emoji = false">
                                <emoji-picker></emoji-picker>
                            </div>
                        </span>
                        <textarea id="editor" name="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">{{ __('common.submit') }}</button>
                    <label class="radio-inline"><strong>{{ __('common.anonymous') }} {{ __('common.comment') }}
                            :</strong></label>
                    <input type="radio" value="1" name="anonymous"> {{ __('common.yes') }}
                    <input type="radio" value="0" checked="checked" name="anonymous"> {{ __('common.no') }}
                </form>
            </div>
            <!-- /Add comment -->
        </div>
    </div>
@endsection
