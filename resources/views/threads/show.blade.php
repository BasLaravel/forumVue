@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    {{--left part of the screen--}}
            <div class="col-md-8">
                <div class="card mb-3 container">
                    <div class="card-header row bg-info">
                        <div class="col-md-10">
                            <a href="{{route('profile.show',[$thread->creator->name])}}">{{$thread->creator->name}}</a>
                            posted:
                            {{$thread->title}}
                        </div>
                        @can('update', $thread)
                        <form class="col-md-2" method="POST" action="{{ route('thread.destroy', [$thread->channel->slug, $thread->id]) }}">
                            {{csrf_field() }}
                            {{method_field('DELETE')}}
                            <button type="submit" 
                            class="btn btn-link btn-sm">
                            Delete Thread
                            </button>
                        </form>
                        @endcan
                    </div>
                    <div class="card-body row">
                    {{$thread->body}}
                    </div>
                </div>
         
                    {{--alle replies--}}
                
                       
                        @foreach($replies as $reply)
                            @include('threads.reply')
                            @endforeach
                       
                       {{$replies->links()}}
                      

                            {{--form voor een reply--}}
                            @auth
                        
                               
                                    <div class="card mb-3">
                                        <div class="card-header">Reply?</div>
                                            <div class="card-body">
                                                    <form method="POST" action="{{ route('reply.store', [$thread->channel->slug, $thread->id]) }}">
                                                    @csrf
                                                        <input type="hidden" name="redirects_to" value="{{URL::previous()}}">
                                                     
                                                        <div class="form-group">
                                                            <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body" cols="10" rows="5"></textarea>
                                
                                                            @if ($errors->has('body'))
                                                                <span class="invalid-feedback">
                                                                    <strong>{{ $errors->first('body') }}</strong>
                                                                </span>             
                                                            @endif    

                                                       


                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Post</button>
                                                        
                                                    </form>
                                            </div>
                                        
                                    </div>  
                               
                    
                    @else
                            <p class="text-center"> 
                            <a href="{{route('login')}}">Log in</a>
                            om deel te nemen aan deze de discussie</p>
                        
                    @endauth

            </div>
{{--right side of the page--}}

            <div class="col-md-4">
                <thread-info-paneel inline-template :attribuutrepliesaantal="{{$thread->replies_count}}" :attribuut="{{$thread}}">
                    <div class="card mb-3">
                        <div class="card-header">
                            Thread Info
                        </div>
                            <div id="threadInfo" class="card-body">
                                <p>{{$thread->created_at->diffForHumans()}}</p>
                                <p>Gepubliceerd door: <a href="#">{{$thread->creator->name}}.</a></p>
                                <p v-bind="repliesAantal" v-text="repliesAantal +' replies'"></p>  
                            
                                @auth
                                <div id="threadSubscribe">
                                    <button
                                    class="btn btn-primary btn-sm subscribe "
                                    @click="subscribeToThread">
                                    @{{subscription ? 'volg niet meer':'volg'}}
                                    
                                    </button>
                                </div>
                                @endauth
                            
                            </div>
                    </div>

                </thread-info-paneel>     

            </div>

         
    </div>
</div>


@endsection

