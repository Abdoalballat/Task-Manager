@extends('layouts.app')

@section('title', $user->username . ' - Profile')

@section('content')
<!-- Header Ribbon -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-2 border-bottom border-light">
    <div>
        <a href="{{ route('users.index') }}" class="text-decoration-none small text-muted mb-1 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Users
        </a>
        <h3 class="fw-bold mb-0 text-dark">{{  $user?->username?? 'Unassigned' }}</h3>
    </div>
    <div class="d-flex gap-2">
        <span class="badge rounded-pill px-3 py-2 text-uppercase" style="font-size: 11px; background: #e2e8f0; color: #334155;">
            {{ $user->role }}
        </span>
        <span class="badge rounded-pill px-3 py-2" style="font-size: 11px; {{ $user->status ? 'background: var(--emerald-soft); color: var(--emerald-hover);' : 'background: #fef3c7; color: #d97706;' }}">
            {{ $user->status ? 'Active' : 'Pending' }}
        </span>
        
    </div>
</div>

<div class="row g-4">
    <!-- User Info Card -->
    <div class="col-12 col-lg-4">
        <div class="minimal-card p-4 text-center">
            <!-- <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white mb-3" style="width: 72px; height: 72px; background-color: var(--emerald-primary); font-size: 24px;">
                {{ strtoupper(substr( $user?->username?? 'Unassigned', 0, 2)) }}
            </div> -->
            <h5 class="fw-bold mb-1 text-dark">{{  $user?->username?? 'Unassigned' }}</h5>
            <p class="small text-muted mb-3">{{ $user->email }}</p>

            <hr class="border-light">

            <div class="text-start small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">User ID:</span>
                    <span class="fw-semibold text-truncate ms-2" style="max-width: 160px;">{{ $user->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Joined:</span>
                    <span class="fw-semibold">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Completed:</span>
                    <span class="fw-semibold text-success">{{ $user->tasks ? $user->tasks->where('status', 'completed')->count() : 0 }} Tasks</span>
                </div>
            </div>

            @if(!$user->status)
                <form action="{{ route('users.activate', $user) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-pill-emerald w-100 justify-content-center">Activate Account</button>
                </form>
            @endif
        </div>
    </div>

    <!-- User Assigned Tasks -->
    <div class="col-12 col-lg-8">
        <div class="minimal-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Assigned Tasks</h5>
                <span class="badge rounded-pill bg-light text-dark border">
                    {{ $user->tasks ? $user->tasks->count() : 0 }} Assigned
                </span>
            </div>

            <div class="list-group list-group-flush">
                @forelse($user->tasks as $task)
    <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom">
        <div>
            <div class="fw-semibold {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : 'text-dark' }}">
                {{ $task->title ?? $task->task_name }}
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center mt-1">
                <span class="badge rounded-pill" style="font-size: 10px; background: #e2e8f0; color: #475569;">
                    {{ ucfirst($task->priority ?? 'medium') }}
                </span>
                @if($task->deadline)
                    <span class="small text-muted" style="font-size: 11px;">
                        <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($task->deadline)->format('M d') }}
                    </span>
                @endif
            </div>
        </div>

        <span class="badge rounded-pill px-3 py-1" style="font-size: 10px; {{ $task->status === 'completed' ? 'background: var(--emerald-soft); color: var(--emerald-hover);' : 'background: #f1f5f9; color: #64748b;' }}">
            {{ ucfirst($task->status ?? 'pending') }}
        </span>
    </div>
@empty
    <p class="text-muted text-center py-4 mb-0 small">No tasks currently assigned to this user.</p>
@endforelse
            </div>
        </div>
    </div>
</div>
@endsection