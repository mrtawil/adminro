@php
$reminders = getReminders();
$expired_offers = getExpiredOffers();
$notifications_count = getNotificationsCount();
@endphp
<div class="dropdown">
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 @if ($notifications_count > 0)pulse pulse-primary @endif">
            <span class="svg-icon svg-icon-xl svg-icon-primary">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
                        <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
                    </g>
                </svg>
            </span>
            <span class="pulse-ring"></span>
        </div>
    </div>
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <form>
            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{ URL::asset('/assets/media/dashboard/notifications-bg-1.jpg') }})">
                <h4 class="d-flex flex-center rounded-top">
                    <span class="text-white">Notifications</span>
                    <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">{{ $notifications_count }}</span>
                </h4>
                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_reminders">Reminders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#topbar_notifications_expired_offers">Expired Offers</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active show" id="topbar_notifications_reminders" role="tabpanel">
                    <div class="navi navi-hover scroll mt-4" data-scroll="true" data-height="300" data-mobile-height="200">
                        @if ($reminders->count() > 0)
                            @foreach ($reminders as $reminder)
                                <a href="{{ route('businessAccounts.edit', $reminder->_id) }}" class="navi-item">
                                    <div class="navi-link">
                                        <div class="navi-icon mr-2">
                                            <i class="flaticon2-notification text-success"></i>
                                        </div>
                                        <div class="navi-text">
                                            <div class="font-weight-bold">{{ $reminder->title }}</div>
                                            <div class="text-muted">{{ $reminder->reminder }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
                                <br />No new reminders.
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-center py-4">
                        <a href="{{ route('businessAccounts_reminders.index') }}" class="btn btn-light-primary font-weight-bold text-center">See All</a>
                    </div>
                </div>
                <div class="tab-pane" id="topbar_notifications_expired_offers" role="tabpanel">
                    <div class="navi navi-hover scroll mt-4" data-scroll="true" data-height="300" data-mobile-height="200">
                        @if ($expired_offers->count() > 0)
                            @foreach ($expired_offers as $expired_offer)
                                <a href="{{ route('offers.edit', $expired_offer->_id) }}" class="navi-item">
                                    <div class="navi-link">
                                        <div class="navi-icon mr-2">
                                            <i class="flaticon2-information text-warning"></i>
                                        </div>
                                        <div class="navi-text">
                                            <div class="font-weight-bold">@if ($expired_offer->businessAccount){{ $expired_offer->businessAccount->title }}: @endif{{ $expired_offer->title }}</div>
                                            <div class="text-muted">{{ $expired_offer->expiry_date->toDateString() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
                                <br />No new expired offers.
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-center py-4">
                        <a href="{{ route('expiredOffers.index') }}" class="btn btn-light-primary font-weight-bold text-center">See All</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
