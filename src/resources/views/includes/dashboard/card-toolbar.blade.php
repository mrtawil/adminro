<div class="card card-custom gutter-b">
    <div class="card-header card-header-tabs-line">
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                @foreach ($cardToolbar['sections'] as $section)
                    <li class="nav-item mr-3">
                        <a class="nav-link @if (isCurrentUrl($controllerSettings->info()->activeRoute(), null, null, $section['active_route'])) active @endif" href="{{ $section['href'] }}">
                            <span class="nav-text font-weight-bold">{{ $section['title'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
