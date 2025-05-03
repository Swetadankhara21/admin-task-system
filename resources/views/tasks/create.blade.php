@extends('layouts.apps')

@section('content')
<div class="container">
    <h2>Assign New Task</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label>Assign To</label>
            <select name="assigned_to" class="form-control" required>
                <option value="">-- Select Admin --</option>
                @foreach ($users as $user)  <!-- Change $admins to $users -->
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
            <br>
        <button type="submit" class="btn btn-primary">Assign Task</button>
    </form>
</div>
@endsection
