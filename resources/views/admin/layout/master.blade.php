@include('admin.layout.head')

@section('nav-side')
    @include('admin.layout.sidebar')
    @include('admin.layout.navbar')
@show


@yield('content')


@include('admin.layout.footer')

