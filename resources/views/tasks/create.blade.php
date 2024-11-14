@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a New Task</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror" required>
                    <option value="1" {{ old('priority') == '1' ? 'selected' : '' }}>High</option>
                    <option value="2" {{ old('priority') == '2' ? 'selected' : '' }}>Medium</option>
                    <option value="3" {{ old('priority') == '3' ? 'selected' : '' }}>Low</option>
                </select>
                @error('priority')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create Task</button>
        </form>
    </div>
@endsection
