<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
        <div style="direction: rtl">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    @empty(auth()->user()->image)
                    <img src="{{ Gravatar::get(auth()->user()->email) }}" class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
                    @else
                        <img src=" {{ asset('storage/'.auth()->user()->image) }}" width="40px" height="40px" class="img-circle shadow elevation-2" alt="{{  auth()->user()->name }} ">
                    @endempty
                </div>
                <div class="info">
                    <a href="@if(auth()->user()->role == "admin") {{ route('dashboard.index') }} @else {{ route('index') }} @endif" class="d-block"> {{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item has-treeview menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa fa-bars  "></i>
                            <p>
                                منو
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(auth()->user()->role == "admin")
                            <li class="nav-item">
                                <a href="{{ route('artists.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>  هنرمندان </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categories.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>دسته بندی ها </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tags.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> برچسپ ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('albums.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>آلبوم ها</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('music.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> موزیک ها</p>
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('articles.index') }}" class="nav-link">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p> مقاله ها</p>
                                </a>
                            </li>
                            @if(auth()->user()->role == "admin")
                                <li class="nav-item">
                                    <a href="{{ route('comments.index') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>  نظرات</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('protections.index') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>  حمایت ها</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('slider.index') }}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i>
                                        <p>   اسلایدر</p>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
