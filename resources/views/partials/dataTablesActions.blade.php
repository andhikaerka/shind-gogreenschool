@can($viewGate)
    @if(Route::has('admin.' . $crudRoutePart . '.show'))
        <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}">
            {{ trans('global.view') }}
        </a>
        &nbsp;
    @endif
@endcan
@can($editGate)
    @if(Route::has('admin.' . $crudRoutePart . '.edit'))
        <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}">
            {{ trans('global.edit') }}
        </a>
        &nbsp;
    @endif
@endcan
@can($deleteGate)
    @if(Route::has('admin.' . $crudRoutePart . '.destroy'))
        <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST"
              onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
        </form>
    @endif
@endcan
