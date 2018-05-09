
<replies inline-template :attribuut="{{$reply}}">
<div id="reply-{{$reply->id}}" class="card mb-3 container" v-show="showReply">
        <div class="card-header row bg-warning">
            <h5 class="col-md-9" >
            <a href="{{route('profile.show',[$reply->owner->name])}}">
            {{$reply->owner->name}}
            </a>
             said
            {{$reply->created_at->diffForHumans()}}...
            </h5>

            <button :class="buttontype"
            
           
            id="like-{{$reply->id}}" @click="likeReply">
            <i class="fab fa-gratipay mr-1"></i><tag v-text="favoritesCount"></tag></button>
        </div> 

       
       
        <div  class="card-body" >

            <div class="form-group" v-if="bewerk" id="bodyn-{{$reply->id}}" >
                <textarea class="form-control" cols="10" rows="5" v-model="body"></textarea>

                <button id="update-{{$reply->id}}" 
                class="btn btn-info btn-sm m-2" @click="updateReply">
                Update</button>
                <button id="cancel-{{$reply->id}}" 
                class="btn btn-danger btn-sm" @click="bewerk=false" >
                Cancel</button>
                <p class="text-danger mt-2" v-if="errors.body" v-for="error in errors.body" v-text="error">
                    <strong></strong>
                </p>        
            </div>
            <div v-else>
                <p id="body-{{$reply->id}}" class="card-text" v-text="body"></p>
             </div>   
        </div>

        @can('update', $reply) 
         
                <div class="card-footer row" style="background-color:rgb(153, 255, 102);">
                    <div class="mr-3">
                    <button id="{{$reply->id}}" 
                        class="btn btn-info btn-sm" @click="bewerk=true" >
                        Bewerk
                    </button>
                    </div>
                        <button id="delete-{{$reply->id}}"  
                        class="btn btn-danger btn-sm" @click="deleteReply">
                        Verwijder Reply</button>
                </div>
        
        @endcan
</div>
</replies>










   