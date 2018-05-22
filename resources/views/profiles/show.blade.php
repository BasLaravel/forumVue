@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2"> 

            <div class="page-header">

             <avatar-form :user="{{$profileUser}}"></avatar-form>
               
            
            </div>

            {{--alle activities--}}
                                    
            @forelse($activities as $date=>$activity)
                <h3 class="page-header">{{$date}}</h3>
                @foreach($activity as $record)
                    @if(view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
            @empty
                <p>Er zijn nog geen activiteiten gevonden voor u.</p>
            @endforelse
          
        </div>
    </div>
</div>

<script>

Vue.component('image-upload', {

props:[''],

data() {
    return {
        
    }
    
},

template:`
<div>
    <input type="file"  accept="image/*" @change="onChange">
 </div>   
`,


    methods: {
    
        onChange(e){
            if(!e.target.files.length)return;
            
                    var file = e.target.files[0];
                    console.log(1);
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => {
                        var src = e.target.result;
                        this.$emit('loaded', {src, file});
                    };
        }
    }   

});


Vue.component('avatar-form', {

props:['user'],

data() {
    return {
        avatar:this.user.avatar_patch
    }
    
},

template:`
<div>
    <h1>
        @{{user.name}} 
        <small>Lid sinds @{{user.created_at}}</small>
    </h1>

    <form v-if="canUpdate" method="POST"  enctype="multipart/form-data">
          
          <image-upload name="avatar" @loaded="onLoad"></image-upload>
        
        @if ($errors->has('avatar'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('avatar') }}</strong>
        </span>             
        @endif                                  
                                         
    </form>

    <img :src="avatar" alt="" width="150px" height="150px">
 </div>   
`,


methods: {
  
  onLoad(avatar){
      this.avatar=avatar.src;
      this.persist(avatar.file);
  },

    persist(avatar){
        var data = new FormData();
        data.append('avatar', avatar);
        axios.post('/api/users/'+ this.user.name +'/avatar', data )
        .then(() => {
            flash({message:'Uw avatar is geupload', danger:'0'});
        });
    }

},

computed:{
 canUpdate(){
   if(auth===this.user.id){
        return true
    } 

 }
},


mounted(){
console.log(this.user);
}

});



</script>


@endsection
               




