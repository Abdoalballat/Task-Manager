@extends('layouts.app') 

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h4 class="fw-bold mb-3">Add New User</h4>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('users.register') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control rounded-pill" value="{{ old('username') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control rounded-pill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">RePassword</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Role</label>
                        <select name="role" class="form-select rounded-pill" required>
                            <option value="employee" selected>Employee</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #065f46; color: white;">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection