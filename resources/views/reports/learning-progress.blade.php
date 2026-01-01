@extends('layouts.master')

@section('title', 'Learning Progress Report')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/dataTables.bootstrap5.min.css" />
<style>
  @media print {
    .d-print-none { display: none !important; }
    .card { border: none; box-shadow: none; }
    body { background: white; }
    .card-header { border-bottom: 2px solid #000; }
  }
</style>
@endsection

@section('content')

<x-breadcrumb item="Reports" active="Learning Progress"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Learning Progress Report</h5>
                <div class="d-print-none">
                  <button class="btn btn-sm btn-primary" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i> Print
                  </button>
                </div>
              </div>
            </div>

            <!-- Filter Panel -->
            <div class="card mb-3 d-print-none">
              <div class="card-header">
                <button class="btn btn-link text-decoration-none p-0 w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true">
                  <i class="ti ti-filter me-2"></i> Filter Options
                  <i class="ti ti-chevron-down float-end"></i>
                </button>
              </div>
              <div class="collapse show" id="filterPanel">
                <div class="card-body">
                  <form method="GET" action="{{ route('reports.learning') }}" class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label">Date From</label>
                      <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] }}">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Date To</label>
                      <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] }}">
                    </div>
                    @if(Auth::user()->isManager())
                    <div class="col-md-4">
                      <label class="form-label">Team</label>
                      <select class="form-select" name="team_id">
                        <option value="">All Teams</option>
                        @foreach($teams as $team)
                          <option value="{{ $team->id }}" {{ $filters['team_id'] == $team->id ? 'selected' : '' }}>
                            {{ $team->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    @endif
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i> Apply Filters
                      </button>
                      <a href="{{ route('reports.learning') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-refresh me-1"></i> Reset
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-3">
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Total Goals</h5>
                      <i class="ti ti-school f-24 text-primary"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $totalGoals }}</h2>
                      <p class="text-muted mb-0">Learning Goals</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Completion Rate</h5>
                      <i class="ti ti-check f-24 text-success"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $overallCompletionRate }}%</h2>
                      <p class="text-muted mb-0">{{ $completedProgress }} / {{ $totalProgress }}</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Active Learners</h5>
                      <i class="ti ti-users f-24 text-info"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ count($userProgressData) }}</h2>
                      <p class="text-muted mb-0">Users with Progress</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Teams</h5>
                      <i class="ti ti-building f-24 text-warning"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ count($goalsByTeam) }}</h2>
                      <p class="text-muted mb-0">Active Teams</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts -->
            @if(!empty($goalsByTeam))
            <div class="row mb-3">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Learning Goals by Team</h5>
                  </div>
                  <div class="card-body">
                    <div id="team-chart"></div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <!-- User Progress Table -->
            <div class="card mb-3">
              <div class="card-header">
                <h5 class="mb-0">User Progress Overview</h5>
              </div>
              <div class="card-body">
                @if(count($userProgressData) > 0)
                <div class="table-responsive">
                  <table class="table table-hover" id="progress-table">
                    <thead>
                      <tr>
                        <th>User</th>
                        <th>Team</th>
                        <th>Total Goals</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                        <th>Progress</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($userProgressData as $data)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="avtar avtar-xs me-2">
                              <img src="{{ $data['user']->getProfileImageUrl() }}" alt="{{ $data['user']->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                            <div>
                              <h6 class="mb-0">{{ $data['user']->name }}</h6>
                            </div>
                          </div>
                        </td>
                        <td>{{ $data['user']->team ? $data['user']->team->name : 'No Team' }}</td>
                        <td>{{ $data['total_goals'] }}</td>
                        <td>{{ $data['completed_goals'] }}</td>
                        <td><span class="badge bg-{{ $data['completion_rate'] >= 80 ? 'success' : ($data['completion_rate'] >= 50 ? 'warning' : 'danger') }}">{{ $data['completion_rate'] }}%</span></td>
                        <td>
                          <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-{{ $data['completion_rate'] >= 80 ? 'success' : ($data['completion_rate'] >= 50 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $data['completion_rate'] }}%"></div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="text-center py-5">
                  <p class="text-muted">No learning progress data found.</p>
                </div>
                @endif
              </div>
            </div>

            <!-- Learning Goals Details -->
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">Learning Goals Details</h5>
              </div>
              <div class="card-body">
                @if($learningGoals->count() > 0)
                <div class="table-responsive">
                  <table class="table table-hover" id="goals-table">
                    <thead>
                      <tr>
                        <th>Goal</th>
                        <th>Team</th>
                        <th>Total Users</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($progressStats as $stat)
                      <tr>
                        <td>
                          <h6 class="mb-0">{{ $stat['goal']->title }}</h6>
                          @if($stat['goal']->description)
                          <small class="text-muted">{{ Str::limit($stat['goal']->description, 50) }}</small>
                          @endif
                        </td>
                        <td>{{ $stat['goal']->team ? $stat['goal']->team->name : 'Global' }}</td>
                        <td>{{ $stat['total_users'] }}</td>
                        <td>{{ $stat['completed_users'] }}</td>
                        <td>
                          <span class="badge bg-{{ $stat['completion_rate'] >= 80 ? 'success' : ($stat['completion_rate'] >= 50 ? 'warning' : 'danger') }}">
                            {{ $stat['completion_rate'] }}%
                          </span>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="text-center py-5">
                  <p class="text-muted">No learning goals found.</p>
                </div>
                @endif
              </div>
            </div>

            <div class="d-none d-print-block mt-4">
              <div class="text-center text-muted">
                <p class="mb-0">Report generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
                <p class="mb-0">Xidhiidhiye - Learning Progress Report</p>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/build/js/plugins/dataTables.min.js"></script>
<script src="/build/js/plugins/dataTables.bootstrap5.min.js"></script>
<script src="/build/js/plugins/apexcharts.min.js"></script>
<script>
  $(document).ready(function() {
    $('#progress-table, #goals-table').DataTable({
      responsive: true,
      pageLength: 25,
    });
  });

  @if(!empty($goalsByTeam))
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      const theme = document.body.getAttribute('data-pc-theme') || 'light';
      const colors = theme === 'dark' ? '#9BB5FF' : '#008000';
      const teamData = @json($goalsByTeam);
      
      const options = {
        series: [{ name: 'Goals', data: Object.values(teamData) }],
        chart: { type: 'bar', height: 350, horizontal: true },
        colors: [colors],
        xaxis: { categories: Object.keys(teamData) },
      };
      new ApexCharts(document.querySelector('#team-chart'), options).render();
    }, 500);
  });
  @endif
</script>
@endsection

