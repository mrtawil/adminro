<div id="kt_header" class="header  header-fixed ">
    <div class="container-fluid d-flex align-items-center">

        <div class="mr-auto">
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default">
                    <ul class="menu-nav">
                        <li class="menu-item">
                        <h5 class="mb-0">@can('super-admin')Super Admin @elseif(Auth::user()->company()){{ Auth::user()->company->name }}@endif
                            </h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="ml-auto">
            <div class="topbar align-items-center">
                <div class="mr-auto">
                    <div class="topbar-item d-block d-lg-none">
                    <h5 class="mb-0">@can('super-admin')Super Admin @elseif(Auth::user()->company()){{ Auth::user()->company->name }}@endif
                        </h5>
                    </div>
                </div>

                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->profile->full_name }}</span>
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                            @if (Auth::user()->profile->photo)
                                <span class="symbol-label font-size-h5 font-weight-bold" style="background-image:url({{ URL::asset('/storage/users/' . Auth::user()->profile->photo) }}"></span>
                            @else
                                <span class="symbol-label font-size-h5 font-weight-bold">{{ Auth::user()->profile->full_name[0] }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
