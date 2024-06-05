@extends('layouts.admin')

@section('content')
    <h1>Tutti i progetti</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>TITLE</th>
                <th>SLUG</th>
                <th>CREATED AT</th>
                <th>ACTIONS</th>
            
            </tr>
        </thead>

        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-info"><a class="text-decoration-none text-reset" href="{{ route('admin.projects.show', ['project' => $project->id]) }}">VIEW</a></button>
                            <button class="btn btn-success"><a class="text-decoration-none text-reset" href="{{ route('admin.projects.edit', ['project' => $project->id]) }}">EDIT</a></button>
                            <form action="{{route('admin.projects.destroy',['project' => $project->id])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">DELETE</button>
                              </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection