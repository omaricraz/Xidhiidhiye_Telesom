@extends('layouts.master')

@section('title', 'Edit Task')

@section('content')

<x-breadcrumb item="Tasks" active="Edit"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Edit Task</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $task->title) }}" {{ Auth::user()->isIntern() ? 'readonly' : 'required' }}>
                        @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4" {{ Auth::user()->isIntern() ? 'readonly' : '' }}>{{ old('description', $task->description) }}</textarea>
                        @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select class="form-select @error('priority') is-invalid @enderror" name="priority" {{ Auth::user()->isIntern() ? 'disabled' : 'required' }}>
                          <option value="Normal" {{ old('priority', $task->priority) === 'Normal' ? 'selected' : '' }}>Normal</option>
                          <option value="Medium" {{ old('priority', $task->priority) === 'Medium' ? 'selected' : '' }}>Medium</option>
                          <option value="High" {{ old('priority', $task->priority) === 'High' ? 'selected' : '' }}>High</option>
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
                          <option value="Pending" {{ old('status', $task->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                          <option value="In_Progress" {{ old('status', $task->status) === 'In_Progress' ? 'selected' : '' }}>In Progress</option>
                          <option value="Completed" {{ old('status', $task->status) === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Assignee</label>
                        <select class="form-select @error('assignee_id') is-invalid @enderror" name="assignee_id" {{ Auth::user()->isIntern() ? 'disabled' : '' }}>
                          <option value="">Unassigned</option>
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assignee_id', $task->assignee_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
                    <button type="submit" class="btn btn-primary">Update Task</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection


