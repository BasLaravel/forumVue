@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
    {{--left part of the screen--}}
            <div class="col-md-8">

            <show-thread inline-template :attribuut="{{$thread}}">
                <div class="card mb-3 container">
                    <div class="card-header row bg-info" style="padding:4px 4px 4px 0px;">

                    
                        <div class="col-md-12">
                        <img src="{{$thread->creator->avatar_patch}}"  style="margin-right:7px;" alt="" width="40px" height="40px">
                            <a href="{{route('profile.show',[$thread->creator->name])}}" style="margin-right:5px;" >{{$thread->creator->name  }}</a>
                        
                           
                           <span v-if="! bewerk">posted:
                            @{{title}}</span>
                            
                        </div>
              

                            <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} ml-auto mr-auto mt-2 col-md-11"
                             type="text" v-model="title" v-if="bewerk"  name="title" placeholder="title">
                                <p class="text-danger mt-2 form-control ml-auto mr-auto mt-2 col-md-11" v-if="errors.title" v-for="error in errors.title" v-text="error" >
                                                <strong></strong>
                                </p> 

                    </div>


                    <div class="card-body row">

                        <div class="col-md-12" v-if="bewerk" id="" >
                           
                                <textarea-scan-op-naam inline-template :textarea="body" @update="updateThread" >
                                        <div class="row">
                                            <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" cols="10" rows="7"
                                            v-model="textarea" :value="textarea" @input="scan()"
                                            v-html="textarea" required></textarea>
                                        
                                            <div class="form-control" id="post-reply-scan-op-naam" v-show="opties"> 
                                                <p v-for="namen in nameArray" v-text="namen" @click="plukNaam(namen)"></p>                   
                                            </div>
                                            <div >
                                                <button  type="button" @click="update"
                                                    class="btn btn-info btn-sm m-2">
                                                    Update
                                                </button>
                                            </div>
                                            <div >
                                                <button  
                                                    class="btn btn-danger btn-sm m-2" @click="bewerk=false, errors=false, cancel()" type="button">
                                                    Cancel
                                                </button>
                                            </div>    
                                          
                                            <div class="mt-2 ml-auto">
                                                <form class="" method="POST" action="{{ route('thread.destroy', [$thread->channel->slug, $thread->slug]) }}"
                                                >
                                                    {{csrf_field() }}
                                                    {{method_field('DELETE')}}
                                                    <button type="submit" 
                                                    class="btn btn-danger btn-sm ml-auto">
                                                    Delete Thread
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="form-control" v-show="errors.body">
                                                <p class="text-danger mt-2 col-md-12 " v-if="errors.body" v-for="error in errors.body" v-text="error">
                                                    <strong></strong>
                                                </p> 
                                            </div>

                                        </div>
                                </textarea-scan-op-naam inline-template>
                        </div>
                        <div v-else>
                            <p  class="card-text" v-html="body"></p>
                        </div>   
                    </div>
                        
                   
                    @can('update', $thread)
                    <div class="card-footer row" style="background-color:rgb(242, 255, 230);">

                        @can('update', $thread) 
                            <div class="mr-3">
                                <button 
                                    class="btn btn-info btn-sm" @click="bewerk=true" >
                                    Bewerk
                                </button>
                            </div>
                            <!-- <div>
                                <button  
                                class="btn btn-danger btn-sm" @click="deleteReply">
                                Verwijder Reply</button>
                            </div> -->
                            @endcan
                   
                    </div>
                    @endcan
                   

                </div>
            </show-thread>



         
                    {{--alle replies--}}
                
                       
                        @foreach($replies as $reply)
                            @include('threads.reply')
                        @endforeach
                       
                       {{$replies->links()}}
                      

                            {{--form voor een reply--}}
                            @auth
                                <reply-form inline-template :attribuut="{{$thread}}">
                             

                                    <p v-if="locked" >
                                        <strong class="text-danger"> Deze thread is gesloten. Geen replies meer mogelijk.</strong>
                                    </p>
                               
                                    <div class="card mb-3" v-else>
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
                                    </reply-form>
                               
                    
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
                                    class="btn btn-primary btn-sm "
                                    @click="subscribeToThread">
                                    @{{subscription ? 'volg niet meer':'volg'}}
                                    </button>
                                @issAdmin
                                    <button
                                    class="btn btn-sm ml-2" :class="locked ? 'btn-success' : 'btn-danger'" @click="toggleLock" >
                                    @{{locked ? 'Unlock':'Lock'}}
                                    </button>
                                @endissAdmin

                                </div>
                                @endauth
                            
                            </div>
                    </div>

                </thread-info-paneel>     

            </div>

         
    </div>
</div>


@endsection

