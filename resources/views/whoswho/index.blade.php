@extends('layouts.master')

@section('title', 'Who\'s Who')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/style.css" />
@endsection

@section('content')

<x-breadcrumb item="Team Structure" active="Team Members"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ sample-page ] start -->
          <div class="col-sm-12">
            @if(isset($isManager) && $isManager)
              <!-- Manager View: Teams Divided -->
              @foreach($teamsWithMembers as $teamName => $members)
                @if($members->count() > 0)
                <div class="mb-5">
                  <h4 class="mb-3">
                    {{ $teamName }} Team
                  </h4>
                  <div class="row g-3">
                    @foreach($members as $member)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                      <div class="card h-100 shadow-sm">
                        <!-- Profile Image Section -->
                        <div class="card-body text-center pb-2 profile-card-gradient" style="border-radius: 0.375rem 0.375rem 0 0;">
                          <div class="position-relative d-inline-block">
                            <img src="{{ $member->getProfileImageUrl() }}" 
                                 alt="{{ $member->name }}" 
                                 class="rounded-circle border border-4 border-white shadow" 
                                 style="width: 100px; height: 100px; object-fit: cover;" />
                            <!-- Status Indicator Badge -->
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill border border-2 border-white d-flex align-items-center justify-content-center bg-{{ $member->getStatusBadgeColor() }}" 
                                  style="width: 32px; height: 32px;">
                              <i class="ti {{ $member->getStatusIcon() }} text-white" style="font-size: 14px;"></i>
                            </span>
                          </div>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="card-body pt-3">
                          <div class="text-center mb-3">
                            <h6 class="card-title mb-1 fw-semibold">{{ $member->name }}</h6>
                            <p class="text-muted f-12 mb-2">{{ $member->email }}</p>
                            
                            <!-- Status Badge -->
                            <span class="badge bg-light-{{ $member->getStatusBadgeColor() }} text-{{ $member->getStatusBadgeColor() }} rounded-pill px-3 py-1 mb-2">
                              <i class="ti {{ $member->getStatusIcon() }} me-1"></i>
                              {{ $member->getStatusLabel() }}
                            </span>
                          </div>
                          
                          <hr class="my-3">
                          
                          <div class="mb-2">
                            <small class="text-muted d-block mb-1">
                              <i class="ti ti-briefcase me-1"></i>Role
                            </small>
                            <span class="badge bg-light-{{ $member->role === 'Manager' ? 'danger' : ($member->role === 'Team_Lead' ? 'warning' : 'primary') }}">
                              {{ $member->role }}
                            </span>
                          </div>
                          
                          <div class="mb-2">
                            <small class="text-muted d-block mb-1">
                              <i class="ti ti-users me-1"></i>Team
                            </small>
                            <p class="mb-0 f-14">{{ $teamName }}</p>
                          </div>
                          
                          @if($member->tech_stack)
                          <div class="mb-2">
                            <small class="text-muted d-block mb-1">
                              <i class="ti ti-code me-1"></i>Tech Stack
                            </small>
                            <div class="d-flex flex-wrap gap-1">
                              @foreach(explode(',', $member->tech_stack) as $tech)
                                <span class="badge bg-light-secondary">{{ trim($tech) }}</span>
                              @endforeach
                            </div>
                          </div>
                          @endif
                        </div>
                        
                        <div class="card-footer bg-transparent border-top-0 pt-0">
                          <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                              <i class="ti ti-id me-1"></i>ID: #{{ $member->id }}
                            </small>
                            @if($member->status_emoji)
                            <span style="font-size: 18px;">{{ $member->status_emoji }}</span>
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
                @endif
              @endforeach

              @if(isset($usersWithoutTeam) && $usersWithoutTeam->count() > 0)
              <!-- Users Without Team Section -->
              <div class="mb-4">
                <h5 class="mb-3">
                  <span class="badge bg-light-secondary me-2">{{ $usersWithoutTeam->count() }}</span>
                  Users Without Team
                </h5>
                <div class="row g-3">
                  @foreach($usersWithoutTeam as $member)
                  <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm">
                      <!-- Profile Image Section -->
                      <div class="card-body text-center pb-2 profile-card-gradient" style="border-radius: 0.375rem 0.375rem 0 0;">
                        <div class="position-relative d-inline-block">
                          <img src="{{ $member->getProfileImageUrl() }}" 
                               alt="{{ $member->name }}" 
                               class="rounded-circle border border-4 border-white shadow" 
                               style="width: 100px; height: 100px; object-fit: cover;" />
                          <!-- Status Indicator Badge -->
                          <span class="position-absolute bottom-0 end-0 badge rounded-pill border border-2 border-white d-flex align-items-center justify-content-center bg-{{ $member->getStatusBadgeColor() }}" 
                                style="width: 32px; height: 32px;">
                            <i class="ti {{ $member->getStatusIcon() }} text-white" style="font-size: 14px;"></i>
                          </span>
                        </div>
                      </div>
                      
                      <!-- Card Content -->
                      <div class="card-body pt-3">
                        <div class="text-center mb-3">
                          <h6 class="card-title mb-1 fw-semibold">{{ $member->name }}</h6>
                          <p class="text-muted f-12 mb-2">{{ $member->email }}</p>
                          
                          <!-- Status Badge -->
                          <span class="badge bg-light-{{ $member->getStatusBadgeColor() }} text-{{ $member->getStatusBadgeColor() }} rounded-pill px-3 py-1 mb-2">
                            <i class="ti {{ $member->getStatusIcon() }} me-1"></i>
                            {{ $member->getStatusLabel() }}
                          </span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-briefcase me-1"></i>Role
                          </small>
                          <span class="badge bg-light-{{ $member->role === 'Manager' ? 'danger' : ($member->role === 'Team_Lead' ? 'warning' : 'primary') }}">
                            {{ $member->role }}
                          </span>
                        </div>
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-users me-1"></i>Team
                          </small>
                          <p class="mb-0 f-14">N/A</p>
                        </div>
                        
                        @if($member->tech_stack)
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-code me-1"></i>Tech Stack
                          </small>
                          <div class="d-flex flex-wrap gap-1">
                            @foreach(explode(',', $member->tech_stack) as $tech)
                              <span class="badge bg-light-secondary">{{ trim($tech) }}</span>
                            @endforeach
                          </div>
                        </div>
                        @endif
                      </div>
                      
                      <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">
                            <i class="ti ti-id me-1"></i>ID: #{{ $member->id }}
                          </small>
                          @if($member->status_emoji)
                          <span style="font-size: 18px;">{{ $member->status_emoji }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif
            @else
              <!-- Non-Manager View: Original Structure -->
              @if($teamMembers->count() > 0)
              <!-- Team Members Section -->
              <div class="mb-4">
                <h5 class="mb-3">
                  <span class="badge bg-light-primary me-2">{{ $teamMembers->count() }}</span>
                  My Team Members
                  @if($user->team)
                    <small class="text-muted">({{ $user->team->name }})</small>
                  @endif
                </h5>
                <div class="row g-3">
                  @foreach($teamMembers as $member)
                  <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm">
                      <!-- Profile Image Section -->
                      <div class="card-body text-center pb-2 profile-card-gradient" style="border-radius: 0.375rem 0.375rem 0 0;">
                        <div class="position-relative d-inline-block">
                          <img src="{{ $member->getProfileImageUrl() }}" 
                               alt="{{ $member->name }}" 
                               class="rounded-circle border border-4 border-white shadow" 
                               style="width: 100px; height: 100px; object-fit: cover;" />
                          <!-- Status Indicator Badge -->
                          <span class="position-absolute bottom-0 end-0 badge rounded-pill border border-2 border-white d-flex align-items-center justify-content-center bg-{{ $member->getStatusBadgeColor() }}" 
                                style="width: 32px; height: 32px;">
                            <i class="ti {{ $member->getStatusIcon() }} text-white" style="font-size: 14px;"></i>
                          </span>
                        </div>
                      </div>
                      
                      <!-- Card Content -->
                      <div class="card-body pt-3">
                        <div class="text-center mb-3">
                          <h6 class="card-title mb-1 fw-semibold">{{ $member->name }}</h6>
                          <p class="text-muted f-12 mb-2">{{ $member->email }}</p>
                          
                          <!-- Status Badge -->
                          <span class="badge bg-light-{{ $member->getStatusBadgeColor() }} text-{{ $member->getStatusBadgeColor() }} rounded-pill px-3 py-1 mb-2">
                            <i class="ti {{ $member->getStatusIcon() }} me-1"></i>
                            {{ $member->getStatusLabel() }}
                          </span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-briefcase me-1"></i>Role
                          </small>
                          <span class="badge bg-light-{{ $member->role === 'Manager' ? 'danger' : ($member->role === 'Team_Lead' ? 'warning' : 'primary') }}">
                            {{ $member->role }}
                          </span>
                        </div>
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-users me-1"></i>Team
                          </small>
                          <p class="mb-0 f-14">{{ $member->team->name ?? 'N/A' }}</p>
                        </div>
                        
                        @if($member->tech_stack)
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-code me-1"></i>Tech Stack
                          </small>
                          <div class="d-flex flex-wrap gap-1">
                            @foreach(explode(',', $member->tech_stack) as $tech)
                              <span class="badge bg-light-secondary">{{ trim($tech) }}</span>
                            @endforeach
                          </div>
                        </div>
                        @endif
                      </div>
                      
                      <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">
                            <i class="ti ti-id me-1"></i>ID: #{{ $member->id }}
                          </small>
                          @if($member->status_emoji)
                          <span style="font-size: 18px;">{{ $member->status_emoji }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif

              @if($otherMembers->count() > 0)
              <!-- Other Team Members Section -->
              <div>
                <h5 class="mb-3">
                  <span class="badge bg-light-secondary me-2">{{ $otherMembers->count() }}</span>
                  Other Team Members
                </h5>
                <div class="row g-3">
                  @foreach($otherMembers as $member)
                  <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm">
                      <!-- Profile Image Section -->
                      <div class="card-body text-center pb-2 profile-card-gradient" style="border-radius: 0.375rem 0.375rem 0 0;">
                        <div class="position-relative d-inline-block">
                          <img src="{{ $member->getProfileImageUrl() }}" 
                               alt="{{ $member->name }}" 
                               class="rounded-circle border border-4 border-white shadow" 
                               style="width: 100px; height: 100px; object-fit: cover;" />
                          <!-- Status Indicator Badge -->
                          <span class="position-absolute bottom-0 end-0 badge rounded-pill border border-2 border-white d-flex align-items-center justify-content-center bg-{{ $member->getStatusBadgeColor() }}" 
                                style="width: 32px; height: 32px;">
                            <i class="ti {{ $member->getStatusIcon() }} text-white" style="font-size: 14px;"></i>
                          </span>
                        </div>
                      </div>
                      
                      <!-- Card Content -->
                      <div class="card-body pt-3">
                        <div class="text-center mb-3">
                          <h6 class="card-title mb-1 fw-semibold">{{ $member->name }}</h6>
                          <p class="text-muted f-12 mb-2">{{ $member->email }}</p>
                          
                          <!-- Status Badge -->
                          <span class="badge bg-light-{{ $member->getStatusBadgeColor() }} text-{{ $member->getStatusBadgeColor() }} rounded-pill px-3 py-1 mb-2">
                            <i class="ti {{ $member->getStatusIcon() }} me-1"></i>
                            {{ $member->getStatusLabel() }}
                          </span>
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-briefcase me-1"></i>Role
                          </small>
                          <span class="badge bg-light-{{ $member->role === 'Manager' ? 'danger' : ($member->role === 'Team_Lead' ? 'warning' : 'primary') }}">
                            {{ $member->role }}
                          </span>
                        </div>
                        
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-users me-1"></i>Team
                          </small>
                          <p class="mb-0 f-14">{{ $member->team->name ?? 'N/A' }}</p>
                        </div>
                        
                        @if($member->tech_stack)
                        <div class="mb-2">
                          <small class="text-muted d-block mb-1">
                            <i class="ti ti-code me-1"></i>Tech Stack
                          </small>
                          <div class="d-flex flex-wrap gap-1">
                            @foreach(explode(',', $member->tech_stack) as $tech)
                              <span class="badge bg-light-secondary">{{ trim($tech) }}</span>
                            @endforeach
                          </div>
                        </div>
                        @endif
                      </div>
                      
                      <div class="card-footer bg-transparent border-top-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                          <small class="text-muted">
                            <i class="ti ti-id me-1"></i>ID: #{{ $member->id }}
                          </small>
                          @if($member->status_emoji)
                          <span style="font-size: 18px;">{{ $member->status_emoji }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              @endif
            @endif
          </div>
          <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
    <!-- No scripts needed for card groups -->
@endsection
