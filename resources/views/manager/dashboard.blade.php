@extends('layouts.master')

@section('title', 'Manager Dashboard')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/datepicker-bs5.min.css" />
@endsection

@section('content')

<x-breadcrumb item="Dashboard" active="Manager Dashboard"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- Team Members Count Card -->
          <div class="col-xl-4 col-md-6">
            <div class="card">
              <div class="card-body pb-0">
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="mb-0">Team members</h5>
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
                      <a class="dropdown-item" href="#">Today</a>
                      <a class="dropdown-item" href="#">Weekly</a>
                      <a class="dropdown-item" href="#">Monthly</a>
                    </div>
                  </div>
                </div>
                <div class="mt-3">
                  <h2 class="mb-0">{{ $totalEmployees }}</h2>
                  <p class="text-muted mb-0">Total Employees</p>
                  <small class="text-muted">Excluding yourself</small>
                </div>
              </div>
            </div>
          </div>
          <!-- Team Members Count Card End -->

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
          var membership_state_chart_option = {
            series: [{{ $internPercentage }}],
            chart: {
              type: 'radialBar',
              offsetY: -20,
              sparkline: {
                enabled: true
              }
            },
            colors: ['#4680ff'],
            plotOptions: {
              radialBar: {
                startAngle: -95,
                endAngle: 95,
                hollow: {
                  margin: 15,
                  size: '40%'
                },
                track: {
                  background: '#4680ff25',
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
        }, 500);
      });
    </script>
<!-- [Page Specific JS] end -->
@endsection


