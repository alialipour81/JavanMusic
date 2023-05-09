<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Slider\CreateRequestSlider;
use App\Http\Requests\Dashboard\Slider\UpdateRequestSlider;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
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
        $sliders = Slider::orderBy('id','desc')->Paginate(20);
        return view('dashboard.slider.index')
            ->with('sliders',$sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.slider.create&edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestSlider $request)
    {
        if(!empty($request->title_button_black) && empty($request->link_button_black)):
            session()->flash('error','لینک دکمه(سیاه) نمیتواند خالی باشد');
            return redirect(route('slider.create'))->withInput();
            elseif (empty($request->title_button_black) && !empty($request->link_button_black)):
                session()->flash('error','عنوان دکمه(سیاه) نمیتواند خالی باشد زیرا یک لینک برای آن در نظر گرفته اید');
                return redirect(route('slider.create'))->withInput();
        endif;
        if(!empty($request->title_button_green) && empty($request->link_button_green)):
            session()->flash('error','لینک دکمه(سبز) نمیتواند خالی باشد');
            return redirect(route('slider.create'))->withInput();
        elseif (empty($request->title_button_green) && !empty($request->link_button_green)):
            session()->flash('error','عنوان دکمه(سبز) نمیتواند خالی باشد زیرا یک  لینک برای آن در نظر گرفته اید');
            return redirect(route('slider.create'))->withInput();
        endif;
        if(!empty($request->link_button_black)):
            $this->validate($request,[
               'link_button_black'=>['url']
            ]);
        endif;
        if(!empty($request->link_button_green)):
            $this->validate($request,[
                'link_button_green'=>['url']
            ]);
        endif;
       $slider = Slider::create([
            'title'=>$request->title,
            'sub_title'=>$request->sub_title,
            'image'=>$request->image->store('slider/image'),
            'image_background'=>$request->image_background->store('slider/background'),
            'description'=>$request->description
        ]);
       if(!empty($request->title_button_black) && !empty($request->link_button_black)):
           $slider->title_button_black = $request->title_button_black;
           $slider->link_button_black = $request->link_button_black;
           $slider->save();
       endif;
        if(!empty($request->title_button_green) && !empty($request->link_button_green)):
            $slider->title_button_green = $request->title_button_green;
            $slider->link_button_green = $request->link_button_green;
            $slider->save();
        endif;
        session()->flash('success','اسلایدر جدید با موفقیت اضافه شد');
        return redirect(route('slider.index'));
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
    public function edit(Slider $slider)
    {
        $statuses =[
            '0'=>'عدم نمایش',
            '1'=>'نمایش',
        ];
        return view('dashboard.slider.create&edit',compact('slider','statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestSlider $request, Slider $slider)
    {
        if(!empty($request->title_button_black) && empty($request->link_button_black)):
            session()->flash('error','لینک دکمه(سیاه) نمیتواند خالی باشد');
            return redirect(route('slider.edit',$slider->id))->withInput();
        elseif (empty($request->title_button_black) && !empty($request->link_button_black)):
            session()->flash('error','عنوان دکمه(سیاه) نمیتواند خالی باشد زیرا یک لینک برای آن در نظر گرفته اید');
            return redirect(route('slider.edit',$slider->id))->withInput();
        endif;
        if(!empty($request->title_button_green) && empty($request->link_button_green)):
            session()->flash('error','لینک دکمه(سبز) نمیتواند خالی باشد');
            return redirect(route('slider.edit',$slider->id))->withInput();
        elseif (empty($request->title_button_green) && !empty($request->link_button_green)):
            session()->flash('error','عنوان دکمه(سبز) نمیتواند خالی باشد زیرا یک  لینک برای آن در نظر گرفته اید');
            return redirect(route('slider.edit',$slider->id))->withInput();
        endif;
        if(!empty($request->link_button_black)):
            $this->validate($request,[
                'link_button_black'=>['url']
            ]);
        endif;
        if(!empty($request->link_button_green)):
            $this->validate($request,[
                'link_button_green'=>['url']
            ]);
        endif;
        if ($request->hasFile('image')){
            $this->validate($request,[
                'image'=>['image','mimes:png,jpeg,jpg','max:2000']
            ]);
            Storage::delete($slider->image);
            $slider->image = $request->image->store('slider/image');
            $slider->save();
        }
        if ($request->hasFile('image_background')){
            $this->validate($request,[
                'image_background'=>['image','mimes:png,jpeg,jpg','max:3000']
            ]);
            Storage::delete($slider->image_background);
            $slider->image_background = $request->image_background->store('slider/background');
            $slider->save();
        }
        $slider->update([
            'title'=>$request->title,
            'sub_title'=>$request->sub_title,
            'description'=>$request->description,
            'status'=>$request->status
        ]);
        if(!empty($request->title_button_black) && !empty($request->link_button_black)):
            $slider->title_button_black = $request->title_button_black;
            $slider->link_button_black = $request->link_button_black;
            $slider->save();
        endif;
        if(!empty($request->title_button_green) && !empty($request->link_button_green)):
            $slider->title_button_green = $request->title_button_green;
            $slider->link_button_green = $request->link_button_green;
            $slider->save();
        endif;
        session()->flash('success','اسلایدر  با موفقیت ویرایش شد');
        return redirect(route('slider.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        Storage::delete($slider->image);
        Storage::delete($slider->image_background);
        $slider->delete();
        session()->flash('success','اسلایدر  با موفقیت حذف شد');
        return redirect(route('slider.index'));
    }
}
