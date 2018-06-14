
<replies inline-template :attribuut="{{$reply}}" >
<div id="reply-{{$reply->id}}" class="card mb-3 container" v-show="showReply">
        <div class="card-header row" :class="isBest ? 'bg-success' : 'bg-light'">
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
                <form >
                    <textarea-scan-op-naam inline-template :textarea="body" @update="updateReply">
                            <div>
                                <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="post-reply-textarea" cols="10" rows="5"
                                v-model="textarea" :value="textarea" @input="scan()"
                                v-html="textarea" required></textarea>
                               
                                <div class="form-control" id="post-reply-scan-op-naam" v-show="opties"> 
                                    <p v-for="namen in nameArray" v-text="namen" @click="plukNaam(namen)"></p>                   
                                </div>
                                <button id="update-{{$reply->id}}" type="button" @click="update"
                                class="btn btn-info btn-sm m-2" >
                                Update</button>
                                <button id="cancel-{{$reply->id}}" 
                                class="btn btn-danger btn-sm" @click="bewerk=false" type="button">
                                Cancel</button>
                                <p class="text-danger mt-2" v-if="errors.body" v-for="error in errors.body" v-text="error">
                                    <strong></strong>
                                </p> 
                        </div>
                    </textarea-scan-op-naam inline-template>
                </form>           
            </div>
            <div v-else>
                <p id="body-{{$reply->id}}" class="card-text" v-html="body"></p>
             </div>   
        </div>

 
       @if(Auth()->check())
             @if( Auth::user()->can('update', $reply) || Auth::user()->can('update', $reply->thread))
                <div class="card-footer row" style="background-color:rgb(242, 255, 230);">

                  @can('update', $reply) 
                    <div class="mr-3">
                        <button id="{{$reply->id}}" 
                            class="btn btn-info btn-sm" @click="bewerk=true" >
                            Bewerk
                        </button>
                    </div>
                    <div>
                        <button id="delete-{{$reply->id}}"  
                        class="btn btn-danger btn-sm" @click="deleteReply">
                        Verwijder Reply</button>
                    </div>
                     @endcan
                    @can('update', $reply->thread) 
                    <div class="ml-auto" v-show=" ! isBest">
                        <button  
                        class="btn btn-sm" @click="markBestReply">
                        Beste antwoord?</button>
                    </div>
                     @endcan
                </div>
            @endif
      @endif
</div>
</replies>










   