@extends('layouts.master')

@section('title', 'Onboarding - Learning Goals')

@section('css')
<style>
  .learning-goal-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .learning-goal-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
</style>
@endsection

@section('content')

<x-breadcrumb item="Learning Goals" active="Learning Goals"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            @can('create', App\Models\LearningGoal::class)
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="mb-0">Onboarding Learning Goals</h5>
              <a href="{{ route('onboarding.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                <i class="ti ti-plus f-18"></i> Add Learning Goal
              </a>
            </div>
            @else
            <h5 class="mb-4">Onboarding Learning Goals</h5>
            @endcan

            @if($goals->count() > 0)
              <div class="row">
                @foreach($goals as $goal)
                  @php
                    $isCompleted = isset($userProgressData[$goal->id]) && $userProgressData[$goal->id]['is_completed'];
                    $completedAt = isset($userProgressData[$goal->id]) ? $userProgressData[$goal->id]['completed_at'] : null;
                    $iconClass = $isCompleted ? 'ti ti-certificate' : 'ti ti-book';
                    $iconBg = $isCompleted ? 'bg-light-success' : 'bg-light-primary';
                  @endphp
                  
                  <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100 learning-goal-card {{ $isCompleted ? 'border-start border-4 border-success' : 'border-start border-4 border-primary' }}">
                      <div class="card-body">
                        <!-- Header with Icon and Status -->
                        <div class="d-flex align-items-start justify-content-between mb-3">
                          <div class="d-flex align-items-center gap-3">
                            <div class="avtar avtar-s {{ $iconBg }}">
                              <i class="{{ $iconClass }} f-20 {{ $isCompleted ? 'text-success' : 'text-primary' }}"></i>
                            </div>
                            <div class="flex-grow-1">
                              <h5 class="mb-1">{{ $goal->title }}</h5>
                              @if($isCompleted)
                                <span class="badge bg-light-success border border-success">
                                  <i class="ti ti-check f-12 me-1"></i> Completed
                                </span>
                              @else
                                <span class="badge bg-light-secondary border border-secondary">
                                  <i class="ti ti-clock f-12 me-1"></i> In Progress
                                </span>
                              @endif
                            </div>
                          </div>
                          
                          @can('update', $goal)
                          <div class="dropdown">
                            <a
                              class="avtar avtar-s btn-link-secondary dropdown-toggle arrow-none"
                              href="#"
                              data-bs-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              <i class="ti ti-dots-vertical f-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{ route('onboarding.edit', $goal) }}">
                                <i class="ti ti-edit me-2"></i> Edit
                              </a>
                              @can('delete', $goal)
                              <form action="{{ route('onboarding.destroy', $goal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this learning goal?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                  <i class="ti ti-trash me-2"></i> Delete
                                </button>
                              </form>
                              @endcan
                            </div>
                          </div>
                          @endcan
                        </div>

                        <!-- Description -->
                        @if($goal->description)
                        <p class="text-muted mb-3">{{ Str::limit($goal->description, 120) }}</p>
                        @endif

                        <!-- Team and Resource Info -->
                        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                          <div class="d-flex align-items-center gap-1">
                            <i class="ti ti-users f-16 text-muted"></i>
                            <small class="text-muted">
                              {{ $goal->team_id ? ($goal->team ? $goal->team->name : 'N/A') : 'All Teams' }}
                            </small>
                          </div>
                          @if($goal->resource_url)
                          <a href="{{ $goal->resource_url }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                            <i class="ti ti-external-link f-14"></i> View Resource
                          </a>
                          @endif
                        </div>

                        <!-- Completion Status or Action Button -->
                        <div class="mt-auto">
                          @if($isCompleted)
                            <div class="d-flex align-items-center gap-2 text-success">
                              <i class="ti ti-check-circle f-18"></i>
                              <small>
                                Completed 
                                @if($completedAt)
                                  on {{ \Carbon\Carbon::parse($completedAt)->format('M d, Y') }}
                                @endif
                              </small>
                            </div>
                          @else
                            @if((Auth::user()->isEmployee() || Auth::user()->isIntern()))
                              <form action="{{ route('onboarding.mark-completed', $goal) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2">
                                  <i class="ti ti-check f-18"></i> Mark as Completed
                                </button>
                              </form>
                            @endif
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <!-- Empty State -->
              <div class="card">
                <div class="card-body text-center py-5">
                  <div class="avtar avtar-xl mx-auto mb-3 bg-light-primary">
                    <i class="ti ti-book f-48 text-primary"></i>
                  </div>
                  <h5 class="mb-2">No Learning Goals Available</h5>
                  <p class="text-muted mb-4">Get started by creating your first learning goal</p>
                  @can('create', App\Models\LearningGoal::class)
                  <a href="{{ route('onboarding.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="ti ti-plus f-18"></i> Add Learning Goal
                  </a>
                  @endcan
                </div>
              </div>
            @endif
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection
