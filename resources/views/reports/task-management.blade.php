@extends('layouts.master')

@section('title', 'Task Management Report')

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

<x-breadcrumb item="Reports" active="Task Management"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <!-- Report Header with Action Buttons -->
            <div class="card mb-3">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Task Management Report</h5>
                <div class="d-print-none">
                  <button class="btn btn-sm btn-primary" onclick="window.print()">
                    <i class="ti ti-printer me-1"></i> Print
                  </button>
                  <button class="btn btn-sm btn-success" onclick="exportToPDF()">
                    <i class="ti ti-download me-1"></i> Download PDF
                  </button>
                  <button class="btn btn-sm btn-info" onclick="exportToExcel()">
                    <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
                  </button>
                </div>
              </div>
            </div>

            <!-- Filter Panel -->
            <div class="card mb-3 d-print-none">
              <div class="card-header">
                <button class="btn btn-link text-decoration-none p-0 w-100 text-start" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel" aria-expanded="true" aria-controls="filterPanel">
                  <i class="ti ti-filter me-2"></i> Filter Options
                  <i class="ti ti-chevron-down float-end"></i>
                </button>
              </div>
              <div class="collapse show" id="filterPanel">
                <div class="card-body">
                  <form method="GET" action="{{ route('reports.tasks') }}" class="row g-3">
                    <div class="col-md-3">
                      <label class="form-label">Date From</label>
                      <input type="date" class="form-control" name="date_from" value="{{ $filters['date_from'] }}">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Date To</label>
                      <input type="date" class="form-control" name="date_to" value="{{ $filters['date_to'] }}">
                    </div>
                    @if(Auth::user()->isManager())
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                      <label class="form-label">Status</label>
                      <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="Pending" {{ $filters['status'] == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="In_Progress" {{ $filters['status'] == 'In_Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Completed" {{ $filters['status'] == 'Completed' ? 'selected' : '' }}>Completed</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Priority</label>
                      <select class="form-select" name="priority">
                        <option value="">All Priority</option>
                        <option value="High" {{ $filters['priority'] == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Medium" {{ $filters['priority'] == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="Normal" {{ $filters['priority'] == 'Normal' ? 'selected' : '' }}>Normal</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i> Apply Filters
                      </button>
                      <a href="{{ route('reports.tasks') }}" class="btn btn-outline-secondary">
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
                      <h5 class="mb-0">Total Tasks</h5>
                      <i class="ti ti-checklist f-24 text-primary"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $totalTasks }}</h2>
                      <p class="text-muted mb-0">All Tasks</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Completed</h5>
                      <i class="ti ti-check f-24 text-success"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $completedTasks }}</h2>
                      <p class="text-muted mb-0">{{ $completionPercentage }}% Completion</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">In Progress</h5>
                      <i class="ti ti-loader f-24 text-primary"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $inProgressTasks }}</h2>
                      <p class="text-muted mb-0">Active Tasks</p>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">High Priority</h5>
                      <i class="ti ti-alert-triangle f-24 text-danger"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0">{{ $highPriorityTasks }}</h2>
                      <p class="text-muted mb-0">Urgent Tasks</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts Section -->
            <div class="row mb-3">
              <!-- Status Distribution Chart -->
              <div class="col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Task Status Distribution</h5>
                  </div>
                  <div class="card-body">
                    <div id="status-chart"></div>
                  </div>
                </div>
              </div>
              
              <!-- Priority Distribution Chart -->
              <div class="col-lg-6 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Priority Distribution</h5>
                  </div>
                  <div class="card-body">
                    <div id="priority-chart"></div>
                  </div>
                </div>
              </div>
            </div>

            @if(Auth::user()->isManager() && !empty($tasksByTeam))
            <!-- Tasks by Team Chart -->
            <div class="row mb-3">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Tasks by Team</h5>
                  </div>
                  <div class="card-body">
                    <div id="team-chart"></div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            <!-- Detailed Task List -->
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detailed Task List</h5>
                <div class="d-print-none">
                  <span class="text-muted">Total: {{ $totalTasks }} tasks</span>
                </div>
              </div>
              <div class="card-body">
                @if($tasks->count() > 0)
                <div class="table-responsive">
                  <table class="table table-hover" id="tasks-table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Creator</th>
                        <th>Assignee</th>
                        <th>Created</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($tasks as $task)
                      <tr>
                        <td>{{ $task->id }}</td>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                              <h6 class="mb-0">{{ Str::limit($task->title, 40) }}</h6>
                              @if($task->description)
                              <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                              @endif
                            </div>
                          </div>
                        </td>
                        <td>
                          @if($task->status === 'Completed')
                          <span class="badge bg-success">{{ str_replace('_', ' ', $task->status) }}</span>
                          @elseif($task->status === 'In_Progress')
                          <span class="badge bg-primary">{{ str_replace('_', ' ', $task->status) }}</span>
                          @else
                          <span class="badge bg-warning">{{ str_replace('_', ' ', $task->status) }}</span>
                          @endif
                        </td>
                        <td>
                          @if($task->priority === 'High')
                          <span class="badge bg-danger">{{ $task->priority }}</span>
                          @elseif($task->priority === 'Medium')
                          <span class="badge bg-warning">{{ $task->priority }}</span>
                          @else
                          <span class="badge bg-secondary">{{ $task->priority }}</span>
                          @endif
                        </td>
                        <td>{{ $task->creator->name ?? 'N/A' }}</td>
                        <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                        <td>
                          <small class="text-muted">{{ $task->created_at->format('M d, Y') }}</small>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <div class="text-center py-5">
                  <i class="ti ti-inbox f-48 text-muted mb-3"></i>
                  <p class="text-muted">No tasks found for the selected filters.</p>
                  <a href="{{ route('reports.tasks') }}" class="btn btn-primary">
                    <i class="ti ti-refresh me-1"></i> Reset Filters
                  </a>
                </div>
                @endif
              </div>
            </div>

            <!-- Report Footer (Print Only) -->
            <div class="d-none d-print-block mt-4">
              <div class="text-center text-muted">
                <p class="mb-0">Report generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
                <p class="mb-0">Xidhiidhiye - Task Management Report</p>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
<!-- [Page Specific JS] start -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/build/js/plugins/dataTables.min.js"></script>
<script src="/build/js/plugins/dataTables.bootstrap5.min.js"></script>
<script src="/build/js/plugins/dataTables.responsive.min.js"></script>
<script src="/build/js/plugins/responsive.bootstrap5.min.js"></script>
<script src="/build/js/plugins/apexcharts.min.js"></script>
<script>
  // Initialize DataTable
  $(document).ready(function() {
    $('#tasks-table').DataTable({
      responsive: true,
      order: [[0, 'desc']],
      pageLength: 25,
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
    });
  });

  // Detect theme for charts
  function getCurrentTheme() {
    return document.body.getAttribute('data-pc-theme') || 'light';
  }

  // Chart colors based on theme
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

  // Status Distribution Chart
  function renderStatusChart() {
    const colors = getChartColors();
    const statusData = @json($statusDistribution);
    
    const options = {
      series: [statusData['Completed'], statusData['In Progress'], statusData['Pending']],
      chart: {
        type: 'donut',
        height: 350,
      },
      labels: ['Completed', 'In Progress', 'Pending'],
      colors: [colors.success, colors.info, colors.warning],
      legend: {
        position: 'bottom',
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val.toFixed(1) + '%';
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: true,
              name: {
                show: true,
              },
              value: {
                show: true,
                formatter: function(val) {
                  return val;
                }
              },
              total: {
                show: true,
                label: 'Total Tasks',
                formatter: function() {
                  return {{ $totalTasks }};
                }
              }
            }
          }
        }
      }
    };
    
    const chart = new ApexCharts(document.querySelector('#status-chart'), options);
    chart.render();
  }

  // Priority Distribution Chart
  function renderPriorityChart() {
    const colors = getChartColors();
    const priorityData = @json($priorityDistribution);
    
    const options = {
      series: [{
        name: 'Tasks',
        data: [priorityData['High'], priorityData['Medium'], priorityData['Normal']]
      }],
      chart: {
        type: 'bar',
        height: 350,
      },
      colors: [colors.danger, colors.warning, colors.info],
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '55%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: true
      },
      xaxis: {
        categories: ['High', 'Medium', 'Normal'],
      },
      yaxis: {
        title: {
          text: 'Number of Tasks'
        }
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val + " tasks";
          }
        }
      }
    };
    
    const chart = new ApexCharts(document.querySelector('#priority-chart'), options);
    chart.render();
  }

  @if(Auth::user()->isManager() && !empty($tasksByTeam))
  // Tasks by Team Chart
  function renderTeamChart() {
    const colors = getChartColors();
    const teamData = @json($tasksByTeam);
    const teams = Object.keys(teamData);
    const values = Object.values(teamData);
    
    const options = {
      series: [{
        name: 'Tasks',
        data: values
      }],
      chart: {
        type: 'bar',
        height: 350,
        horizontal: true,
      },
      colors: [colors.primary],
      plotOptions: {
        bar: {
          horizontal: true,
          dataLabels: {
            position: 'top',
          },
        }
      },
      dataLabels: {
        enabled: true,
      },
      xaxis: {
        categories: teams,
        title: {
          text: 'Number of Tasks'
        }
      },
      yaxis: {
        title: {
          text: 'Teams'
        }
      },
    };
    
    const chart = new ApexCharts(document.querySelector('#team-chart'), options);
    chart.render();
  }
  @endif

  // Initialize all charts
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      renderStatusChart();
      renderPriorityChart();
      @if(Auth::user()->isManager() && !empty($tasksByTeam))
      renderTeamChart();
      @endif
    }, 500);
  });

  // Export functions
  function exportToPDF() {
    alert('PDF export functionality will be implemented. For now, please use the Print function and save as PDF.');
  }

  function exportToExcel() {
    alert('Excel export functionality will be implemented. For now, please use the table export options.');
  }

  // Collapse filter panel icon toggle
  document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.querySelector('[data-bs-target="#filterPanel"]');
    const filterIcon = filterButton.querySelector('.ti-chevron-down');
    const filterPanel = document.getElementById('filterPanel');
    
    filterPanel.addEventListener('shown.bs.collapse', function() {
      filterIcon.classList.remove('ti-chevron-up');
      filterIcon.classList.add('ti-chevron-down');
    });
    
    filterPanel.addEventListener('hidden.bs.collapse', function() {
      filterIcon.classList.remove('ti-chevron-down');
      filterIcon.classList.add('ti-chevron-up');
    });
  });
</script>
<!-- [Page Specific JS] end -->
@endsection

