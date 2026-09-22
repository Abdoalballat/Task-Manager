@extends('layouts.app')

@section('title', 'New Project')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
    <div>
        <a href="{{ route('projects.index') }}" class="text-decoration-none small text-muted mb-1 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Projects
        </a>
        <h3 class="fw-bold mb-0 text-dark">Create Project</h3>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 small shadow-sm">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </button>
</form>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="minimal-card p-4 p-md-5">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label small fw-semibold">Project Name</label>
                    <input type="text" name="title" class="form-control form-control-pill" placeholder="e.g. Mobile API Integration" required>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Initial Status</label>
                    <select name="project_status" class="form-select form-control-pill">
                        <option value="planning">Planning</option>
                        <option value="active" selected>Active</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Description</label>
                    <textarea name="description" class="form-control rounded-4 p-3" rows="4" style="border: 1px solid #d1fae5;" placeholder="Describe project deliverables..."></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('projects.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-pill-emerald px-4">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection