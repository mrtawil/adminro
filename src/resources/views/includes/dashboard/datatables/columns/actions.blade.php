@if ($controllerSettings->actions()->edit() && $item->deleted_at == null)
    <a href="{{ Str::replace(':id', $item->id, $controllerSettings->info()->editUrl()) }}" class="btn btn-sm btn-clean btn-icon" title="Edit">
        <i class="la la-edit"></i>
    </a>
@endif
@if ($controllerSettings->actions()->delete() && $item->deleted_at == null)
    <form action="{{ Str::replace(':id', $item->id, $controllerSettings->info()->deleteUrl()) }}" method="POST" class="d-inline">
        @method("DELETE")
        @csrf
        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-clean btn-icon" title="Delete">
            <i class="la la-trash"></i>
        </button>
    </form>
@endif
@if ($controllerSettings->actions()->restore() && $item->deleted_at)
    <form action="{{ Str::replace(':id', $item->id, $controllerSettings->info()->restoreUrl()) }}" method="POST" class="d-inline">
        @method("PUT")
        @csrf
        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-clean btn-icon" title="Restore">
            <i class="la la-life-ring"></i>
        </button>
    </form>
@endif
@if ($controllerSettings->actions()->forceDelete() && $item->deleted_at)
    <form action="{{ Str::replace(':id', $item->id, $controllerSettings->info()->forceDeleteUrl()) }}" method="POST" class="d-inline">
        @method("DELETE")
        @csrf
        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-clean btn-icon" title="Force delete">
            <i class="la la-trash"></i>
        </button>
    </form>
@endif
