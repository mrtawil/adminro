<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="text-capitalize">{{ $controllerSettings->info()->pageTitle() }}</h3>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="row justify-content-center my-7 px-8 px-lg-10">
            <div class="col-12">
                <form action="{{ Str::replace(':id', $controllerSettings->model()->model()->id, $controllerSettings->info()->updateUrl()) }}" method="POST" class="form" enctype="multipart/form-data" id="form">
                    @method("PUT")
                    @csrf
                    <div class="row d-flex pb-5">
                        @foreach ($controllerSettings->formFields()->forms() as $key => $form)
                            @include('adminro::includes.dashboard.utils.form', ["controllerSettings" => $controllerSettings, "key" => $key, "form" => $form])
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
