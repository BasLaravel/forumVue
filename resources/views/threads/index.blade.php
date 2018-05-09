@extends('layouts.app')

@section('content')
<div class="container col-md-8">
    <div class="row mb-5">
        <div class="col">
            <h2>Forum Threads</h2>
        </div>
    </div> 
    @forelse($threads as $thread)
    <div class="row mb-3">
        <div class="card container">
                    <div class="card-header row bg-info">
                        <a class="col-md-8 text-dark" href="{{ route('thread.show', [$thread->channel->slug, $thread->id]) }}">
                            {{$thread->title}}
                        </a>
                        <div class="col-md-4 text-right">
                            <strong>
                                <a href="{{ route('thread.show', [$thread->channel->slug, $thread->id]) }}">
                                    {{$thread->replies_count}}
                                    @if($thread->replies_count==1)
                                    comment
                                    @else
                                    comments
                                    @endif
                                </a>
                            </strong>
                        </div>    
                    </div>         
                    <div class="card-body row">
                        <div class="col">{{$thread->body}}</div>
                    </div>      
        </div>
    </div>  
    @empty
    <p class="col-md-8">Er zijn geen relevante posts op dit moment</p>  
    @endforelse                
</div>
@endsection