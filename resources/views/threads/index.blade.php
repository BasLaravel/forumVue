@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-6 offset-md-2">
            <h2>Forum Threads</h2>
        </div>
    </div> 
   
    <div class="row mb-3">
        <div class=" col-md-8">
            @forelse($threads as $thread)
                <div class="card container mb-5">

                            <div class="card-header row" style="background-color:rgb(242, 255, 230);">
                                <a class="col-md-8 text-dark" href="{{$thread->path()}}">
                                    {{$thread->title}}
                                </a>
                                <div class="col-md-4 text-right">
                                    <strong>
                                        <a href="{{ route('thread.show', [$thread->channel->slug, $thread->slug]) }}">
                                            {{$thread->replies_count}}
                                            @if($thread->replies_count==1)
                                            comment
                                            @else
                                            comments
                                            @endif
                                        </a>
                                    </strong>
                                </div>   
                            
                                <div class="col-md-12 mt-1"><small>gepubliceerd door: <a href="/profiles/{{$thread->creator->name}}">{{$thread->creator->name}}</a></small></div>
                                    
                            </div>   
                        
                            <div class="card-body row">
                                <div class="col">{{$thread->body}}</div>
                            </div>   
                            <div class="card-footer row">
                           
                            {{$thread->visits()->count()}} keer bekeken.
                       
                          
                            </div>   
                </div>

            
                @empty
                <p class="col-md-8">Er zijn geen relevante posts op dit moment</p>  
                @endforelse    
        </div>
      <!-- rechterkant -->

            <div class="col-md-4">
               
               <div class="card mb-3">
                    <div class="card-header">
                       Top 5 <br>
                       Veel bezochte threads
                    </div>
                       <div id="threadInfo" class="card-body">
                     
                       @foreach($trending as $thread)
                          
                          <p>
                            <a href="{{url($thread->path)}}">
                                {{$thread->title}}
                             </a>   
                          </p>
                         
                         
                        @endforeach
                       </div>
                   </div>

            </div>

    </div>  


</div>
@endsection