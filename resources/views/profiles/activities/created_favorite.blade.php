<div class="card mb-3 container">
    <div class="card-header row">
            <h5 class="col-md-8" >
                <a href="{{ route('thread.show',
              [$activity->subject->favorited->thread->channel->slug, $activity->subject->favorited->thread->id ])
              .'#reply-'.$activity->subject->favorited->id }}">
                    {{$profileUser->name}} Liked a reply.
                </a>
            </h5>
            <div class="col-md-4 text-right">
          
            </div>

    </div>    

    <div class="card-body">
        {{$activity->subject->favorited->body}}
    </div>            
</div>