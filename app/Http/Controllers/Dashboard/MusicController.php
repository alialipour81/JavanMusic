<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Music\CreateRequestMusic;
use App\Http\Requests\Dashboard\Music\UpdateRequestMusic;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusicController extends Controller
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
        $musics = Music::orderBy('id','desc')->Paginate(15);
        return view('dashboard.musics.index')
            ->with('musics',$musics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::orderBy('id','desc')->get();
        $tags = Tag::orderBy('id','desc')->get();
        $albums = Album::where('status',1)->orderBy('id','desc')->get();
        return view('dashboard.musics.create&edit')
            ->with('artists',$artists)
            ->with('albums',$albums)
            ->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestMusic $request)
    {
        if(empty($request->file('quality_128')) && empty($request->link_quality_128) && empty($request->file('quality_320')) && empty($request->link_quality_320)){
            session()->flash('error','برای موزیک باید یک فابل یا لینک در نظر بگیرید ');
            return back()->withInput();
        }
        if(!empty($request->file('quality_128')) && !empty($request->link_quality_128) || !empty($request->file('quality_320')) && !empty($request->link_quality_320)){
            session()->flash('error','نمیتوانید هم لینک وارد کنید هم فایل,نکته هارو چک کنید ');
            return back()->withInput();
        }
        if(!empty($request->link_quality_128)){
            $this->validate($request,['link_quality_128'=>['url']]);
        }
        if(!empty($request->link_quality_320)){
            $this->validate($request,['link_quality_320'=>['url']]);
        }
        $music = Music::create([
             'name'=>$request->name,
             'slug'=>$this->slug($request),
             'artist_id'=>$request->artist_id,
            'user_id'=>auth()->user()->id,
            'image'=>$request->image->store('music/image'),
            'text'=>$request->text
        ]);
        if(!empty($request->tags)){
            $music->tags()->attach($request->tags);
        }
        if($request->album_id != 0){
            $music->album_id = $request->album_id;
            $music->save();
        }
        if($request->hasFile('quality_128')){
            $this->validate($request,[
               'quality_128'=>['mimes:mp3,wav,ogg']
            ]);
            $music->quality_128 = $request->quality_128->store('music/audio');
            $music->format_128 = $request->file('quality_128')->getClientOriginalExtension();
            $music->save();
        }
        if($request->hasFile('quality_320')){
            $this->validate($request,[
                'quality_320'=>['mimes:mp3,wav,ogg']
            ]);
            $music->quality_320 = $request->quality_320->store('music/audio');
            $music->format_320 = $request->file('quality_320')->getClientOriginalExtension();
            $music->save();
        }
        if(!empty($request->link_quality_128)){
            $music->quality_128 = $request->link_quality_128;
            $music->format_128 = 'mp3';
            $music->save();
        }
        if(!empty($request->link_quality_320)){
            $music->quality_320 = $request->link_quality_320;
            $music->format_320 = 'mp3';
            $music->save();
        }
        session()->flash('success','موزیک با موفقیت ثبت شد');
        return redirect(route('music.index'));


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
    public function edit(Music $music)
    {
        $artists = Artist::orderBy('id','desc')->get();
        $tags = Tag::orderBy('id','desc')->get();
        $albums = Album::where('status',1)->orderBy('id','desc')->get();
        $users = User::orderBy('id','desc')->get();
        $statuses =['0'=>'عدم نمایش','1'=>'نمایش'];
        return view('dashboard.musics.create&edit')
            ->with('artists',$artists)
            ->with('albums',$albums)
            ->with('music',$music)
            ->with('users',$users)
            ->with('statuses',$statuses)
            ->with('tags',$tags);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestMusic $request, Music $music)
    {
        $Mus = Music::where('name',$request->name)->get()->toArray();
        if(!empty($Mus) && $request->name != $music->name){
            $this->validate($request,['name'=>['unique:music,name']]);
        }
        if(!empty($request->file('quality_128')) && !empty($request->link_quality_128) || !empty($request->file('quality_320')) && !empty($request->link_quality_320)){
            session()->flash('error','نمیتوانید هم لینک وارد کنید هم فایل,نکته هارو چک کنید ');
            return back()->withInput();
        }
        if(!empty($request->link_quality_128)){
            $this->validate($request,['link_quality_128'=>['url']]);
        }
        if(!empty($request->link_quality_320)){
            $this->validate($request,['link_quality_320'=>['url']]);
        }
        $music->update([
            'name'=>$request->name,
            'slug'=>$this->slug($request),
            'artist_id'=>$request->artist_id,
            'user_id'=>$request->user_id,
            'text'=>$request->text,
            'status'=>$request->status
        ]);
        if(!empty($request->tags)){
            $music->tags()->sync($request->tags);
        }
        if($request->hasFile('image')){
            $this->validate($request,[
               'image'=>['image','mimes:png,jpeg,jpg','max:2000']
            ]);
            Storage::delete($music->image);
            $music->image = $request->image->store('music/image');
            $music->save();
        }
        if($request->album_id != 0){
            $music->album_id = $request->album_id;
            $music->save();
        }
        if($request->hasFile('quality_128')){
            $this->validate($request,[
                'quality_128'=>['mimes:mp3,wav,ogg']
            ]);
            $this->check_exists_url($music);
            $music->quality_128 = $request->quality_128->store('music/audio');
            $music->format_128 = $request->file('quality_128')->getClientOriginalExtension();
            $music->save();
        }
        if($request->hasFile('quality_320')){
            $this->validate($request,[
                'quality_320'=>['mimes:mp3,wav,ogg']
            ]);
            $this->check_exists_url($music,'320');
            $music->quality_320 = $request->quality_320->store('music/audio');
            $music->format_320 = $request->file('quality_320')->getClientOriginalExtension();
            $music->save();
        }
        if(!empty($request->link_quality_128)){
            $this->check_exists_url($music);
            $music->quality_128 = $request->link_quality_128;
            $music->format_128 = 'mp3';
            $music->save();
        }
        if(!empty($request->link_quality_320)){
            $this->check_exists_url($music,'320');
            $music->quality_320 = $request->link_quality_320;
            $music->format_320 = 'mp3';
            $music->save();
        }
        session()->flash('success','موزیک با موفقیت ویرایش شد');
        return redirect(route('music.index'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        $this->check_exists_url($music);
        $this->check_exists_url($music,'320');
        Storage::delete($music->image);
        if ($music->tags()->count()){
            $music->tags()->detach();
        }
        $music->delete();
        session()->flash('success','موزیک با موفقیت حذف شد');
        return redirect(route('music.index'));
    }
    public function slug($request)
    {
        $ex = explode(' ',$request->name);
        $slug= implode('-',$ex);
        return $slug;
    }

    public function check_exists_url($music,$format='128')
    {
       if ($format=="128"){
           if(!filter_var($music->quality_128,FILTER_VALIDATE_URL)){
               Storage::delete($music->quality_128);
           }
       }else{
           if(!filter_var($music->quality_320,FILTER_VALIDATE_URL)){
               Storage::delete($music->quality_320);
           }
       }
    }
}
