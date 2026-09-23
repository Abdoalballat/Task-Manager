@extends('layouts.app')

@section('title', $project->title)

@section('content')

<style>
/* شريط تمرير أنيق */
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f8fafc;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* ضبط العناصر على الشاشات الصغيرة */
@media (max-width: 767.98px) {
    .task-item-container {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.75rem;
    }
    .task-actions-wrapper {
        width: 100%;
        display: flex;
        justify-content: flex-end;
        border-top: 1px dashed #f1f5f9;
        padding-top: 0.5rem;
    }
}
</style>

@if ($errors->any())
    <div class="alert alert-danger rounded-4 mb-4 shadow-sm border-0">
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Header Ribbon -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-2 border-bottom border-light">
    <div>
        <a href="{{ route('projects.index') }}" class="text-decoration-none small text-muted mb-1 d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i> Back to Projects
        </a>
        <h3 class="fw-bold mb-0 text-dark fs-4 fs-md-3">{{ $project->title }}</h3>
    </div>
    <span class="badge px-3 py-2 rounded-pill border text-uppercase" style="background: var(--emerald-soft, #d1fae5); color: var(--emerald-hover, #047857); font-size: 11px;">
        {{ $project->project_status ?? 'Active' }}
    </span>
</div>

<div class="row g-4">
    <!-- Tasks & Timeline Column -->
    <div class="col-lg-8 order-2 order-lg-1">
        <!-- Project Tasks Card -->
        <div class="minimal-card p-3 p-sm-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 fs-6 fs-sm-5">Project Tasks</h5>
                <span class="badge rounded-pill bg-light text-dark border">{{ $project->tasks->count() }} Tasks</span>
            </div>

            <div class="list-group list-group-flush">
                @forelse($project->tasks as $task)
                    <div class="list-group-item px-0 py-3 bg-transparent border-bottom">
                        <div class="d-flex justify-content-between align-items-start gap-2 task-item-container">
                            <div class="d-flex align-items-start gap-2 gap-sm-3 flex-grow-1 overflow-hidden">
                                <form action="{{ route('tasks.update', $task) }}" method="POST" class="m-0 mt-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $task->status === 'completed' ? 'pending' : 'completed' }}">
                                    <button type="submit" class="btn btn-sm p-0 border-0" style="color: {{ $task->status === 'completed' ? 'var(--emerald-primary, #059669)' : '#94a3b8' }};">
                                        <i class="bi {{ $task->status === 'completed' ? 'bi-check-circle-fill fs-5' : 'bi-circle fs-5' }}"></i>
                                    </button>
                                </form>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-break {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : 'text-dark' }}" style="font-size: 0.95rem;">
                                        {{ $task->title }}
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                        <span class="badge rounded-pill" style="font-size: 10px; background: #e2e8f0; color: #475569;">
                                            {{ ucfirst($task->priority ?? 'medium') }}
                                        </span>
                                        @if($task->deadline)
                                            <span class="text-muted small" style="font-size: 11px;">
                                                <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($task->deadline)->format('M d') }}
                                            </span>
                                        @endif
                                        @if($task->assignedUser)
                                            <span class="small fw-medium" style="font-size: 11px; color: var(--emerald-primary, #059669);">
                                                <i class="bi bi-person me-1"></i>{{ $task->assignedUser->user_name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="task-actions-wrapper">
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="m-0" onsubmit="return confirm('Delete task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Delete task">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4 mb-0 small">No tasks registered yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="minimal-card p-3 p-sm-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-clock-history me-2 text-success"></i>Activity Logs
                </h6>
                <span class="badge rounded-pill bg-light text-muted border px-2 py-1" style="font-size: 11px;">
                    {{ $logs->count() }}
                </span>
            </div>

            <div class="timeline ps-2 custom-scrollbar pe-2" style="max-height: 380px; overflow-y: auto;">
                @forelse($logs as $log)
                    <div class="border-start border-2 ps-3 pb-3 position-relative" style="border-color: #d1fae5 !important;">
                        <span class="text-muted d-block" style="font-size: 11px;">{{ $log->created_at->diffForHumans() }}</span>
                        <span class="text-dark small text-break">{{ $log->description }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No recorded activities.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Task Sidebar / Form -->
    <div class="col-lg-4 order-1 order-lg-2">
        <div class="minimal-card p-3 p-sm-4">
            <h5 class="fw-bold mb-3 fs-6 fs-sm-5">Add Task</h5>
            <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Task Name</label>
                    <input type="text" name="title" class="form-control form-control-pill" required placeholder="Task title">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-semibold">Priority</label>
                        <select name="priority" class="form-select form-control-pill">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select form-control-pill">
                            <option value="pending" selected>Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Deadline</label>
                    <input type="date" name="deadline" class="form-control form-control-pill">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Assignee</label>
                    <select name="user_id" class="form-select form-control-pill">
                        <option value="">Unassigned</option>
                        @foreach($users ?? [] as $user)
                            <option value="{{ $user->id }}">{{ $user->user_name ?? $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_recurring" value="1" class="form-check-input" id="is_recurring">
                    <label class="form-check-label small text-muted" for="is_recurring">Recurring Task</label>
                </div>

                <button type="submit" class="btn btn-pill-emerald w-100 justify-content-center">Save Task</button>
            </form>
        </div>
    </div>
</div>
@endsection