@extends('layouts.apps')

@section('content')
<h2>All Tasks</h2>

@foreach($tasks as $task)
    <div>
        <strong>{{ $task->title }}</strong> - Assigned to: {{ $task->assignedTo->name }}<br>
        {{ $task->description }}<br>
        Status: {{ $task->is_done ? '✅ Done' : '❌ Pending' }}
    </div>
    <hr>
@endforeach
@endsection
