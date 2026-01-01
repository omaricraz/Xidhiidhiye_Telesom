@extends('layouts.master')

@section('title', 'Employee Dashboard')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/datepicker-bs5.min.css" />
@endsection

@section('content')

<x-breadcrumb item="Dashboard" active="My Dashboard"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- Total Tasks Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Total Tasks</h5>
                  <i class="ti ti-checklist f-24 text-primary"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $totalTasks }}</h2>
                  <p class="text-muted mb-0">My Tasks</p>
                  <small class="text-muted">{{ $taskCompletionPercentage }}% Completed</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Total Tasks Card End -->

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
                  <small class="text-muted">{{ $productivityLevel['percentage'] }}% Completion Rate</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Productivity Level Card End -->

          <!-- Completed Tasks Card -->
          <div class="col-xl-3 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Completed</h5>
                  <i class="ti ti-check f-24 text-success"></i>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $completedTasks }}</h2>
                  <p class="text-muted mb-0">Tasks Done</p>
                  <small class="text-muted">Out of {{ $totalTasks }} total</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Completed Tasks Card End -->

          <!-- High Priority Tasks Card -->
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
                  <small class="text-muted">Requires attention</small>
                </div>
              </div>
            </div>
          </div>
          <!-- High Priority Tasks Card End -->

          <!-- Tasks Status Overview Card -->
          <div class="col-lg-8 col-md-12">
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
                        <h6 class="mb-0">{{ $overdueTasks }}</h6>
                        <small class="text-muted">Overdue</small>
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
                    <span class="text-muted">Assigned to Me</span>
                    <strong>{{ $assignedToMe }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">Created by Me</span>
                    <strong>{{ $createdByMe }}</strong>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted">Avg. Completion</span>
                    <strong>{{ $averageCompletionDays }} days</strong>
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

          <!-- Task Priority Distribution Card -->
          <div class="col-lg-6 col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <h5 class="mb-0">Task Priority Distribution</h5>
                </div>
                <div class="row">
                  <div class="col-4 mb-3">
                    <div class="text-center">
                      <div class="avtar avtar-lg bg-light-danger mx-auto mb-2">
                        <i class="ti ti-alert-triangle f-24 text-danger"></i>
                      </div>
                      <h4 class="mb-0">{{ $highPriorityCount }}</h4>
                      <small class="text-muted">High Priority</small>
                    </div>
                  </div>
                  <div class="col-4 mb-3">
                    <div class="text-center">
                      <div class="avtar avtar-lg bg-light-warning mx-auto mb-2">
                        <i class="ti ti-alert-circle f-24 text-warning"></i>
                      </div>
                      <h4 class="mb-0">{{ $mediumPriorityCount }}</h4>
                      <small class="text-muted">Medium Priority</small>
                    </div>
                  </div>
                  <div class="col-4 mb-3">
                    <div class="text-center">
                      <div class="avtar avtar-lg bg-light-info mx-auto mb-2">
                        <i class="ti ti-info-circle f-24 text-info"></i>
                      </div>
                      <h4 class="mb-0">{{ $lowPriorityCount }}</h4>
                      <small class="text-muted">Low Priority</small>
                    </div>
                  </div>
                </div>
                <div id="priority-chart"></div>
              </div>
            </div>
          </div>
          <!-- Task Priority Distribution Card End -->

          <!-- Recent Tasks Card -->
          <div class="col-lg-6 col-md-12">
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
          var chartColor = currentTheme === 'dark' ? '#9c27b0' : '#28a745';
          var trackColor = currentTheme === 'dark' ? '#9c27b025' : '#28a74525';
          
          // Productivity Chart
          var productivityChartOption = {
            series: [{{ $taskCompletionPercentage }}],
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
            labels: ['Productivity']
          };
          var productivityChart = new ApexCharts(document.querySelector('#productivity-chart'), productivityChartOption);
          productivityChart.render();
          
          // Priority Distribution Chart
          var priorityChartOption = {
            series: [{{ $highPriorityCount }}, {{ $mediumPriorityCount }}, {{ $lowPriorityCount }}],
            chart: {
              type: 'donut',
              height: 250
            },
            labels: ['High Priority', 'Medium Priority', 'Low Priority'],
            colors: ['#dc3545', '#ffc107', '#17a2b8'],
            legend: {
              position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%'
                }
              }
            },
            dataLabels: {
              enabled: true,
              formatter: function (val) {
                return val.toFixed(0) + '%';
              }
            }
          };
          var priorityChart = new ApexCharts(document.querySelector('#priority-chart'), priorityChartOption);
          priorityChart.render();
          
          // Watch for theme changes and update chart colors
          var observer = new MutationObserver(function(mutations) {
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
          
          // Start observing the body element for theme changes
          observer.observe(document.getElementsByTagName('body')[0], {
            attributes: true,
            attributeFilter: ['data-pc-theme']
          });
        }, 500);
      });
    </script>
<!-- [Page Specific JS] end -->
@endsection


