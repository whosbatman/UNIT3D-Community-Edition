@extends('layout.default')

@section('title')
    <title>{{ page_title(__('common.search')) }} </title>
@endsection

@section('meta')
    <meta name="description" content="Forum Search">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('forums.index') }}" class="breadcrumb__link">
            {{ __('forum.forums') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ __('common.search') }}
    </li>
@endsection

@section('nav-tabs')
    @include('forum.buttons')
@endsection

@section('content')
    <div class="box container">
        <div class="forum-categories">
            <table class="table table-bordered table-hover">
                <thead class="no-space">
                <tr class="no-space">
                    <td colspan="5" class="no-space">
                        <div class="header gradient teal some-padding">
                            <div class="inner_content">
                                <h1 class="no-space">{{ __('forum.forum') }} {{ __('forum.forums-post-search') }}</h1>
                            </div>
                        </div>
                    </td>
                </tr>
                </thead>
                <thead class="no-space">
                <tr>
                    <td colspan="5">
                        <div>
                            <div class="box">
                                <div class="container well search mt-5 fatten-me table-me"
                                     style="width: 90% !important; margin: auto !important;">
                                    <form role="form" method="GET" action="{{ route('forum_search_form') }}"
                                          class="form-horizontal form-condensed form-torrent-search form-bordered table-me">
                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="name"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('forum.topic') }}</label>
                                            <div class="col-sm-9 fatten-me">
                                                <label>
                                                    <input type="text" name="name" placeholder="{{ __('forum.topic') }}"
                                                           value="{{ isset($params) && is_array($params) && array_key_exists('name', $params) ? $params['name'] : '' }}"
                                                           class="form-control">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="body"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('forum.post') }}</label>
                                            <div class="col-sm-9 fatten-me">
                                                <label>
                                                    <input type="text" name="body" placeholder="{{ __('forum.post') }}"
                                                           value="{{ isset($params) && is_array($params) && array_key_exists('body', $params) ? $params['body'] : '' }}"
                                                           class="form-control">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="sort"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('common.forum') }}</label>
                                            <div class="col-sm-9 fatten-me">
                                                <label for="category"></label><select id="category" name="category"
                                                                                      class="form-control">
                                                    <option value="">{{ __('forum.select-all-forum') }}</option>
                                                    @foreach ($categories as $category)
                                                        @if ($category->getPermission() != null &&
                                                            $category->getPermission()->show_forum == true &&
                                                            $category->getForumsInCategory()->count() > 0)
                                                            <option value="{{ $category->id }}"
                                                                    {{ isset($params) && is_array($params) && array_key_exists('category', $params) && $params['category'] == $category->id ? 'SELECTED' : '' }}>
                                                                {{ $category->name }}</option>
                                                            @foreach ($category->getForumsInCategory()->sortBy('position') as
                                                                $categoryChild)
                                                                @if ($categoryChild->getPermission() != null &&
                                                                    $categoryChild->getPermission()->show_forum == true)
                                                                    <option value="{{ $categoryChild->id }}"
                                                                            {{ isset($params) && is_array($params) && array_key_exists('category', $params) && $params['category'] == $categoryChild->id ? 'SELECTED' : '' }}>
                                                                        &raquo; {{ $categoryChild->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="type"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('forum.label') }}</label>
                                            <div class="col-sm-10">
    
                                                    <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('implemented',$params) &&
                                                                $params['implemented'] == 1)
                                                                <input type="checkbox" value="1" name="implemented"
                                                                       CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-check text-purple"></span>
                                                                {{ __('forum.implemented') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="implemented">
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-check text-purple"></span>
                                                                {{ __('forum.implemented') }}
                                                            @endif
                                                        </label>
                                                    </span>


                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('approved',$params) && $params['approved'] ==
                                                                1)
                                                                <input type="checkbox" value="1" name="approved"
                                                                       CHECKED> <span
                                                                        class="{{ config('other.font-awesome') }} fa-tag text-green"></span>
                                                                {{ __('forum.approved') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="approved"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-tag text-green"></span>
                                                                {{ __('forum.approved') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('denied',$params) && $params['denied'] == 1)
                                                                <input type="checkbox" value="1" name="denied" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-tag text-red"></span>
                                                                {{ __('forum.denied') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="denied"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-tag text-red"></span>
                                                                {{ __('forum.denied') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('solved',$params) && $params['solved'] == 1)
                                                                <input type="checkbox" value="1" name="solved" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-thumbs-up text-green"></span>
                                                                {{ __('forum.solved') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="solved"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-thumbs-up text-green"></span>
                                                                {{ __('forum.solved') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('invalid',$params) && $params['invalid'] == 1)
                                                                <input type="checkbox" value="1" name="invalid" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-thumbs-down text-red"></span>
                                                                {{ __('forum.invalid') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="invalid"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-thumbs-down text-red"></span>
                                                                {{ __('forum.invalid') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('bug',$params) && $params['bug'] == 1)
                                                                <input type="checkbox" value="1" name="bug" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-bug text-red"></span>
                                                                {{ __('forum.bug') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="bug"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-bug text-red"></span>
                                                                {{ __('forum.bug') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                                <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('suggestion',$params) && $params['suggestion']
                                                                == 1)
                                                                <input type="checkbox" value="1" name="suggestion"
                                                                       CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-info text-blue"></span>
                                                                {{ __('forum.suggestion') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="suggestion">
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-info text-blue"></span>
                                                                {{ __('forum.suggestion') }}
                                                            @endif
                                                        </label>
                                                    </span>

                                            </div>
                                        </div>
                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="type"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('forum.state') }}</label>
                                            <div class="col-sm-10">
                                                    <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('open',$params) && $params['open'] == 1)
                                                                <input type="checkbox" value="1" name="open" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-lock-open text-green"></span>
                                                                {{ __('forum.open') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="open"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-lock-open text-green"></span>
                                                                {{ __('forum.open') }}
                                                            @endif
                                                        </label>
                                                    </span><span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('closed',$params) && $params['closed'] == 1)
                                                                <input type="checkbox" value="1" name="closed" CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-lock text-red"></span>
                                                                {{ __('forum.closed') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="closed"> <span
                                                                        class="{{ config('other.font-awesome') }} fa-lock text-red"></span>
                                                                {{ __('forum.closed') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                            </div>
                                        </div>
                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="type"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('forum.activity') }}</label>
                                            <div class="col-sm-10">
                                                    <span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('subscribed',$params) && $params['subscribed']
                                                                == 1)
                                                                <input type="checkbox" value="1" name="subscribed"
                                                                       CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-bell text-green"></span>
                                                                {{ __('forum.subscribed') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="subscribed">
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-bell text-green"></span>
                                                                {{ __('forum.subscribed') }}
                                                            @endif
                                                        </label>
                                                    </span><span class="badge-user">
                                                        <label class="inline">
                                                            @if(isset($params) && is_array($params) &&
                                                                array_key_exists('notsubscribed',$params) &&
                                                                $params['notsubscribed'] == 1)
                                                                <input type="checkbox" value="1" name="notsubscribed"
                                                                       CHECKED>
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-bell-slash text-red"></span>
                                                                {{ __('forum.not-subscribed') }}
                                                            @else
                                                                <input type="checkbox" value="1" name="notsubscribed">
                                                                <span
                                                                        class="{{ config('other.font-awesome') }} fa-bell-slash text-red"></span>
                                                                {{ __('forum.not-subscribed') }}
                                                            @endif
                                                        </label>
                                                    </span>
                                            </div>
                                        </div>

                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="sort"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('common.sort') }}</label>
                                            <div class="col-sm-2">
                                                <label for="sorting"></label><select id="sorting" name="sorting"
                                                                                     class="form-control">
                                                    <option value="updated_at"
                                                            {{ isset($params) && is_array($params) && array_key_exists('sorting', $params) && $params['sorting'] == 'updated_at' ? 'SELECTED' : '' }}>
                                                        {{ __('forum.updated-at') }}</option>
                                                    <option value="created_at"
                                                            {{ isset($params) && is_array($params) && array_key_exists('sorting', $params) && $params['sorting'] == 'created_at' ? 'SELECTED' : '' }}>
                                                        {{ __('forum.created-at') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mx-0 mt-5 form-group fatten-me">
                                            <label for="sort"
                                                   class="mt-5 col-sm-1 label label-default fatten-me">{{ __('common.direction') }}</label>
                                            <div class="col-sm-2">
                                                <label for="direction"></label><select id="direction" name="direction"
                                                                                       class="form-control">
                                                    <option value="desc"
                                                            {{ isset($params) && is_array($params) && array_key_exists('direction', $params) && $params['direction'] == 'desc' ? 'SELECTED' : '' }}>
                                                        {{ __('common.descending') }}</option>
                                                    <option value="asc"
                                                            {{ isset($params) && is_array($params) && array_key_exists('direction', $params) && $params['direction'] == 'asc' ? 'SELECTED' : '' }}>
                                                        {{ __('common.ascending') }}</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="button-holder" style="margin-top: 20px !important;">
                                            <div class="button-center">
                                                <button type="submit"
                                                        class="btn btn-primary">{{ __('common.search') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th>{{ __('forum.forum') }}</th>
                    <th>{{ __('forum.topic') }}</th>
                    <th>{{ __('forum.author') }}</th>
                    <th>{{ __('forum.stats') }}</th>
                    <th>{{ __('forum.last-post-info') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($results as $r)
                    <tr>
                        <td class="f-display-topic-icon"><span
                                    class="badge-extra text-bold">{{ $r->topic->forum->name }}</span></td>
                        <td class="f-display-topic-title">
                            <strong><a
                                        href="{{ route('forum_topic', ['id' => $r->topic->id]) }}">{{ $r->topic->name }}</a></strong>
                            @if ($r->topic->state == "close") <span
                                    class='label label-sm label-default'>{{ strtoupper(__('forum.closed')) }}</span> @endif
                            @if ($r->topic->approved == "1") <span
                                    class='label label-sm label-success'>{{ strtoupper(__('forum.approved')) }}</span> @endif
                            @if ($r->topic->denied == "1") <span
                                    class='label label-sm label-danger'>{{ strtoupper(__('forum.denied')) }}</span> @endif
                            @if ($r->topic->solved == "1") <span
                                    class='label label-sm label-info'>{{ strtoupper(__('forum.solved')) }}</span> @endif
                            @if ($r->topic->invalid == "1") <span
                                    class='label label-sm label-warning'>{{ strtoupper(__('forum.invalid')) }}</span> @endif
                            @if ($r->topic->bug == "1") <span
                                    class='label label-sm label-danger'>{{ strtoupper(__('forum.bug')) }}</span> @endif
                            @if ($r->topic->suggestion == "1") <span
                                    class='label label-sm label-primary'>{{ strtoupper(__('forum.suggestion')) }}</span>
                            @endif
                        </td>
                        <td class="f-display-topic-started"><a
                                    href="{{ route('users.show', ['username' => $r->topic->first_post_user_username]) }}">{{ $r->topic->first_post_user_username }}</a>
                        </td>
                        <td class="f-display-topic-stats">
                            {{ $r->topic->num_post - 1 }} {{ __('forum.replies') }}
                            \ {{ $r->topic->views }} {{ __('forum.views') }}
                        </td>
                        <td class="f-display-topic-last-post">
                            <a
                                    href="{{ route('users.show', ['username' => $r->topic->last_post_user_username]) }}">{{ $r->topic->last_post_user_username }}</a>,
                            <time datetime="{{ date('d-m-Y h:m', strtotime($r->topic->updated_at)) }}">
                                {{ date('M d Y', strtotime($r->topic->updated_at)) }}
                            </time>
                        </td>
                    </tr>
                    @if(isset($params) && is_array($params) && array_key_exists('body',$params))
                        <tr>
                            <td colspan="5" class="some-padding button-padding">
                                <div class="topic-posts button-padding">
                                    <div class="post" id="post-{{ $r->id }}">
                                        <div class="button-holder">
                                            <div class="button-left">
                                                <a href="{{ route('users.show', ['username' => $r->user->username]) }}"
                                                   class="post-info-username"
                                                   style="color:{{ $r->user->group->color }}; display:inline;">{{ $r->user->username }}</a>
                                                @ {{ date('M d Y h:i:s', $r->created_at->getTimestamp()) }}
                                            </div>
                                            <div class="button-right">
                                                <a class="text-bold"
                                                   href="{{ route('forum_topic', ['id' => $r->topic->id]) }}?page={{ $r->getPageNumber() }}#post-{{ $r->id }}">#{{ $r->id }}</a>
                                            </div>
                                        </div>
                                        <hr class="some-margin">
                                        @joypixels($r->getContentHtml())
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center col-md-12">
            {{ $results->links() }}
        </div>
    </div>
    </div>
@endsection
