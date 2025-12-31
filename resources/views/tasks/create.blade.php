@extends('layouts.master')

@section('title', 'Create Task')

@section('content')

<x-breadcrumb item="Tasks" active="Create"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Create New Task</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select class="form-select @error('priority') is-invalid @enderror" name="priority" required>
                          <option value="Normal" {{ old('priority') === 'Normal' ? 'selected' : '' }}>Normal</option>
                          <option value="Medium" {{ old('priority') === 'Medium' ? 'selected' : '' }}>Medium</option>
                          <option value="High" {{ old('priority') === 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                          <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                          <option value="In_Progress" {{ old('status') === 'In_Progress' ? 'selected' : '' }}>In Progress</option>
                          <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Assignee</label>
                        <select class="form-select @error('assignee_id') is-invalid @enderror" name="assignee_id">
                          <option value="">Unassigned</option>
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                          @endforeach
                        </select>
                        @error('assignee_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection


