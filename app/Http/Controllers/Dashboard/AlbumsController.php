<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Album\CreateRequestAlbum;
use App\Http\Requests\Dashboard\Album\UpdateRequestAlbum;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
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
        $albums = Album::orderBy('id','desc')->Paginate(15);
        return view('dashboard.albums.index')
            ->with('albums',$albums);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::orderBy('id','desc')->get();
        $categories = Category::orderBy('id','desc')->get();
        return view('dashboard.albums.create&edit',compact('categories','artists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestAlbum $request)
    {
        $album = Album::create([
            'artist_id'=>$request->artist_id,
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'slug'=>$this->slug($request),
            'image'=>$request->image->store('albums'),
            'image_background'=>$request->image_background->store('albums_background')
        ]);
        if(auth()->user()->role == "admin"){
            $album->status = 1;
            $album->save();
        }
            $album->categories()->attach($request->categories);
        session()->flash('success','آلبوم با موفقیت ایجاد شد');
        return redirect(route('albums.index'));

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
    public function edit(Album $album)
    {
        $artists = Artist::orderBy('id','desc')->get();
        $categories = Category::orderBy('id','desc')->get();
        $statuses =['0'=>'عدم نمایش','1'=>'نمایش'];
        $users = User::orderBy('id','desc')->get();
        return view('dashboard.albums.create&edit',compact('categories','artists','album','statuses','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestAlbum $request, Album $album)
    {
        $Alb = Album::where('name',$request->name)->get()->toArray();
        if(!empty($Alb) && $request->name != $album->name){
            $this->validate($request,['name'=>['unique:albums,name']]);
        }
        if($request->hasFile('image')){
            $this->validate($request,[
               'image'=>['image','mimes:png,jpeg,jpg','max:2000'],
            ]);
            Storage::delete($album->image);
            $album->image = $request->image->store('albums');
            $album->save();
        }
        if($request->hasFile('image_background')){
            $this->validate($request,[
                'image_background'=>['image','mimes:png,jpeg,jpg','max:3000'],
            ]);
            Storage::delete($album->image_background);
            $album->image_background = $request->image_background->store('albums_background');
            $album->save();
        }
        $album->update([
            'artist_id'=>$request->artist_id,
            'name'=>$request->name,
            'user_id'=>$request->user_id,
            'slug'=>$this->slug($request),
            'status'=>$request->status
        ]);
            $album->categories()->sync($request->categories);
        session()->flash('success','آلبوم با موفقیت ویرایش شد');
        return redirect(route('albums.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $album->categories()->detach();
        Storage::delete($album->image);
        Storage::delete($album->image_background);
        $album->delete();
        session()->flash('success','آلبوم با موفقیت حذف شد');
        return redirect(route('albums.index'));
    }

    public function slug($request)
    {
        $ex = explode(' ',$request->name);
        $slug= implode('-',$ex);
        return $slug;
    }
}
