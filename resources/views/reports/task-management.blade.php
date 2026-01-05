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
                  <a href="{{ route('reports.tasks.pdf', $filters) }}" class="btn btn-sm btn-success">
                    <i class="ti ti-download me-1"></i> Download PDF
                  </a>
                  <a href="{{ route('reports.tasks.export', $filters) }}" class="btn btn-sm btn-info">
                    <i class="ti ti-file-spreadsheet me-1"></i> Export Excel
                  </a>
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
                    @if(Auth::user()->isManager() || (Auth::user()->isTeamLead() && Auth::user()->team_id))
                    <div class="col-md-2">
                      <label class="form-label">Employee</label>
                      <select class="form-select" name="employee_id">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                          <option value="{{ $employee->id }}" {{ $filters['employee_id'] == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }} @if($employee->team)({{ $employee->team->name }})@endif
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
              
              <!-- Productivity Level Card -->
              <div class="col-xl-3 col-md-6">
                <div class="card">
                  <div class="card-body pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="mb-0">Productivity</h5>
                      <i class="ti {{ $productivityLevel['icon'] }} f-24 text-{{ $productivityLevel['color'] }}"></i>
                    </div>
                    <div class="mt-3">
                      <h2 class="mb-0 text-{{ $productivityLevel['color'] }}">{{ $productivityLevel['label'] }}</h2>
                      <p class="text-muted mb-0">Performance Level</p>
                      <small class="text-muted">{{ $productivityLevel['percentage'] }}% Completion</small>
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
              
              <!-- Productivity Trend Chart -->
              <div class="col-lg-12 col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="mb-0">Productivity Trend</h5>
                  </div>
                  <div class="card-body">
                    <div id="productivity-trend-chart"></div>
                  </div>
                </div>
              </div>
            </div>

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

  // Productivity Trend Chart
  function renderProductivityTrendChart() {
    const colors = getChartColors();
    const trendData = @json($productivityTrend);
    const theme = getCurrentTheme();
    
    const dates = trendData.map(item => item.date);
    const percentages = trendData.map(item => item.percentage);
    
    // Determine gradient colors based on theme
    const gradientFrom = theme === 'dark' ? '#4ade80' : '#28a745';
    const gradientTo = theme === 'dark' ? '#22c55e' : '#20c997';
    
    const options = {
      series: [{
        name: 'Productivity',
        data: percentages
      }],
      chart: {
        type: 'area',
        height: 380,
        zoom: {
          enabled: false
        },
        toolbar: {
          show: false
        },
        sparkline: {
          enabled: false
        },
        animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
            enabled: true,
            delay: 150
          },
          dynamicAnimation: {
            enabled: true,
            speed: 350
          }
        }
      },
      colors: [gradientFrom],
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.3,
          stops: [0, 50, 100],
          colorStops: [
            {
              offset: 0,
              color: gradientFrom,
              opacity: 0.8
            },
            {
              offset: 50,
              color: gradientTo,
              opacity: 0.5
            },
            {
              offset: 100,
              color: gradientTo,
              opacity: 0.1
            }
          ]
        }
      },
      stroke: {
        curve: 'smooth',
        width: 3,
        lineCap: 'round'
      },
      markers: {
        size: 6,
        strokeWidth: 2,
        strokeColors: [gradientFrom],
        fillColors: ['#ffffff'],
        hover: {
          size: 8,
          sizeOffset: 2
        }
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: dates,
        title: {
          text: 'Date',
          style: {
            fontSize: '12px',
            fontWeight: 600,
            color: theme === 'dark' ? '#e0e0e0' : '#666'
          }
        },
        labels: {
          style: {
            colors: theme === 'dark' ? '#b0b0b0' : '#666',
            fontSize: '11px'
          },
          rotate: -45,
          rotateAlways: false
        },
        axisBorder: {
          show: true,
          color: theme === 'dark' ? '#374151' : '#e5e7eb'
        },
        axisTicks: {
          show: true,
          color: theme === 'dark' ? '#374151' : '#e5e7eb'
        }
      },
      yaxis: {
        title: {
          text: 'Completion Percentage (%)',
          style: {
            fontSize: '12px',
            fontWeight: 600,
            color: theme === 'dark' ? '#e0e0e0' : '#666'
          }
        },
        min: 0,
        max: 100,
        labels: {
          style: {
            colors: theme === 'dark' ? '#b0b0b0' : '#666',
            fontSize: '11px'
          },
          formatter: function(val) {
            return val + '%';
          }
        }
      },
      grid: {
        borderColor: theme === 'dark' ? '#374151' : '#e5e7eb',
        strokeDashArray: 4,
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        },
        row: {
          colors: [theme === 'dark' ? '#1f2937' : '#f9fafb', 'transparent'],
          opacity: 0.5
        },
        column: {
          colors: [theme === 'dark' ? '#1f2937' : '#f9fafb', 'transparent'],
          opacity: 0.5
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        }
      },
      tooltip: {
        theme: theme,
        style: {
          fontSize: '12px'
        },
        y: {
          formatter: function(val) {
            return val + "%";
          },
          title: {
            formatter: function() {
              return 'Productivity: ';
            }
          }
        },
        marker: {
          show: true
        },
        fixed: {
          enabled: false
        },
        followCursor: true
      },
      annotations: {
        yaxis: [
          {
            y: 90,
            borderColor: theme === 'dark' ? '#4ade80' : '#28a745',
            borderWidth: 2,
            borderDashArray: 5,
            label: {
              text: 'Excellent (90%)',
              style: {
                color: theme === 'dark' ? '#4ade80' : '#28a745',
                fontSize: '10px',
                fontWeight: 600,
                background: 'transparent'
              },
              position: 'right'
            }
          },
          {
            y: 75,
            borderColor: theme === 'dark' ? '#60a5fa' : '#17a2b8',
            borderWidth: 1,
            borderDashArray: 3,
            label: {
              text: 'Very Good (75%)',
              style: {
                color: theme === 'dark' ? '#60a5fa' : '#17a2b8',
                fontSize: '10px',
                fontWeight: 500,
                background: 'transparent'
              },
              position: 'right'
            }
          },
          {
            y: 60,
            borderColor: theme === 'dark' ? '#9BB5FF' : '#007bff',
            borderWidth: 1,
            borderDashArray: 3,
            label: {
              text: 'Good (60%)',
              style: {
                color: theme === 'dark' ? '#9BB5FF' : '#007bff',
                fontSize: '10px',
                fontWeight: 500,
                background: 'transparent'
              },
              position: 'right'
            }
          },
          {
            y: 40,
            borderColor: theme === 'dark' ? '#fbbf24' : '#ffc107',
            borderWidth: 1,
            borderDashArray: 3,
            label: {
              text: 'Average (40%)',
              style: {
                color: theme === 'dark' ? '#fbbf24' : '#ffc107',
                fontSize: '10px',
                fontWeight: 500,
                background: 'transparent'
              },
              position: 'right'
            }
          }
        ]
      },
      legend: {
        show: false
      }
    };
    
    const chart = new ApexCharts(document.querySelector('#productivity-trend-chart'), options);
    chart.render();
  }

  // Initialize all charts
  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
      renderStatusChart();
      renderPriorityChart();
      renderProductivityTrendChart();
    }, 500);
  });

  // Export functions

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

