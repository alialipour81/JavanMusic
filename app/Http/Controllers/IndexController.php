<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Comment\CreateRequestComment;
use App\Models\Album;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Music;
use App\Models\Protection;
use App\Models\Slider;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jorenvh\Share\Share;

class IndexController extends Controller
{
    public function index()
    {
        $musics = Music::where('status',1)->orderBy('id','desc')->limit(8)->get();
        $music_ToDay = $this->music_today();
        $last_update = Music::orderBy('id','desc')->limit(1)->first();
        $famous_music = $this->famous_music();
        $articles = Article::where('status',1)->orderBy('id','desc')->limit(4)->get();
        $protections = Protection::where('status',1)->orderBy('id','desc')->get();
        $slider = Slider::where('status',1)->orderBy('id','desc')->get();
       return view('fronts.index')
           ->with('musics',$musics)
           ->with('music_today',$music_ToDay)
           ->with('last_update',$last_update)
           ->with('famous_music',$famous_music)
           ->with('articles',$articles)
           ->with('protections',$protections)
           ->with('slider',$slider);
    }
    public function albums()
    {
        $albums = Album::searched()->where('status',1)->orderBy('id','desc')->Paginate(15);
        $last_update = Music::where('album_id','!=',0)->orderBy('id','desc')->limit(1)->first();
        return view('fronts.albums')
            ->with('albums',$albums)
            ->with('last_update',$last_update);
    }

    public function album($slug)
    {
        $album = Album::where('slug',$slug)->first();
        $albums = Album::where('artist_id',$album->artist_id)->where('slug','!=',$slug)->limit(5)->get();
        return view('fronts.album')
            ->with('album',$album)
            ->with('albums',$albums);
    }
    public function blog()
    {
        $articles = Article::searched()->where('status',1)->orderBy('id','desc')->Paginate(15);
        return view('fronts.blog')
            ->with('articles',$articles);
    }
    public function article(Article $article)
    {
        $this->visit($article,request()->ip(),'blog');
        $visits = Visit::where('type','blog')->where('type_id',$article->id)->get();
        $comments = Comment::where('child',0)->where('type','blog')->where('type_id',$article->id)->where('status',1)->orderBy('id','desc')->get();
        $share = $this->share(null,request()->url());
        $average = Article::average_stars($comments,'blog',$article->id);
        return view('fronts.article')
            ->with('article',$article)
            ->with('visits',$visits)
            ->with('comments',$comments)
            ->with('share',$share)
            ->with('average',$average);
    }
    public function musics()
    {
        $musics = Music::searched()->where('status',1)->orderBy('id','desc')->Paginate(20);
        $last_update = Music::orderBy('id','desc')->limit(1)->first();
        return view('fronts.musics')
            ->with('musics',$musics)
            ->with('last_update',$last_update);
    }

    public function music(Music $music)
    {
        $this->visit($music,request()->ip(),'music');
        $visits = Visit::where('type','music')->where('type_id',$music->id)->get();
        $comments = Comment::where('child',0)->where('type','music')->where('type_id',$music->id)->where('status',1)->orderBy('id','desc')->get();
        $share = $this->share($music);
        $average = Article::average_stars($comments,'music',$music->id);
        return view('fronts.music')
            ->with('music',$music)
            ->with('comments',$comments)
            ->with('share',$share)
            ->with('visits',$visits)
            ->with('average',$average);
    }

    public function download_music(Request $request, Music $music)
    {
        $music->update([
           'downloadCount'=>$music->downloadCount+1
        ]);
         if(!empty($request->quality_128)){
          return $this->DOW_MUSIC($music);
         }else{
           return $this->DOW_MUSIC($music,"320");
         }

    }
    public function register_login()
    {
        return view('auth.register_login');
    }


    public function commentStore(CreateRequestComment $request,$content)
    {
        if ($request->type == "music") {
            $music = Music::where('name', $content)->first();
            if (Auth::check()) {
                $comment = Comment::create([
                    'user_id' => auth()->user()->id,
                    'type_id' => $music->id,
                    'text' => $request->text,
                    'star' => $request->star
                ]);
                if (auth()->user()->role == "admin") {
                    $comment->status = 1;
                    $comment->save();
                }
            } else {
                $this->validate($request, [
                    'name' => ['required'],
                    'email' => ['required', 'email']
                ]);
                $comment = Comment::create([
                    'type_id' => $music->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'text' => $request->text,
                    'star' => $request->star
                ]);
            }
        } elseif ($request->type == "blog") {
            $article = Article::where('title', $content)->first();
            if (Auth::check()) {
                $comment = Comment::create([
                    'user_id' => auth()->user()->id,
                    'type' => 'blog',
                    'type_id' => $article->id,
                    'text' => $request->text,
                    'star' => $request->star
                ]);
                if (auth()->user()->role == "admin") {
                    $comment->status = 1;
                    $comment->save();
                }
            } else {
                $this->validate($request, [
                    'name' => ['required'],
                    'email' => ['required', 'email']
                ]);
                $comment = Comment::create([
                    'type' => 'blog',
                    'type_id' => $article->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'text' => $request->text,
                    'star' => $request->star
                ]);
            }
            session()->flash('success', 'نظر شما با موفقیت ثبت شد');
            return back();
        }
    }
    // functions help
    public function DOW_MUSIC($music,$format="128")
    {
        if($format== "128"){
            if(filter_var($music->quality_128,FILTER_VALIDATE_URL)){
                return redirect($music->quality_128);
            }else{
                return Storage::download($music->quality_128,$music->name.'-'."JavanMusic"."(128)");
            }
        }else{
            if(filter_var($music->quality_320,FILTER_VALIDATE_URL)){
                return redirect($music->quality_320);
            }else{
                return Storage::download($music->quality_320,$music->name.'-'."JavanMusic "."(320)");
            }
        }
    }

    public function visit($array,$ip=null,$type=null)
    {
        if ($type == "music" || $type == "blog"){
            $visits = Visit::where('type',$type)->where('ip',$ip)->where('type_id',$array->id)->get();
            if(empty($visits->toArray())){
                $visit = Visit::create([
                    'ip'=>request()->ip(),
                    'type_id'=>$array->id
                ]);
                if($type == "blog"){
                    $visit->type = $type;
                    $visit->save();
                }
            }
        }
    }

    public function share($array=null,$url=null)
    {
        if(empty($array)){
            return \Share::page(
                $url,
                ' این مقاله را در وبلاگ رادیو جوان مشاهده کنید ',
            )  ->facebook()
                ->twitter()
                ->linkedin()
                ->whatsapp()
                ->reddit()
                ->telegram();
        }else{
            return \Share::page(
                route('music',$array->slug),
                ' موزیک '.$array->name .' در رادیو جوان بشنوید ',
            )  ->facebook()
                ->twitter()
                ->linkedin()
                ->whatsapp()
                ->reddit()
                ->telegram();
        }
    }

    public function music_today()
    {
        $musics = Music::where('status',1)->get();
        $today =[];
        foreach ($musics as $music):
            if($music->created_at->format('Y-m-d') == today()->format('Y-m-d')):
                array_push($today,$music);
            endif;
        endforeach;
        return $today;
    }

    public function famous_music()
    {
        $musics = Music::all();
        $Views=[];
        // get views
        foreach ($musics as $music):
            $views= $music->visits->count();
            array_push($Views,$views);
        endforeach;
        // گرفتن موزیک های باترتیب بازدید بالا
        $FAMOUS_MUSIC =[];
        foreach ($Views as $key=>$view):
            $max = array_search(max($Views),$Views);
            array_push($FAMOUS_MUSIC,$musics[$max]);
            unset($Views[$max]);
        endforeach;
        return $FAMOUS_MUSIC;


    }
}
