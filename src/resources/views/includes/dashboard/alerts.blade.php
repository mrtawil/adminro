@if (count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">{{ $error }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @endforeach
@endif

@if (session('success'))
    @foreach (session('success') as $success)
        <div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-checkmark"></i></div>
            <div class="alert-text">{{ $success }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @endforeach
@endif

@if (session('warning'))
    @foreach (session('warning') as $warning)
        <div class="alert alert-custom alert-notice alert-light-warning fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-warning"></i></div>
            <div class="alert-text">{{ $warning }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @endforeach
@endif

@if (session('secondary'))
    @foreach (session('secondary') as $secondary)
        <div class="alert alert-custom alert-notice alert-light-dark fade show" role="alert">
            <div class="alert-icon"><i class="flaticon2-warning"></i></div>
            <div class="alert-text">{{ $secondary }}</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    @endforeach
@endif

@if (session('status'))
    <div class="alert alert-custom alert-notice alert-light-warning fade show" role="alert">
        <div class="alert-icon"><i class="flaticon2-warning"></i></div>
        <div class="alert-text">{{ session('status') }}</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
@endif
