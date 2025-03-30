@include('partials.panel._header')
<div class="page">
    @include('partials.panel._sidebar')
    @include('partials.panel._topbar')
    @yield('content')
</div>
@include('partials.panel._footer')
