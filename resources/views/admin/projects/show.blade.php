@extends('layouts.admin')

@section('content')

    <section>
        <h1>PROGETTO: "{{$project->name}}"</h1>
        <h3>SLUG:</h3> {{$project->slug}}
        <h3>Descrizione:</h3>{{$project->summary}}  

        
    @if ($project->cover_image)
    <div>
        <img src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}">
    </div>
    @endif
    </section>
    
    
@endsection