@extends('layouts.app')

@section('title', 'Users Directory')

@section('content')
<head>
    <style>
        .bi bi-people fs-5{
            background-color: #059669;
        }
    </style>
</head>
<!-- Header Ribbon -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-2 border-bottom border-light">
    <div>
        <h3 class="fw-bold mb-1 text-dark fs-4 fs-md-3">Users Directory</h3>
        <p class="small mb-0 text-muted">Manage system access, team workload, and activation statuses</p>
    </div>
    <div class="d-flex align-items-center gap-2" >
        <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-sm" style="background-color: #059669; color: #ffffff; border: none;>
        <i class="bi bi-plus-lg"></i>
        <span>Add User</span>
    </a>
    
    <span class="badge rounded-pill px-3 py-2" style="background-color: #d1fae5; color: #065f46; font-size: 0.85rem;">
        Total: {{ $users->count() }}
    </span>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-outline-danger rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2 small shadow-sm">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
    </button>
    </form>
</div>     
</div>

<!-- Users Table Card -->
<div class="minimal-card overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr class="small text-muted">
                    <th class="ps-4">USER</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th></th>
                    <th>STATUS</th>
                    <th class="text-end pe-4">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-semibold text-white flex-shrink-0" style="width: 36px; height: 36px; background-color: var(--emerald-primary); font-size: 13px;">
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

                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-1" style="font-size: 10px; {{ $user->status ? 'background: var(--emerald-soft); color: var(--emerald-hover);' : 'background: #fef3c7; color: #d97706;' }}">
                                {{ $user->status ? 'Active' : 'Pending' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                                    View
                                </a>
                                @if(!$user->status)
                                    <form action="{{ route('users.activate', $user) }}" method="POST" class="d-inline">
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
                        <td colspan="6" class="text-center py-4 text-muted small">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection