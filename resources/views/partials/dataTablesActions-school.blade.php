@can($viewGate)
    @if(Route::has('school.' . $crudRoutePart . '.show'))
        <a class="btn btn-xs btn-primary"
           href="{{ route('school.' . $crudRoutePart . '.show', ['school_slug' => $school_slug, $row->id]) }}">
            {{ trans('global.view') }}
        </a>
        &nbsp;
    @endif
@endcan
@can($editGate)
    @if(Route::has('school.' . $crudRoutePart . '.edit') && ($school_slug == auth()->user()->school_slug))
        <a class="btn btn-xs btn-info"
           href="{{ route('school.' . $crudRoutePart . '.edit', ['school_slug' => $school_slug, $row->id]) }}">
            {{ trans('global.edit') }}
        </a>
        &nbsp;
    @endif
@endcan
@can($deleteGate)
    @if(Route::has('school.' . $crudRoutePart . '.destroy') && ($school_slug == auth()->user()->school_slug))
        <form
            action="{{ route('school.' . $crudRoutePart . '.destroy', ['school_slug' => $school_slug, $row->id]) }}"
            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
        </form>
    @endif
@endcan
