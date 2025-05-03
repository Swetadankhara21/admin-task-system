@extends('layouts.apps')

@section('content')
<h2>My Tasks</h2>

@foreach($tasks as $task)
    <div>
        <strong>{{ $task->title }}</strong><br>
        {{ $task->description }}<br>
        Status: {{ $task->is_done ? '✅ Done' : '❌ Pending' }}

        @if(!$task->is_done)
        <form action="{{ route('tasks.done', $task->id) }}" method="POST">
            @csrf
            <button type="submit">Mark as Done</button>
        </form>
        @endif
    </div>
    <hr>
@endforeach
@endsection
