<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CreateRequestCategory;
use App\Http\Requests\Dashboard\Category\UpdateRequestCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
        $categories = Category::orderBy('id','desc')->Paginate(15);
        return view('dashboard.categories.index')
            ->with('categories',$categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create&edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestCategory $request)
    {
        Category::create([
           'name'=>$request->name
        ]);
        session()->flash('success','دسته بندی با موفقیت ایجاد شد');
        return redirect(route('categories.index'));
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
    public function edit(Category $category)
    {
        return view('dashboard.categories.create&edit')
            ->with('category',$category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestCategory $request, Category $category)
    {
        $Cat = Category::where('name',$request->name)->get()->toArray();
        if(!empty($Cat) && $request->name != $category->name){
            $this->validate($request,['name'=>['unique:categories,name']]);
        }
        $category->update([
           'name'=>$request->name
        ]);
        session()->flash('success','دسته بندی با موفقیت ویرایش شد');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success','دسته بندی با موفقیت حذف شد');
        return redirect(route('categories.index'));
    }
}
