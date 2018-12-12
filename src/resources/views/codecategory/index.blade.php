@extends('layouts.app')

@section('content')

    <div class="container">
        <h3>Categories</h3>

        <a href="{{ route('admin.categories.create') }}">Create Category</a>
        <br><br>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Active</th>
                <th>User</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->parent_id}}</td>
                        <td>{{$category->active}}</td>
                        <td>{{$category->user->email}}</td>
                        <td>
                            @cannot('update', $category)
                                Access Not Authorized.
                            @else
                                <a href="{{route('admin.categories.edit', ['id'=>$category->id])}}">
                                    Edit
                                </a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
