@extends('layouts.app')

@section('title', 'Users Directory')

@section('content')
<style>
    /* Mobile Users Card Layout */
    .user-mobile-card {
        background-color: var(--card-surface, #ffffff);
        border-radius: 16px;
        border: 1px solid rgba(167, 243, 208, 0.4);
        padding: 1rem;
        margin-bottom: 0.85rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        background-color: var(--emerald-primary, #059669);
        color: #ffffff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Scroll styling for desktop table */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 9999px;
    }
</style>

<!-- Header Ribbon -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-2 border-bottom border-light">
    <div>
        <h3 class="fw-bold mb-1 text-dark fs-4 fs-md-3">Users Directory</h3>
        <p class="small mb-0 text-muted">Manage system access, team workload, and activation statuses</p>
    </div>
    
    <div class="d-flex flex-wrap align-items-center gap-2 w-100 w-sm-auto justify-content-start justify-content-sm-end">
        <a href="{{ route('users.create') }}" class="btn-pill-emerald shadow-sm py-1 px-3 d-inline-flex align-items-center gap-1" style="font-size: 0.88rem;">
            <i class="bi bi-plus-lg"></i>
            <span>Add User</span>
        </a>
        
        <span class="badge rounded-pill px-3 py-2" style="background-color: var(--emerald-soft, #d1fae5); color: var(--emerald-hover, #047857); font-size: 0.85rem;">
            Total: {{ $users->count() }}
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

<!-- 1. Mobile View (Cards) - يظهر فقط في الشاشات الصغيرة -->
<div class="d-block d-md-none">
    @forelse($users as $user)
        <div class="user-mobile-card">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->user_name, 0, 2)) }}
                </div>
                <div class="overflow-hidden flex-grow-1">
                    <a href="{{ route('users.show', $user->id) }}" class="fw-semibold text-dark text-decoration-none d-block text-truncate">
                        {{ $user->user_name }}
                    </a>
                    <span class="small text-muted d-block text-truncate">{{ $user->email }}</span>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2 border-top border-light">
                <div class="d-flex align-items-center gap-1">
                    <span class="badge rounded-pill px-2 py-1 text-uppercase" style="font-size: 10px; background: #e2e8f0; color: #334155;">
                        {{ $user->role }}
                    </span>
                    <span class="badge rounded-pill px-2 py-1" style="font-size: 10px; {{ $user->status ? 'background: var(--emerald-soft, #d1fae5); color: var(--emerald-hover, #047857);' : 'background: #fef3c7; color: #d97706;' }}">
                        {{ $user->status ? 'Active' : 'Pending' }}
                    </span>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                        View
                    </a>
                    @if(!$user->status)
                        <form action="{{ route('users.activate', $user) }}" method="POST" class="d-inline mb-0">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-pill-emerald py-1 px-3" style="font-size: 0.78rem;">
                                Activate
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="minimal-card p-4 text-center text-muted small">
            No users found.
        </div>
    @endforelse
</div>

<!-- 2. Desktop View (Table) - يظهر في الشاشات المتوسطة والكبيرة -->
<div class="minimal-card overflow-hidden d-none d-md-block">
    <div class="table-responsive custom-scrollbar">
        <table class="table align-middle mb-0 text-nowrap">
            <thead class="table-light">
                <tr class="small text-muted">
                    <th class="ps-4">USER</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th class="text-end pe-4">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar" style="width: 36px; height: 36px; font-size: 13px;">
                                    {{ strtoupper(substr($user->user_name, 0, 2)) }}
                                </div>
                                <a href="{{ route('users.show', $user->id) }}" class="fw-semibold text-dark text-decoration-none">
                                    {{ $user->user_name }}
                                </a>
                            </div>
                        </td>
                        <td class="small text-muted">{{ $user->email }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-1 text-uppercase" style="font-size: 10px; background: #e2e8f0; color: #334155;">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-1" style="font-size: 10px; {{ $user->status ? 'background: var(--emerald-soft, #d1fae5); color: var(--emerald-hover, #047857);' : 'background: #fef3c7; color: #d97706;' }}">
                                {{ $user->status ? 'Active' : 'Pending' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                                    View
                                </a>
                                @if(!$user->status)
                                    <form action="{{ route('users.activate', $user) }}" method="POST" class="d-inline mb-0">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-pill-emerald py-1 px-3" style="font-size: 0.78rem;">
                                            Activate
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted small">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection