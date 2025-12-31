@extends('layouts.master')

@section('title', 'Task Details')

@section('content')

<x-breadcrumb item="Tasks" active="Details"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Task Details</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Title:</strong> <span style="color: #92CF01; font-weight: 500;">{{ $task->title }}</span></p>
                    <p><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
                    <p><strong>Priority:</strong> 
                      <span class="badge bg-light-{{ $task->priority === 'High' ? 'danger' : ($task->priority === 'Medium' ? 'warning' : 'success') }}">
                        {{ $task->priority }}
                      </span>
                    </p>
                    <p><strong>Status:</strong> 
                      <span class="badge bg-light-{{ $task->status === 'Completed' ? 'success' : ($task->status === 'In_Progress' ? 'primary' : 'secondary') }}">
                        {{ $task->status }}
                      </span>
                    </p>
                  </div>
                  <div class="col-md-6">
                    <p><strong>Creator:</strong> {{ $task->creator->name }}</p>
                    <p><strong>Assignee:</strong> {{ $task->assignee->name ?? 'Unassigned' }}</p>
                    <p><strong>Created:</strong> {{ $task->created_at->format('Y-m-d H:i') }}</p>
                  </div>
                </div>
                <div class="mt-4">
                  @if(Auth::user()->isManager() || Auth::user()->isTeamLead())
                    <div class="text-end">
                      <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
                      @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit</a>
                      @endcan
                    </div>
                  @else
                    {{-- Normal users (Employee and Intern) see Accept and Completed buttons --}}
                    <div class="border-top pt-3">
                      <h6 class="mb-3">Actions</h6>
                      <div class="d-flex gap-2 flex-wrap align-items-center">
                        @if($task->assignee_id === Auth::id())
                          @if($task->status === 'Pending')
                            <form action="{{ route('tasks.accept', $task) }}" method="POST" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-info d-inline-flex align-items-center gap-2">
                                <i class="ti ti-check f-18"></i> Accept Task
                              </button>
                            </form>
                          @endif
                          @if($task->status !== 'Completed')
                            <form action="{{ route('tasks.completed', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Mark this task as completed?');">
                              @csrf
                              <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2">
                                <i class="ti ti-checkbox f-18"></i> Mark as Completed
                              </button>
                            </form>
                          @else
                            <div class="alert alert-success mb-0 py-2">
                              <i class="ti ti-check-circle"></i> This task has been completed.
                            </div>
                          @endif
                        @else
                          <div class="alert alert-info mb-0 py-2">
                            <i class="ti ti-info-circle"></i> This task is assigned to {{ $task->assignee->name ?? 'another user' }}. You can only accept or complete tasks assigned to you.
                          </div>
                        @endif
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary d-inline-flex align-items-center gap-2 ms-auto">
                          <i class="ti ti-arrow-left f-18"></i> Back to Tasks
                        </a>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection

