@extends('layouts.master')

@section('title', 'User Management')

@section('css')
<link rel="stylesheet" href="/build/css/plugins/style.css" />
@endsection

@section('content')

<x-breadcrumb item="User Management" active="Users"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card table-card">
              <div class="card-header">
                <div class="d-sm-flex align-items-center justify-content-between">
                  <h5 class="mb-3 mb-sm-0">User List</h5>
                  <div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
                  </div>
                </div>
              </div>
              <div class="card-body pt-3">
                <div class="table-responsive">
                  <table class="table table-hover" id="pc-dt-simple">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Team</th>
                        <th>Tech Stack</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                              @if($user->profile_image)
                                <img src="{{ $user->profile_image }}" alt="{{ $user->full_name ?? $user->name }}" class="avtar avtar-xs rounded-circle" style="object-fit: cover;" />
                              @else
                                <span class="avtar avtar-xs rounded-circle bg-light-primary">
                                  {{ $user->status_emoji ?? '👤' }}
                                </span>
                              @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                              <h6 class="mb-0">{{ $user->full_name ?? $user->name }}</h6>
                            </div>
                          </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-light-{{ $user->role === 'Manager' ? 'danger' : ($user->role === 'Team_Lead' ? 'warning' : 'primary') }}">{{ $user->role }}</span></td>
                        <td>{{ $user->team->name ?? 'N/A' }}</td>
                        <td>
                          @if($user->tech_stack)
                            @foreach(explode(',', $user->tech_stack) as $tech)
                              <span class="badge bg-light-secondary me-1">{{ trim($tech) }}</span>
                            @endforeach
                          @else
                            N/A
                          @endif
                        </td>
                        <td><span class="badge bg-light-success">Active</span></td>
                        <td>
                          <a href="{{ route('admin.users.show', $user) }}" class="avtar avtar-xs btn-link-secondary">
                            <i class="ti ti-eye f-20"></i>
                          </a>
                          <a href="{{ route('admin.users.edit', $user) }}" class="avtar avtar-xs btn-link-success">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="avtar avtar-xs btn-link-danger border-0 bg-transparent p-0">
                              <i class="ti ti-trash f-20"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection
@section('scripts')
    <script type="module">
      import { DataTable } from '/build/js/plugins/module.js';
      window.dt = new DataTable('#pc-dt-simple');
    </script>
@endsection

