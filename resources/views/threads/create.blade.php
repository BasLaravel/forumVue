@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">Maak een thread</div>
                        <div class="card-body">
                                <form method="POST" action="{{ route('threads')}}">
                                @csrf

                                    <div class="form-group">
                                        <select class="form-control{{ $errors->has('channel_id') ? ' is-invalid' : '' }}" name="channel_id" id="channel_id" 
                                         value="">
                                         <option value="">Kies een channel...</option>
                                         @foreach($channels as $channel)
                                            <option value="{{$channel->id}}" {{old('channel_id')== $channel->id ? 'selected':''}}>{{$channel->name}}</option>
                                        @endforeach

                                         </select>
                                        @if ($errors->has('channel_id'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('channel_id') }}</strong>
                                        </span>             
                                     @endif    

                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" placeholder="title"
                                         value="{{old('title')}}">
                                        @if ($errors->has('title'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>             
                                     @endif    

                                    </div>

                                    <div class="form-group">
                                        <textarea class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}" name="body" id="body" cols="10" rows="5" placeholder="tekst"
                                         >{{old('body')}}</textarea>
                                        @if ($errors->has('body'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>             
                                     @endif   
                                    </div>
                                

                                <button type="submit" class="btn btn-primary">Post</button>
                                </form>
                        </div>
                    
                </div>  
            </div>
        </div>
    
   
</div>
@endsection

   