@extends('layouts.app-back')

@section('content')
<div class="container">
    <h1>{{ $event->name }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Dinas:</strong> {{ $event->dinas }}</p>
            <p><strong>Start Date:</strong> {{ $event->start_date }}</p>
            <p><strong>End Date:</strong> {{ $event->end_date }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
        </div>
        @if($event->file_pdf)
        <div class="card-footer">
            <a href="{{ asset($event->file_pdf) }}" class="btn btn-secondary" target="_blank">View PDF</a>
        </div>
        @endif
    </div>

    <a href="/dashboard" class="btn btn-primary">Back to Events</a>
</div>
@endsection