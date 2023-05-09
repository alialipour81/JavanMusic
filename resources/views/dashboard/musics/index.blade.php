@extends('layouts.dashboard.front')
@section('title','موزیک ها ')
@section('content')
    <div class="col-12 mt-2">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">موزیک ها  </h3>

                <div class="card-tools">
                    <a href="{{ route('music.create') }}" class="btn btn-danger btn-sm">افزودن</a>
                </div>
            </div>
            <div class="my-2">@include('layouts.message')</div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام</th>
                        <th>موزیک</th>
                        <th>  تصویر </th>
                        <th> نام هنرمند</th>
                        <th>کاربر </th>
                        <th>وضعیت </th>
                        <th> آخرین بروزرسانی</th>
                        <th>تعداد بازدید</th>
                        <th>ویرایش</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($musics as $music)
                        <tr>
                            <td>{{ $music->id }}#</td>
                            <td>{{ $music->name }}</td>
                            <td class="d-flex flex-column">
                            <div class="d-flex mb-2">
                                @empty(!$music->quality_128)
                                    <audio controls title="کیفیت 128">
                                        <source
                                            @if(filter_var($music->quality_128,FILTER_VALIDATE_URL))
                                                src="{{ $music->quality_128 }}" type="audio/mpeg"
                                            @else
                                                src="{{ asset('storage/'.$music->quality_128) }}" type="audio/{{$music->format_128}}"
                                            @endif
                                        >
                                    </audio><span class="badge badge-success pt-3 bg-danger-gradient">کیفیت 128</span>
                                @endempty
                            </div>
                             <div class="d-flex">
                                 @empty(!$music->quality_320)
                                     <audio controls title="کیفیت 320">
                                         <source
                                             @if(filter_var($music->quality_320,FILTER_VALIDATE_URL))
                                                 src="{{ $music->quality_320 }}" type="audio/mpeg"
                                             @else
                                                 src="{{ asset('storage/'.$music->quality_320) }}" type="audio/{{$music->format_320}}"
                                             @endif
                                         >
                                     </audio><span class="badge badge-success pt-3 bg-success-gradient" >کیفیت 320</span>
                                 @endempty
                             </div>
                            </td>
                            <td>
                                <img src="{{ asset('storage/'.$music->image) }}" class="rounded shadow" width="60px" height="40px">
                            </td>
                            <td><span class="badge badge-dark p-1">{{ $music->artist->name }}</span></td>
                            <td>{{ $music->user->name }}</td>

                            <td>
                                @if($music->status == 1)
                                    <span class="badge badge-success p-1">نمایش</span>
                                @else
                                    <span class="badge badge-danger p-1">عدم نمایش</span>
                                @endif
                            </td>
                            <td><span class="badge badge-secondary">{{ $music->updated_at->diffForHumans() }}</span></td>
                            <td>
                                {{ $music->visits->count() }} <i class="fa fa-eye text-success"></i>
                            </td>
                            <td>
                                <a href="{{ route('music.edit',$music->slug) }}" class="btn btn-primary btn-sm">ویرایش</a>
                            </td>
                            <td>
                                <form action="{{ route('music.destroy',$music->slug) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        {{ $musics->links() }}
        <!-- /.card -->
    </div>

@endsection
