<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use MediaUploadingTrait;

    public function edit($school_slug)
    {
        $user = auth()->user();

        return view('school.account.edit', compact('school_slug', 'user'));
    }

    public function update(Request $request, $school_slug)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:' . \Illuminate\Database\Schema\Builder::$defaultStringLength],
            'email' => ['required', 'unique:users,email,' . auth()->id(), 'email', 'max:' . \Illuminate\Database\Schema\Builder::$defaultStringLength],
            'username' => ['required', 'alpha_num', 'starts_with:a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z', 'min:5', 'max:30', 'unique:users,username,' . auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [], [
            'name' => strtolower(trans('crud.user.fields.name')),
            'email' => strtolower(trans('crud.user.fields.email')),
            'username' => strtolower(trans('crud.user.fields.username')),
        ]);

        $user = User::query()->findOrFail(auth()->id());

        $update = $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => strtolower($request->get('username')),
        ]);

        if ($request->get('password')) {
            $user->update([
                'password' => Hash::make($request->get('password')),
            ]);
        }

        if ($request->get('photo', false)) {
            if (!$user->photo || $request->get('photo') !== $user->photo->file_name) {
                $user->addMedia(storage_path('tmp/uploads/' . $request->get('photo')))->toMediaCollection('photo');
            }

        } elseif ($user->photo) {
            $user->photo->delete();
        }

        if ($request->get('letter', false)) {
            if (!$user->letter || $request->get('letter') !== $user->letter->file_name) {
                $user->addMedia(storage_path('tmp/uploads/' . $request->get('letter')))->toMediaCollection('letter');
            }

        } elseif ($user->letter) {
            $user->letter->delete();
        }

        if ($update) {
            session()->flash('message', __('global.is_updated'));
        }

        return redirect()->route('school.account.show', ['school_slug' => $school_slug]);
    }

    public function show($school_slug)
    {
        $user = auth()->user();

        return view('school.account.show', compact('school_slug', 'user'));
    }
}
