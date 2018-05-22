<div class="card mb-3 container">
    <div class="card-header row">
            <h5 class="col-md-8" >
         
            {{$profileUser->name}}
            
             published a thread: 
             <a href="{{ route('thread.show',
              [$activity->subject->channel->slug, $activity->subject->slug ]) }}">{{$activity->subject->title}} 
              </a>
            
            
            </h5>
            <div class="col-md-4 text-right">
          
            </div>

    </div>    

    <div class="card-body">
             {{$activity->subject->body}}
    </div>            
</div>