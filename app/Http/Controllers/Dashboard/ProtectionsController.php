<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Protection\CreateRequestProtection;
use App\Http\Requests\Dashboard\Protection\UpdateRequestProtection;
use App\Models\Protection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProtectionsController extends Controller
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
        $protections = Protection::orderBy('id','desc')->Paginate(15);
        return view('dashboard.protections.index')
            ->with('protections',$protections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.protections.create&edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestProtection $request)
    {
        Protection::create([
            'user_id'=>auth()->user()->id,
            'image'=>$request->image->store('protections'),
            'title'=>$request->title,
            'link'=>$request->link,
        ]);
        session()->flash('success','درخواست حمایت با موفقیت ثبت شد');
        return redirect(route('protections.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Protection $protection)
    {
        $statuses =[
          '0'=>'عدم نمایش',
          '1'=>'نمایش',
        ];
        return view('dashboard.protections.create&edit',compact('protection','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestProtection $request, Protection $protection)
    {
        if ($request->hasFile('image')):
            $this->validate($request,[
               'image'=>['image','mimes:png,jpeg,jpg','max:2000']
            ]);
        Storage::delete($protection->image);
        $protection->image = $request->image->store('protections');
        $protection->save();
        endif;
        $protection->update([
            'title'=>$request->title,
            'link'=>$request->link,
            'status'=>$request->status
        ]);
        session()->flash('success','درخواست حمایت با موفقیت ویرایش شد');
        return redirect(route('protections.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protection $protection)
    {
        Storage::delete($protection->image);
        $protection->delete();
        session()->flash('success','درخواست حمایت با موفقیت حذف شد');
        return redirect(route('protections.index'));
    }
}
