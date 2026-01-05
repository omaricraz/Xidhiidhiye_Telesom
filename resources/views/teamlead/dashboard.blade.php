@extends('layouts.master')

@section('title', 'Team Lead Dashboard')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/datepicker-bs5.min.css" />
@endsection

@section('content')

<x-breadcrumb item="Dashboard" active="Team Lead Dashboard"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- Team Members Count Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Team members</h5>
                  <i class="ti ti-users f-24 text-primary"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $totalEmployees }}</h2>
                  <p class="text-muted mb-0">Team Members</p>
                  <small class="text-muted">Excluding yourself</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Team Members Count Card End -->

          <!-- Tasks Count Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Total Tasks</h5>
                  <i class="ti ti-checklist f-24 text-success"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $totalTasks }}</h2>
                  <p class="text-muted mb-0">Team Tasks</p>
                  <small class="text-muted">{{ $taskCompletionPercentage }}% Completed</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Tasks Count Card End -->

          <!-- Team Name Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Team</h5>
                  <i class="ti ti-building f-24 text-info"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $team->name }}</h2>
                  <p class="text-muted mb-0">Your Team</p>
                  <small class="text-muted">Team Lead Dashboard</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Team Name Card End -->

          <!-- Active Employees Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Active Employees</h5>
                  <i class="ti ti-user-check f-24 text-warning"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $activeEmployees }}</h2>
                  <p class="text-muted mb-0">Currently Active</p>
                  <small class="text-muted">Out of {{ $totalEmployees }} total</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Active Employees Card End -->

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
                  <p class="text-muted mb-0">Team Performance</p>
                  <small class="text-muted">{{ $productivityLevel['percentage'] }}% Completion Rate</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Productivity Level Card End -->

          <!-- Tasks Status Overview Card -->
          <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <h5 class="mb-0">Tasks Status Overview</h5>
                  <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="row">
                  <div class="col-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="avtar avtar-s bg-light-success me-2">
                        <i class="ti ti-check f-18 text-success"></i>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $completedTasks }}</h6>
                        <small class="text-muted">Completed</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="avtar avtar-s bg-light-primary me-2">
                        <i class="ti ti-loader f-18 text-primary"></i>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $inProgressTasks }}</h6>
                        <small class="text-muted">In Progress</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="avtar avtar-s bg-light-warning me-2">
                        <i class="ti ti-clock f-18 text-warning"></i>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $pendingTasks }}</h6>
                        <small class="text-muted">Pending</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 mb-3">
                    <div class="d-flex align-items-center">
                      <div class="avtar avtar-s bg-light-danger me-2">
                        <i class="ti ti-alert-triangle f-18 text-danger"></i>
                      </div>
                      <div>
                        <h6 class="mb-0">{{ $highPriorityTasks }}</h6>
                        <small class="text-muted">High Priority</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mt-3">
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $taskCompletionPercentage }}%" aria-valuenow="{{ $taskCompletionPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <small class="text-muted d-block mt-2">Overall Completion: {{ $taskCompletionPercentage }}%</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Tasks Status Overview Card End -->

          <!-- Productivity Metrics Card -->
          <div class="col-lg-4 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <h5 class="mb-0">Productivity Metrics</h5>
                </div>
                <div class="mb-3">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">Total Tasks</span>
                    <strong>{{ $totalTasks }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">Completed</span>
                    <strong>{{ $completedTasks }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">In Progress</span>
                    <strong>{{ $inProgressTasks }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">Pending</span>
                    <strong>{{ $pendingTasks }}</strong>
                  </div>
                  <hr>
                  <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Productivity Level</span>
                    <span class="badge bg-{{ $productivityLevel['color'] }}">{{ $productivityLevel['label'] }}</span>
                  </div>
                </div>
                <div id="productivity-chart"></div>
              </div>
            </div>
          </div>
          <!-- Productivity Metrics Card End -->

          <!-- Membership State Card -->
          <div class="col-lg-8 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <h5 class="mb-0">Membership State</h5>
                  <select class="form-select rounded-3 form-select-sm w-auto">
                    <option>Today</option>
                    <option>Weekly</option>
                    <option selected>Monthly</option>
                  </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div id="membership-state-chart"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="rounded border p-3 mb-2">
                      <span class="d-block"><i class="fas fa-circle text-primary f-10 m-r-10"></i>Interns ({{ $internPercentage }}%)</span>
                      <small class="text-muted d-block mt-1">{{ $internsCount }} employees</small>
                    </div>
                    <div class="rounded border p-3">
                      <span class="d-block"><i class="fas fa-circle text-primary text-opacity-25 f-10 m-r-10"></i>Permanent Employees ({{ $permanentPercentage }}%)</span>
                      <small class="text-muted d-block mt-1">{{ $permanentCount }} employees</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Membership State Card End -->

          <!-- Recent Tasks Card -->
          <div class="col-lg-12 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <h5 class="mb-0">Recent Tasks</h5>
                  <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-link">View All Tasks</a>
                </div>
                @if($recentTasks->count() > 0)
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Task</th>
                        <th>Assignee</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($recentTasks as $task)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                              <h6 class="mb-0">{{ Str::limit($task->title, 40) }}</h6>
                              <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                            </div>
                          </div>
                        </td>
                        <td>
                          @if($task->assignee)
                          <div class="d-flex align-items-center">
                            <div class="avtar avtar-xs me-2">
                              <img src="{{ $task->assignee->profile_image ? asset('storage/' . $task->assignee->profile_image) : asset('build/images/user/avatar-1.jpg') }}" alt="{{ $task->assignee->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                            </div>
                            <span>{{ $task->assignee->name }}</span>
                          </div>
                          @else
                          <span class="text-muted">Unassigned</span>
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
                          <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                <p class="text-muted mb-0">No tasks found</p>
                @endif
              </div>
            </div>
          </div>
          <!-- Recent Tasks Card End -->
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
<!-- [Page Specific JS] start -->
    <!-- bootstrap-datepicker -->
    <script src="/build/js/plugins/datepicker-full.min.js"></script>
    <script src="/build/js/plugins/apexcharts.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
          // Detect theme from body attribute
          var currentTheme = document.getElementsByTagName('body')[0].getAttribute('data-pc-theme') || 'light';
          var chartColor = currentTheme === 'dark' ? '#9c27b0' : '#28a745'; // Purple for dark, green for light
          var trackColor = currentTheme === 'dark' ? '#9c27b025' : '#28a74525'; // Purple for dark, green for light
          
          var membership_state_chart_option = {
            series: [{{ $internPercentage }}],
            chart: {
              type: 'radialBar',
              offsetY: -20,
              sparkline: {
                enabled: true
              }
            },
            colors: [chartColor],
            plotOptions: {
              radialBar: {
                startAngle: -95,
                endAngle: 95,
                hollow: {
                  margin: 15,
                  size: '40%'
                },
                track: {
                  background: trackColor,
                  strokeWidth: '97%',
                  margin: 10
                },
                dataLabels: {
                  name: {
                    show: false
                  },
                  value: {
                    offsetY: 0,
                    fontSize: '20px',
                    formatter: function(val) {
                      return val + '%';
                    }
                  }
                }
              }
            },
            grid: {
              padding: {
                top: 10
              }
            },
            stroke: {
              lineCap: 'round'
            },
            labels: ['Interns']
          };
          var chart = new ApexCharts(document.querySelector('#membership-state-chart'), membership_state_chart_option);
          chart.render();
          
          // Watch for theme changes and update chart colors
          var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
              if (mutation.type === 'attributes' && mutation.attributeName === 'data-pc-theme') {
                var newTheme = document.getElementsByTagName('body')[0].getAttribute('data-pc-theme') || 'light';
                var newChartColor = newTheme === 'dark' ? '#9c27b0' : '#28a745';
                var newTrackColor = newTheme === 'dark' ? '#9c27b025' : '#28a74525';
                
                chart.updateOptions({
                  colors: [newChartColor],
                  plotOptions: {
                    radialBar: {
                      track: {
                        background: newTrackColor
                      }
                    }
                  }
                });
              }
            });
          });
          
          // Start observing the body element for theme changes
          observer.observe(document.getElementsByTagName('body')[0], {
            attributes: true,
            attributeFilter: ['data-pc-theme']
          });
          
          // Productivity Chart
          var productivityChartOption = {
            series: [{{ $taskCompletionPercentage }}],
            chart: {
              type: 'radialBar',
              height: 200,
              sparkline: {
                enabled: true
              }
            },
            colors: [chartColor],
            plotOptions: {
              radialBar: {
                startAngle: -90,
                endAngle: 90,
                hollow: {
                  margin: 0,
                  size: '70%'
                },
                track: {
                  background: trackColor,
                  strokeWidth: '97%',
                  margin: 5
                },
                dataLabels: {
                  name: {
                    show: false
                  },
                  value: {
                    offsetY: -10,
                    fontSize: '16px',
                    fontWeight: 600,
                    formatter: function(val) {
                      return val + '%';
                    }
                  }
                }
              }
            },
            grid: {
              padding: {
                top: -10
              }
            },
            stroke: {
              lineCap: 'round'
            },
            labels: ['Productivity']
          };
          var productivityChart = new ApexCharts(document.querySelector('#productivity-chart'), productivityChartOption);
          productivityChart.render();
          
          // Watch for theme changes and update productivity chart colors
          var productivityObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
              if (mutation.type === 'attributes' && mutation.attributeName === 'data-pc-theme') {
                var newTheme = document.getElementsByTagName('body')[0].getAttribute('data-pc-theme') || 'light';
                var newChartColor = newTheme === 'dark' ? '#9c27b0' : '#28a745';
                var newTrackColor = newTheme === 'dark' ? '#9c27b025' : '#28a74525';
                
                productivityChart.updateOptions({
                  colors: [newChartColor],
                  plotOptions: {
                    radialBar: {
                      track: {
                        background: newTrackColor
                      }
                    }
                  }
                });
              }
            });
          });
          
          productivityObserver.observe(document.getElementsByTagName('body')[0], {
            attributes: true,
            attributeFilter: ['data-pc-theme']
          });
        }, 500);
      });
    </script>
<!-- [Page Specific JS] end -->
@endsection


