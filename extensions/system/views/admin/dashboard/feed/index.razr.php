@script('feed', 'system/js/dashboard/feed.js', ['requirejs'])

@if (widget.settings.title)
<h1 class="uk-h3">@widget.settings.title</h1>
@endif
<div class="js-feed" data-feed="@(['url' => widget.settings.url, 'count' => widget.settings.count, 'content' => widget.settings.content, 'onFirst' => widget.settings.onFirst]|json_encode|e)"></div>