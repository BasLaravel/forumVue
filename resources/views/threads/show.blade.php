@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
    {{--left part of the screen--}}
            <div class="col-md-8">
                <div class="card mb-3 container">
                    <div class="card-header row bg-info" style="padding:4px 4px 4px 0px;">

                    
                        <div class="col-md-10 ">
                        <img src="{{$thread->creator->avatar_patch}}"  style="margin-right:7px;" alt="" width="40px" height="40px">
                            <a href="{{route('profile.show',[$thread->creator->name])}}" style="margin-right:5px;" >{{$thread->creator->name  }}</a>
                            posted:
                            {{$thread->title}}
                        </div>
                        @can('update', $thread)
                        <form class="col-md-2" method="POST" action="{{ route('thread.destroy', [$thread->channel->slug, $thread->slug]) }}">
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
                                                    <form method="POST" action="{{ route('reply.store', [$thread->channel->slug, $thread->slug]) }}">
                                                    @csrf
                                    
                                                        <div class="form-group">
                                                            <textarea-scan-op-naam inline-template>
                                                                <div>
                                                                    <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="post-reply-textarea" cols="10" rows="5"
                                                                    v-model="textarea" :value="textarea" @input="scan()"
                                                                    ref="postreplytextarea"></textarea>
                                                                    <div class="form-control" id="post-reply-scan-op-naam" v-show="opties"> 
                                                                        <p class="namelist" v-for="namen in nameArray" v-text="namen" @click="plukNaam(namen)"></p>
                                                                    </div>

                                                                    @if ($errors->has('body'))
                                                                    <span class="invalid-feedback">
                                                                        <strong>{{ $errors->first('body') }}</strong>
                                                                    </span>             
                                                                    @endif    

                                                                </div>
                                               
                                                            </textarea-scan-op-naam>
                                      
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

