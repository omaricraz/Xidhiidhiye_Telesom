@extends('layouts.master')

@section('title', 'My Profile')

@section('content')

<x-breadcrumb item="Profile" active="My Account"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-xl-4 col-lg-5">
            <!-- Profile Card -->
            <div class="card">
              <div class="card-body text-center">
                <div class="mb-4">
                  @if($user->profile_image)
                    <img src="{{ $user->profile_image }}" alt="{{ $user->full_name ?? $user->name }}" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" />
                  @else
                    <div class="avtar avtar-xxl rounded-circle bg-light-primary d-inline-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                      <span style="font-size: 60px;">{{ $user->status_emoji ?? '👤' }}</span>
                    </div>
                  @endif
                </div>
                <h4 class="mb-1">{{ $user->full_name ?? $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge bg-light-{{ $user->role === 'Manager' ? 'danger' : ($user->role === 'Team_Lead' ? 'warning' : 'primary') }} fs-6 px-3 py-2">
                  {{ $user->role }}
                </span>
                @if($user->team)
                <div class="mt-3">
                  <p class="mb-0">
                    <i class="ti ti-users me-2"></i>
                    <strong>Team:</strong> {{ $user->team->name }}
                  </p>
                </div>
                @endif
              </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="card mt-3">
              <div class="card-header">
                <h5>Quick Stats</h5>
              </div>
              <div class="card-body">
                <div class="row text-center">
                  <div class="col-6 mb-3">
                    <div class="d-flex flex-column">
                      <span class="h4 mb-0">{{ $user->assignedTasks()->count() }}</span>
                      <small class="text-muted">Assigned Tasks</small>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="d-flex flex-column">
                      <span class="h4 mb-0">{{ $user->createdTasks()->count() }}</span>
                      <small class="text-muted">Created Tasks</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex flex-column">
                      <span class="h4 mb-0">{{ $user->learningProgress()->where('is_completed', true)->count() }}</span>
                      <small class="text-muted">Completed Goals</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="d-flex flex-column">
                      <span class="h4 mb-0">{{ $user->learningProgress()->where('is_completed', false)->count() }}</span>
                      <small class="text-muted">Pending Goals</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-8 col-lg-7">
            <!-- Personal Information Card -->
            <div class="card">
              <div class="card-header">
                <h5>Personal Information</h5>
              </div>
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Full Name:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $user->full_name ?? 'N/A' }}
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Display Name:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $user->name }}
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Email Address:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $user->email }}
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Role:</strong>
                  </div>
                  <div class="col-sm-8">
                    <span class="badge bg-light-{{ $user->role === 'Manager' ? 'danger' : ($user->role === 'Team_Lead' ? 'warning' : 'primary') }}">
                      {{ $user->role }}
                    </span>
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Team:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $user->team->name ?? 'N/A' }}
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>Status Emoji:</strong>
                  </div>
                  <div class="col-sm-8">
                    <span style="font-size: 24px;">{{ $user->status_emoji ?? 'N/A' }}</span>
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-4">
                    <strong>User ID:</strong>
                  </div>
                  <div class="col-sm-8">
                    #{{ $user->id }}
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-4">
                    <strong>Member Since:</strong>
                  </div>
                  <div class="col-sm-8">
                    {{ $user->created_at->format('F d, Y') }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Tech Stack Card -->
            @if($user->tech_stack)
            <div class="card mt-3">
              <div class="card-header">
                <h5>Tech Stack</h5>
              </div>
              <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                  @foreach(explode(',', $user->tech_stack) as $tech)
                    <span class="badge bg-light-secondary fs-6 px-3 py-2">{{ trim($tech) }}</span>
                  @endforeach
                </div>
              </div>
            </div>
            @endif

            <!-- Activity Summary Card -->
            <div class="card mt-3">
              <div class="card-header">
                <h5>Activity Summary</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avtar avtar-s bg-light-primary">
                          <i class="ti ti-checklist"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">Tasks Assigned</h6>
                        <p class="text-muted mb-0">{{ $user->assignedTasks()->count() }} tasks</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avtar avtar-s bg-light-success">
                          <i class="ti ti-plus"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">Tasks Created</h6>
                        <p class="text-muted mb-0">{{ $user->createdTasks()->count() }} tasks</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avtar avtar-s bg-light-info">
                          <i class="ti ti-book"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">Learning Goals</h6>
                        <p class="text-muted mb-0">{{ $user->learningProgress()->count() }} goals</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <div class="flex-shrink-0">
                        <div class="avtar avtar-s bg-light-warning">
                          <i class="ti ti-check"></i>
                        </div>
                      </div>
                      <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">Completed Goals</h6>
                        <p class="text-muted mb-0">{{ $user->learningProgress()->where('is_completed', true)->count() }} completed</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection



