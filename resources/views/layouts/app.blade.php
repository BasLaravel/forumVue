<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('font-awesome/font-awesome.js') }}"></script> {{---font-awssome---}}
    <script src="{{ asset('js/app.js') }}" ></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" v-cloak>
       @include('layouts.nav')

        <main  class="py-4">
            @yield('content')

        @if (Session::has('message'))
        <div id="flash" class="alert alert-info" v-show="flashSession">{{ Session::get('message') }} </div>
        @endif
        <div id="flash-vue"  v-bind:class="status"  v-show="flashVue" v-text="tekst"></div>
        <div class="loader" v-if="window.load"></div>    
        
        </main>
    
    </div>

</body>


</html>


<script>
window.events= new Vue();
window.flash = function(message){
window.events.$emit('flash', message);
};
window.load=false;
window.auth=@if(Auth::check()) {{Auth::user()->id}} @else false @endif;

</script>

<script src="{{ asset('js/vue-component-thread-info-paneel.js') }}"></script>
<script src="{{ asset('js/vue-component-notifications.js') }}"></script>
<script src="{{ asset('js/vue-component-replies.js') }}"></script>
<script src="{{ asset('js/vue-main.js') }}"></script>