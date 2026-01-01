@extends('layouts.master')

@section('title', 'Reports')

@section('content')

<x-breadcrumb item="Reports" active="Dashboard"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Reports Dashboard</h5>
              </div>
              <div class="card-body">
                <p class="text-muted mb-4">Select a report category to view detailed analytics and insights.</p>
                
                <!-- Report Categories Grid -->
                <div class="row g-3">
                  <!-- Task Management Reports -->
                  <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <h5 class="mb-0">Task Management</h5>
                          <i class="ti ti-clipboard-list f-24 text-primary"></i>
                        </div>
                        <p class="text-muted mb-3">View comprehensive task analytics</p>
                        <a href="{{ route('reports.tasks') }}" class="btn btn-primary btn-sm w-100">
                          <i class="ti ti-arrow-right me-1"></i> View Report
                        </a>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Learning Progress Reports -->
                  <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <h5 class="mb-0">Learning Progress</h5>
                          <i class="ti ti-school f-24 text-info"></i>
                        </div>
                        <p class="text-muted mb-3">Monitor learning goal completion</p>
                        <a href="{{ route('reports.learning') }}" class="btn btn-info btn-sm w-100">
                          <i class="ti ti-arrow-right me-1"></i> View Report
                        </a>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Team Performance Reports -->
                  <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <h5 class="mb-0">Team Performance</h5>
                          <i class="ti ti-building f-24 text-warning"></i>
                        </div>
                        <p class="text-muted mb-3">Analyze team productivity and individual member activity</p>
                        <a href="{{ route('reports.teams') }}" class="btn btn-warning btn-sm w-100">
                          <i class="ti ti-arrow-right me-1"></i> View Report
                        </a>
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
