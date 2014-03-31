<form class="uk-form uk-form-horizontal" action="@url.route('@alpha/settings/save')" method="post">

    <div class="uk-form-row">
        <label for="form-sidebar-a-width" class="uk-form-label">@trans('Sidebar A Width')</label>
        <div class="uk-form-controls">
            <select id="form-sidebar-a-width" class="uk-form-width-large" name="config[sidebars][sidebar-a][width]">
                @foreach ([12 => '20', 15 => '25', 18 => '30', 20 => '33', 24 => '40', 30 => '50'] as value => percent)
                <option value="@value" @(config['sidebars']['sidebar-a']['width'] == value ? 'selected')>@trans('_dd_%', ['_dd_' => percent])</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="uk-form-row">
        <label for="form-sidebar-b-width" class="uk-form-label">@trans('Sidebar B Width')</label>
        <div class="uk-form-controls">
            <select id="form-sidebar-b-width" class="uk-form-width-large" name="config[sidebars][sidebar-b][width]">
                @foreach ([12 => '20', 15 => '25', 18 => '30', 20 => '33', 24 => '40', 30 => '50'] as value => percent)
                <option value="@value" @(config['sidebars']['sidebar-b']['width'] == value ? 'selected')>@trans('_dd_%', ['_dd_' => percent])</option>
                @endforeach
            </select>
        </div>
    </div>

    <p>
        <button class="uk-button uk-button-primary" type="submit">Save</button>
        <a class="uk-button" href="@url.route('@system/themes/index')">@trans('Close')</a>
    </p>

</form>