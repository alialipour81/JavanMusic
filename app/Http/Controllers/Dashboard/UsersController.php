<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\UpdateRequestUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = [
            'user' => 'کاربر',
            'admin' => 'ادمین',
        ];
        return view('dashboard.users.edit')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestUser $request, User $user)
    {
        $isEmailExsist = User::where('email',$request->email)->get()->toArray();
        if(!empty($isEmailExsist) && $request->email != $user->email){
            $this->validate($request,['email'=>['unique:users,email']]);
        }
        if ($request->hasFile('image')):
            $this->validate($request, [
                'image' => ['image', 'mimes:png,jpeg,jpg', 'max:1000']
            ]);
            if (!empty($user->image)):
                Storage::delete($user->image);
            endif;
            $user->image = $request->image->store('profile_user');
            $user->save();
        endif;
        if (!empty($request->new_password)):
            $this->validate($request, [
                'new_password' => ['min:8']
            ]);
            $user->password = Hash::make($request->new_password);
            $user->save();
        endif;
        if ($user->email != $request->email):
            $user->email_verified_at = null;
            $user->save();
        endif;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);
        session()->flash('success', ' کاربر با آیدی ' . $user->id . ' به نام ' . $user->name . ' باموفقیت ویرایش شد ');
        return redirect(route('dashboard.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', ' کاربر با آیدی ' . $user->id . ' به نام ' . $user->name . ' باموفقیت حذف شد ');
        return redirect(route('dashboard.index'));
    }

    public function delete_image_profile(Request $request,User $user)
    {
        Storage::delete($user->image);
        $user->update([
           'image'=>null
        ]);
        session()->flash('success', ' کاربر با آیدی ' . $user->id . ' به نام ' . $user->name . '   با موفقیت عکس پروفایلش حذف شد ');
        return redirect(route('dashboard.index'));
    }
}
