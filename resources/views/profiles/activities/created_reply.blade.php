<div class="card mb-3 container">
    <div class="card-header row">
            <h5 class="col-md-8" >
         

 

            {{$profileUser->name}}
         
             replied to <a href="{{ route('thread.show',
              [$activity->subject->thread->channel->slug, $activity->subject->thread->slug
              .'#reply-'.$activity->subject->id  ]) }}">
              "{{$activity->subject->thread->title}}" </a>            
            </h5>
            <div class="col-md-4 text-right">
          
            </div>

    </div>    

    <div class="card-body">
    {{$activity->subject->body}} 
    </div>            
</div>