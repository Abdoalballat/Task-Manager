@extends('layouts.app')

@section('content')
<style>
    .task-mobile-card {
        background-color: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        padding: 1rem;
        margin-bottom: 0.85rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="container py-3 py-md-4">

    <!-- Header Ribbon -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 mb-4 pb-2 border-bottom border-light">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--text-primary, #1e293b);">My Tasks</h4>
            <p class="small text-muted mb-0">Overview of assigned tasks and execution status</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
            <span class="badge rounded-pill px-3 py-2" style="background-color: #e0f2fe; color: #0369a1; font-size: 0.85rem;">
                Total: {{ $counts['all'] }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline mb-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 small shadow-sm">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- بطاقات الإحصائيات العلوية -->
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ url()->current() }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 {{ !request('status') ? 'border-start border-4 border-primary' : '' }}">
                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">All Tasks</small>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ $counts['all'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ url()->current() }}?status=pending" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 {{ request('status') === 'pending' ? 'border-start border-4 border-warning' : '' }}">
                    <small class="text-warning text-uppercase fw-semibold" style="font-size: 11px;">Pending</small>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ $counts['pending'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ url()->current() }}?status=in_progress" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 {{ request('status') === 'in_progress' ? 'border-start border-4 border-info' : '' }}">
                    <small class="text-info text-uppercase fw-semibold" style="font-size: 11px;">In Progress</small>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ $counts['in_progress'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ url()->current() }}?status=completed" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 {{ request('status') === 'completed' ? 'border-start border-4 border-success' : '' }}">
                    <small class="text-success text-uppercase fw-semibold" style="font-size: 11px;">Completed</small>
                    <h4 class="fw-bold text-dark mt-1 mb-0">{{ $counts['completed'] }}</h4>
                </div>
            </a>
        </div>
    </div>

    @php
        $filteredTasks = request('status') ? $tasks->where('status', request('status')) : $tasks;
        $priorityColors = [
            'low'    => 'bg-secondary-subtle text-secondary',
            'medium' => 'bg-info-subtle text-info-emphasis',
            'high'   => 'bg-danger-subtle text-danger',
        ];
    @endphp

    <!-- 1. Mobile Cards View (يظهر فقط على الموبايل) -->
    <div class="d-block d-md-none">
        @forelse($filteredTasks as $task)
            <div class="task-mobile-card">
                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                    <span class="fw-bold text-dark fs-6">{{ $task->title }}</span>
                    <span class="badge rounded-pill px-2 py-1 {{ $priorityColors[$task->priority ?? 'medium'] ?? 'bg-light text-dark' }}" style="font-size: 10px;">
                        {{ ucfirst($task->priority ?? 'medium') }}
                    </span>
                </div>

                @if($task->description)
                    <p class="small text-muted mb-2 text-truncate" style="max-width: 100%;">
                        {{ $task->description }}
                    </p>
                @endif

                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
                        <i class="bi bi-folder2 me-1 text-primary"></i>
                        {{ $task->project?->title ?? 'Workspace' }}
                    </span>
                    <small class="text-muted">
                        <i class="bi bi-calendar-event me-1"></i>{{ $task->deadline ?? 'No deadline' }}
                    </small>
                </div>

                <div class="pt-2 border-top border-light">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('PATCH')
                        <select name="status" 
                                class="form-select form-select-sm rounded-pill fw-semibold border-0 shadow-sm w-100" 
                                style="font-size: 12px; cursor: pointer;
                                @if($task->status === 'completed') background-color: #d1fae5; color: #065f46;
                                @elseif($task->status === 'in_progress') background-color: #e0f2fe; color: #0369a1;
                                @else background-color: #fef3c7; color: #92400e; @endif"
                                onchange="this.form.submit()">
                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </div>
            </div>
        @empty
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
                <i class="bi bi-clipboard2-check display-6 d-block mb-2 opacity-50"></i>
                <span class="fw-semibold">No tasks found.</span>
            </div>
        @endforelse
    </div>

    <!-- 2. Desktop Table View (يظهر في الشاشات العادية واللابتوب) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th class="ps-4">Task Details</th>
                        <th>Project</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($filteredTasks as $task)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-dark d-block mb-1">{{ $task->title }}</span>
                                @if($task->description)
                                    <small class="text-muted d-block text-truncate" style="max-width: 320px;">
                                        {{ $task->description }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill">
                                    <i class="bi bi-folder2 me-1 text-primary"></i>
                                    {{ $task->project?->title ?? 'Workspace' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-2 py-1 {{ $priorityColors[$task->priority ?? 'medium'] ?? 'bg-light text-dark' }}" style="font-size: 11px;">
                                    {{ ucfirst($task->priority ?? 'medium') }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $task->deadline ?? 'No deadline' }}
                                </small>
                            </td>
                            <td>
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            class="form-select form-select-sm rounded-pill fw-semibold border-0 shadow-sm" 
                                            style="width: 135px; font-size: 12px; cursor: pointer;
                                            @if($task->status === 'completed') background-color: #d1fae5; color: #065f46;
                                            @elseif($task->status === 'in_progress') background-color: #e0f2fe; color: #0369a1;
                                            @else background-color: #fef3c7; color: #92400e; @endif"
                                            onchange="this.form.submit()">
                                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard2-check display-6 d-block mb-2 text-muted opacity-50"></i>
                                <span class="fw-semibold">No tasks found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection