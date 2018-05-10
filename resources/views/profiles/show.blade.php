@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2"> 

            <div class="page-header">
                <h1>
                    {{$profileUser->name}}
                    <small>Lid sinds {{$profileUser->created_at->format('d/m/Y')}}</small>
                </h1>
                <hr>
   

            
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
  
@endsection
               




