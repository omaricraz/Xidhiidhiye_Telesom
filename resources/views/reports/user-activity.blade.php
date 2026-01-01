@extends('layouts.master')

@section('title', 'User Activity Report')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="/build/css/plugins/responsive.bootstrap5.min.css" />
<style>
  @media print {
    .d-print-none { display: none !important; }
    .card { border: none; box-shadow: none; }
    .page-break { page-break-after: always; }
    body { background: white; }
    .card-header { border-bottom: 2px solid #000; }
  }
</style>
@endsection

@section('content')

<x-breadcrumb item="Reports" active="User Activity"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <!-- Report Header -->
            <div class="card mb-3">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User Activity Report</h5>
                <div class="d-print-none">
                  <button class="btn btn-sm btn-primary" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i> Print
                  </button>
                  <a href="{{ route('reports.users.pdf', $filters) }}" class="btn btn-sm btn-success">
                    <i class="ti ti-download me-1"></i> Download PDF
                  </a>
                  <a href="{{ route('reports.users.export', $filters) }}" class="btn btn-sm btn-info">
                    <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
                  </a>
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
                  <form method="GET" action="{{ route('reports.users') }}" class="row g-3">
                    <div class="col-md-3">
                      <label class="form-label">Date From</label>
                      <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] }}">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Date To</label>
                      <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] }}">
                    </div>
                    @if(Auth::user()->isManager())
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                      <label class="form-label">Role</label>
                      <select class="form-select" name="role">
                        <option value="">All Roles</option>
                        <option value="Manager" {{ $filters['role'] == 'Manager' ? 'selected' : '' }}>Manager</option>
                        <option value="Team_Lead" {{ $filters['role'] == 'Team_Lead' ? 'selected' : '' }}>Team Lead</option>
                        <option value="Employee" {{ $filters['role'] == 'Employee' ? 'selected' : '' }}>Employee</option>
                        <option value="Intern" {{ $filters['role'] == 'Intern' ? 'selected' : '' }}>Intern</option>
                      </select>
                    </div>
                    @endif
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i> Apply Filters
                      </button>
                      <a href="{{ route('reports.users') }}" class="btn btn-outline-secondary">
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
                      <h5 class="mb-0">Total Users</h5>
                      <i class="ti ti-users f-24 text-primary"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $totalUsers }}</h2>
                      <p class="text-muted mb-0">All Users</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Active Users</h5>
                      <i class="ti ti-user-check f-24 text-success"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $activeUsers }}</h2>
                      <p class="text-muted mb-0">{{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 }}% Active</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Teams</h5>
                      <i class="ti ti-building f-24 text-info"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ count($usersByTeam) }}</h2>
                      <p class="text-muted mb-0">Active Teams</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Roles</h5>
                      <i class="ti ti-user-circle f-24 text-warning"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ count($usersByRole) }}</h2>
                      <p class="text-muted mb-0">Different Roles</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts -->
            <div class="row mb-3">
              <div class="col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Users by Role</h5>
                  </div>
                  <div class="card-body">
                    <div id="role-chart"></div>
                  </div>
                </div>
              </div>
              
              @if(!empty($usersByTeam))
              <div class="col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Users by Team</h5>
                  </div>
                  <div class="card-body">
                    <div id="team-chart"></div>
                  </div>
                </div>
              </div>
              @endif
            </div>

            <!-- User Activity Table -->
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User Activity Details</h5>
                <div class="d-print-none">
                  <span class="text-muted">Total: {{ $totalUsers }} users</span>
                </div>
              </div>
              <div class="card-body">
                @if(count($userActivityData) > 0)
                <div class="table-responsive">
                  <table class="table table-hover" id="users-table">
                    <thead>
                      <tr>
                        <th>User</th>
                        <th>Team</th>
                        <th>Role</th>
                        <th>Tasks Created</th>
                        <th>Tasks Completed</th>
                        <th>Questions Asked</th>
                        <th>Total Activity</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($userActivityData as $data)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="avtar avtar-xs me-2">
                              <img src="{{ $data['user']->getProfileImageUrl() }}" alt="{{ $data['user']->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                            <div>
                              <h6 class="mb-0">{{ $data['user']->name }}</h6>
                              <small class="text-muted">{{ $data['user']->email }}</small>
                            </div>
                          </div>
                        </td>
                        <td>{{ $data['user']->team ? $data['user']->team->name : 'No Team' }}</td>
                        <td><span class="badge bg-secondary">{{ $data['user']->role }}</span></td>
                        <td>{{ $data['tasks_created'] }}</td>
                        <td>{{ $data['tasks_completed'] }}</td>
                        <td>{{ $data['questions_asked'] }}</td>
                        <td><strong>{{ $data['total_activity'] }}</strong></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="text-center py-5">
                  <i class="ti ti-inbox f-48 text-muted mb-3"></i>
                  <p class="text-muted">No user activity data found for the selected filters.</p>
                </div>
                @endif
              </div>
            </div>

            <!-- Report Footer -->
            <div class="d-none d-print-block mt-4">
              <div class="text-center text-muted">
                <p class="mb-0">Report generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
                <p class="mb-0">Xidhiidhiye - User Activity Report</p>
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
    $('#users-table').DataTable({
      responsive: true,
      order: [[6, 'desc']],
      pageLength: 25,
    });
  });

  function getCurrentTheme() {
    return document.body.getAttribute('data-pc-theme') || 'light';
  }

  function getChartColors() {
    const theme = getCurrentTheme();
    return {
      primary: theme === 'dark' ? '#9BB5FF' : '#008000',
      success: theme === 'dark' ? '#4ade80' : '#28a745',
      warning: theme === 'dark' ? '#fbbf24' : '#ffc107',
      danger: theme === 'dark' ? '#f87171' : '#dc3545',
      info: theme === 'dark' ? '#60a5fa' : '#17a2b8',
    };
  }

  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      const colors = getChartColors();
      const roleData = @json($usersByRole);
      
      // Role Chart
      const roleOptions = {
        series: Object.values(roleData),
        chart: { type: 'donut', height: 350 },
        labels: Object.keys(roleData),
        colors: [colors.primary, colors.success, colors.info, colors.warning],
        legend: { position: 'bottom' },
        dataLabels: { enabled: true, formatter: function(val) { return val.toFixed(1) + '%'; } }
      };
      new ApexCharts(document.querySelector('#role-chart'), roleOptions).render();
      
      @if(!empty($usersByTeam))
      // Team Chart
      const teamData = @json($usersByTeam);
      const teamOptions = {
        series: [{ name: 'Users', data: Object.values(teamData) }],
        chart: { type: 'bar', height: 350, horizontal: true },
        colors: [colors.info],
        xaxis: { categories: Object.keys(teamData) },
      };
      new ApexCharts(document.querySelector('#team-chart'), teamOptions).render();
      @endif
    }, 500);
  });

  function exportToPDF() {
    alert('PDF export functionality will be implemented.');
  }
</script>
@endsection

