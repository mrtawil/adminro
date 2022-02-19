@if (isset($controllerSettings) && $controllerSettings->subheader()->show())
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <div class="mr-auto d-flex align-items-center flex-wrap" ref="subheaderLeft">
                <h5 class="text-dark text-capitalize font-weight-bold mt-2 mb-2"> {{ $controllerSettings->subheader()->title() }} </h5>
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 ml-5 bg-gray-200"></div>
                <div class="d-flex align-items-center ml-5" id="kt_subheader_search">
                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total"> {{ $controllerSettings->subheader()->description() }} </span>
                </div>
            </div>

            <div class="ml-auto d-flex align-items-center justify-content-end">
                <div class="mr-2" id="subheader_loader" style="display: none;">
                    <div class="mr-2">Loading..</div>
                    <div class="spinner-border text-primary"></div>
                </div>
                <div ref="subheaderRight">
                    @if ($controllerSettings->actions()->back() && $controllerSettings->info()->backUrl())
                        <a href="{{ $controllerSettings->info()->backUrl() }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Back</a>
                    @endif

                    @if ($controllerSettings->subheader()->action())
                        <div class="btn-group ml-2">
                            <button type="submit" form="form" name="submit" @if (isset($data['settings']['submit_default_action'])) value="{{ $data['settings']['submit_default_action'] }}" @else value="exit" @endif class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save</button>
                            <button type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu dropdown-menu-sm p-0 m-0 dropdown-menu-right">
                                <ul class="navi py-5">
                                    @if ($controllerSettings->actions()->update())
                                        <li class="navi-item">
                                            <button class="navi-link" form="form" name="submit" value="continue">
                                                <span class="navi-icon"><i class="flaticon2-writing"></i></span>
                                                <span class="navi-text">Save & Continue</span>
                                            </button>
                                        </li>
                                    @endif
                                    @if ($controllerSettings->actions()->print())
                                        <li class="navi-item">
                                            <button class="navi-link" form="form" name="submit" value="print">
                                                <span class="navi-icon"><i class="flaticon2-print"></i></span>
                                                <span class="navi-text">Save & Print</span>
                                            </button>
                                        </li>
                                    @endif
                                    @if ($controllerSettings->actions()->create())
                                        <li class="navi-item">
                                            <button class="navi-link" form="form" name="submit" value="add_new">
                                                <span class="navi-icon"><i class="flaticon2-medical-records"></i></span>
                                                <span class="navi-text">Save & Add New</span>
                                            </button>
                                        </li>
                                    @endif
                                    @if ($controllerSettings->actions()->exit())
                                        <li class="navi-item">
                                            <button class="navi-link" form="form" name="submit" value="exit">
                                                <span class="navi-icon"><i class="flaticon2-hourglass-1"></i></span>
                                                <span class="navi-text">Save & Exit</span>
                                            </button>
                                        </li>
                                    @endif
                                    @if ($controllerSettings->actions()->destroy() && $controllerSettings->info()->destroyUrl())
                                        <form action="{{ Str::replace(':id', $controllerSettings->model()->model()->id, $controllerSettings->info()->destroyUrl()) }}" method="POST">
                                            @method("DELETE")
                                            @csrf
                                            <li class="navi-item">
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-rubbish-bin-delete-button"></i></span>
                                                    <span class="navi-text">Delete & Exit</span>
                                                </button>
                                            </li>
                                        </form>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
