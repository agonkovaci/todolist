@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create New Task</a>

        @if ($tasks->isEmpty())
            <p>You have no tasks yet.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->status ? 'Completed' : 'Pending' }}</td>
                        <td>
                            @if ($task->priority == 1)
                                High
                            @elseif ($task->priority == 2)
                                Medium
                            @else
                                Low
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
