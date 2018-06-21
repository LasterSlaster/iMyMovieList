<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" itemscope itemtype="http://schema.org/WebPage">
@include('partials._head')

<body>
    @include('partials._nav')

    @yield('content')
    
    @include('partials._footer')
    
    @include('partials._javascript')

    @yield('scripts')
</body>

</html>