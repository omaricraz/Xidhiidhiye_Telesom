@extends('layouts.master')

@section('title', 'Team Performance Report')

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

<x-breadcrumb item="Reports" active="Team Performance"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Team Performance Report</h5>
                <div class="d-print-none">
                  <button class="btn btn-sm btn-primary" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i> Print
                  </button>
                  <a href="{{ route('reports.teams.pdf', $filters) }}" class="btn btn-sm btn-success">
                    <i class="ti ti-download me-1"></i> Download PDF
                  </a>
                  <a href="{{ route('reports.teams.export', $filters) }}" class="btn btn-sm btn-info">
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
                  <form method="GET" action="{{ route('reports.teams') }}" class="row g-3">
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
                        @foreach($allTeams as $team)
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
                      <a href="{{ route('reports.teams') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-refresh me-1"></i> Reset
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Team Performance Table -->
            <div class="card">
              <div class="card-header">
                <h5 class="mb-0">Team Performance Overview</h5>
              </div>
              <div class="card-body">
                @if(count($teamPerformanceData) > 0)
                <div class="table-responsive">
                  <table class="table table-hover" id="teams-table">
                    <thead>
                      <tr>
                        <th>Team</th>
                        <th>Lead</th>
                        <th>Members</th>
                        <th>Tasks</th>
                        <th>Completed</th>
                        <th>Completion Rate</th>
                        <th>Learning Goals</th>
                        <th>Questions</th>
                        <th>Productivity Score</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($teamPerformanceData as $data)
                      <tr>
                        <td>
                          <h6 class="mb-0">{{ $data['team']->name }}</h6>
                        </td>
                        <td>{{ $data['team']->lead ? $data['team']->lead->name : 'No Lead' }}</td>
                        <td>{{ $data['member_count'] }}</td>
                        <td>{{ $data['total_tasks'] }}</td>
                        <td>{{ $data['completed_tasks'] }}</td>
                        <td>
                          <span class="badge bg-{{ $data['completion_rate'] >= 80 ? 'success' : ($data['completion_rate'] >= 50 ? 'warning' : 'danger') }}">
                            {{ $data['completion_rate'] }}%
                          </span>
                        </td>
                        <td>{{ $data['completed_goals'] }} / {{ $data['total_goals'] }}</td>
                        <td>{{ $data['questions_asked'] }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <strong class="me-2">{{ number_format($data['productivity_score'], 1) }}</strong>
                            <div class="progress" style="width: 100px; height: 8px;">
                              <div class="progress-bar bg-{{ $data['productivity_score'] >= 80 ? 'success' : ($data['productivity_score'] >= 50 ? 'warning' : 'danger') }}" 
                                   style="width: {{ $data['productivity_score'] }}%"></div>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="text-center py-5">
                  <p class="text-muted">No team performance data found.</p>
                </div>
                @endif
              </div>
            </div>

            <div class="d-none d-print-block mt-4">
              <div class="text-center text-muted">
                <p class="mb-0">Report generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
                <p class="mb-0">Xidhiidhiye - Team Performance Report</p>
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
<script>
  $(document).ready(function() {
    $('#teams-table').DataTable({
      responsive: true,
      order: [[8, 'desc']],
      pageLength: 25,
    });
  });
</script>
@endsection

