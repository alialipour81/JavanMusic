<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Article\CreateRequestArticle;
use App\Http\Requests\Dashboard\Article\UpdateRequestArticle;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->role == "admin")
            $articles = Article::orderBy('id','desc')->Paginate(15);
        else{
            $articles = Article::where('user_id',auth()->user()->id)->orderBy('id','desc')->Paginate(15);

        }
        $moshtaraks = Article::articles_moshtarak();


        return view('dashboard.articles.index')
            ->with('articles',$articles)
            ->with('moshtaraks',$moshtaraks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id','desc')->get();
        $users = User::where('email_verified_at','!=',null)->where('id','!=',auth()->user()->id)->get();
        $tags = Tag::orderBy('id','desc')->get();
        return view('dashboard.articles.create&edit')
            ->with('categories',$categories)
            ->with('users',$users)
            ->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestArticle $request)
    {
        if(!empty($request->other_users_sub)){
            $this->validate($request,[
               'other_users_sub.*'=>['integer']
            ]);
        }
        if(!empty($request->tags)){
            $this->validate($request,[
                'tags.*'=>['integer']
            ]);
        }
        $article = Article::create([
            'category_id'=>$request->category_id,
            'user_id'=>auth()->user()->id,
            'title'=>$request->title,
            'slug'=>$this->slug($request),
            'image'=>$request->image->store('article'),
            'description'=>$request->description,
        ]);
        if(auth()->user()->role == "admin"){
            $article->status =1;
            $article->save();
        }
        if(!empty($request->other_users_sub)){
            $users_sub = implode('-',$request->other_users_sub);
            $article->other_users_sub = $users_sub;
            $article->save();
        }else{
            $article->other_users_sub = 0;
            $article->save();
        }
        if(!empty($request->tags)){
            $article->tags()->attach($request->tags);
        }
        session()->flash('success','مقاله با موفقیت ایجاد شد');
        return redirect(route('articles.index'));
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
    public function edit(Article $article)
    {
        $categories = Category::orderBy('id','desc')->get();
        $users = User::where('email_verified_at','!=',null)->where('id','!=',auth()->user()->id)->get();
        $tags = Tag::orderBy('id','desc')->get();
        $statuses=[
          '0'=>'عدم نمایش',
          '1'=>'نمایش',
        ];
        return view('dashboard.articles.create&edit')
            ->with('categories',$categories)
            ->with('users',$users)
            ->with('tags',$tags)
            ->with('article',$article)
            ->with('statuses',$statuses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestArticle $request, Article $article)
    {

        $ARTC = Article::where('title',$request->title)->get()->toArray();
        if(!empty($ARTC) && $request->title != $article->title){
            $this->validate($request,['title'=>['unique:articles,title']]);
        }
        if($request->hasFile('image')){
            $this->validate($request,[
                'image'=>['image','mimes:png,jpeg,jpg','max:2000'],
            ]);
            Storage::delete($article->image);
            $article->image = $request->image->store('article');
            $article->save();
        }
        if(!empty($request->tags)){
            $article->tags()->sync($request->tags);
        }
        if(!empty($request->other_users_sub)){
            if($request->other_users_sub != $article->other_users_sub){
                $other_users_sub = explode('-',$article->other_users_sub);
                foreach ($other_users_sub as $value):
                    if (!in_array($value,$request->other_users_sub)):
                        $article->other_users_acc = $res=str_replace($value."C","",$article->other_users_acc);
                        if(empty($res)):
                            $article->other_users_acc = str_replace($value."A","",$article->other_users_acc);
                        endif;
                        $article->save();
                    endif;
                endforeach;
            }
            $users_sub = implode('-',$request->other_users_sub);
            $article->other_users_sub = $users_sub;
            $article->save();
        }else{
            $article->other_users_sub = 0;
            $article->other_users_acc = 0;
            $article->save();
        }
        $article->update([
            'category_id'=>$request->category_id,
            'user_id'=>$request->user_id,
            'title'=>$request->title,
            'slug'=>$this->slug($request),
            'description'=>$request->description,
            'status'=>$request->status
        ]);
        session()->flash('success','مقاله با موفقیت ویرایش شد');
        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if($article->tags()->count()){
            $article->tags()->detach();
        }
        Storage::delete($article->image);
        $article->delete();
        session()->flash('success','مقاله با موفقیت حذف شد');
        return redirect(route('articles.index'));
    }

    public function ckeditor_image_upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '.' . $extension;

            //Upload File
            $request->file('upload')->storeAs('ckeditor', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/ckeditor/' . $filenametostore);
            $msg = 'عکس با موفقیت آپلود شد روی ok کلیک کنید';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }else
            return back();
    }

    public function access_or_cancel_moshtarak(Request $request,Article $article)
    {
        $users=explode('-',$article->other_users_acc);
        if(!strpos($article->other_users_acc,auth()->user()->id.'A') && !strpos($article->other_users_acc,auth()->user()->id.'C')){
            if(isset($request->access)){
                array_push($users,auth()->user()->id.'A');
                session()->flash('success',"شما درخواست مشترک شدن در مقاله {$article->title} پذیرفتید ");
            }else{
                array_push($users,auth()->user()->id.'C');
                session()->flash('success',"شما درخواست مشترک شدن در مقاله {$article->title} نپذیرفتید ");
            }
            $article->update([
                'other_users_acc'=>implode('-',$users)
            ]);
        }
        return back();
    }
    public function slug($request)
    {
        $ex = explode(' ',$request->title);
        $slug= implode('-',$ex);
        return $slug;
    }


}
