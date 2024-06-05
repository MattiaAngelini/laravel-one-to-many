@extends('layouts.admin')

@section('content')
    <h2>EDIT PROJECT: "{{ $project->name }}"</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form enctype="multipart/form-data" action="{{ route('admin.projects.update', ['project' => $project->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">TITLE:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}">
        </div>

        <div class="mb-3">
            <label for="summary" class="form-label">CONTENT:</label>
            <textarea class="form-control" id="summary" rows="10" name="summary">{{ old('summary', $project->summary) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">IMAGE:</label>
            <input class="form-control" type="file" name="cover_image"></textarea>
        </div>

        @if ($project->cover_image)
        <div>
            <img width="100" src="{{ asset('storage/' . $project->cover_image) }}" alt="{{ $project->title }}">
        </div>
        @else
            <small>Nessuna immagine caricata</small>
        @endif

        <div class="mt-3">
        <label for="type_id" class="form-label">TYPE:</label>
        <select class="form-select mb-3" id="type_id" name="type_id">
            <option value="">Select Type</option>
            @foreach ($types as $type)
                <option @selected($type->id == old('type_id')) value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
        </div> 


        <button type="submit" class="btn btn-primary">EDIT</button>
    </form>
@endsection