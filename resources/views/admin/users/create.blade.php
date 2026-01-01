@extends('layouts.master')

@section('title', 'Create User')

@section('content')

<x-breadcrumb item="User Management" active="Create User"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Create New User</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}">
                        @error('full_name')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        @error('email')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                          <option value="">Select Role</option>
                          <option value="Manager" {{ old('role') === 'Manager' ? 'selected' : '' }}>Manager</option>
                          <option value="Team_Lead" {{ old('role') === 'Team_Lead' ? 'selected' : '' }}>Team Lead</option>
                          <option value="Employee" {{ old('role') === 'Employee' ? 'selected' : '' }}>Employee</option>
                          <option value="Intern" {{ old('role') === 'Intern' ? 'selected' : '' }}>Intern</option>
                        </select>
                        @error('role')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Team</label>
                        <select class="form-select @error('team_id') is-invalid @enderror" name="team_id">
                          <option value="">No Team</option>
                          @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                          @endforeach
                        </select>
                        @error('team_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Tech Stack (comma separated)</label>
                        <input type="text" class="form-control @error('tech_stack') is-invalid @enderror" name="tech_stack" value="{{ old('tech_stack') }}" placeholder="Laravel, PHP, JavaScript">
                        @error('tech_stack')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Status Emoji</label>
                        <input type="text" class="form-control @error('status_emoji') is-invalid @enderror" name="status_emoji" value="{{ old('status_emoji') }}" placeholder="😊">
                        @error('status_emoji')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create User</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection



