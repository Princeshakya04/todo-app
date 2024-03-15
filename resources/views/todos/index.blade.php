@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    
                    @if (Session::has('alert-success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('alert-success') }}
                    </div>
                    @endif

                    @if (Session::has('alert-info'))
                    <div class="alert alert-info" role="alert">
                        {{ Session::get('alert-info') }}
                    </div>
                    @endif

                    @if (Session::has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <a class="btn btn-sm btn-success" href="{{ route('todos.create') }}">Create Todo</a>

                    @if (count($todoList) > 0)
                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Completed</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todoList as $todo)
                            <tr>
                                <td>
                                    {{ $todo->title }}
                                </td>
                                <td>
                                    {{ $todo->description }}
                                </td>
                                <td>
                                    @if ($todo->is_completed == 1)
                                        <a class="btn btn-sm btn-success" href="">Completed</a>
                                    @else
                                        <a class="btn btn-sm btn-danger" href="">Not completed</a>
                                    @endif
                                </td>
                                <td style="width: auto; text-align: center;" class="outer">
                                    <a style="display: inline-block; margin-right: 5px;" class="inner btn btn-sm btn-primary" href="{{ route('todos.show', $todo->id) }}">View</a>
                                    <a style="display: inline-block; margin-right: 5px;" class="inner btn btn-sm btn-warning" href="{{ route('todos.edit', $todo->id) }}">Edit</a>
                                    <form method="post" action="{{ route('todos.destroy') }}" style="display: inline-block;" class="inner">
                                    @csrf
                                    @method('DELETE')
                                        <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are u sure to delete this task ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                    </table>
                    @else
                    <h4>No Todo | Let's create!</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
