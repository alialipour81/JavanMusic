<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Artist\CreateRequestArtist;
use App\Http\Requests\Dashboard\Artist\UpdateRequestArtist;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistsController extends Controller
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
        $artists = Artist::orderBy('id','desc')->Paginate(15);
        return view('dashboard.artists.index')
            ->with('artists',$artists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.artists.create&edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestArtist $request)
    {
        Artist::create([
            'name'=>$request->name
        ]);
        session()->flash('success','هنرمند با موفقیت اضافه شد');
        return redirect(route('artists.index'));
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
    public function edit(Artist $artist)
    {
        return view('dashboard.artists.create&edit')
            ->with('artist',$artist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestArtist $request, Artist $artist)
    {
        $Art = Artist::where('name',$request->name)->get()->toArray();
        if(!empty($Art) && $request->name != $artist->name){
            $this->validate($request,['name'=>['unique:artists,name']]);
        }
        $artist->update([
            'name'=>$request->name
        ]);
        session()->flash('success','هنرمند با موفقیت ویرایش شد');
        return redirect(route('artists.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        $artist->delete();
        session()->flash('success','هنرمند با موفقیت حذف شد');
        return redirect(route('artists.index'));
    }
}
