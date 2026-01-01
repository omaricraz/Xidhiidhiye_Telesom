@extends('layouts.master')

@section('title', 'User Details')

@section('content')

<x-breadcrumb item="User Management" active="User Details"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>User Details</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Full Name:</strong> {{ $user->full_name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> <span class="badge bg-light-{{ $user->role === 'Manager' ? 'danger' : ($user->role === 'Team_Lead' ? 'warning' : 'primary') }}">{{ $user->role }}</span></p>
                    <p><strong>Team:</strong> {{ $user->team->name ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-6">
                    <p><strong>Status Emoji:</strong> {{ $user->status_emoji ?? 'N/A' }}</p>
                    <p><strong>Tech Stack:</strong>
                      @if($user->tech_stack)
                        @foreach(explode(',', $user->tech_stack) as $tech)
                          <span class="badge bg-light-secondary me-1">{{ trim($tech) }}</span>
                        @endforeach
                      @else
                        N/A
                      @endif
                    </p>
                  </div>
                </div>
                <div class="text-end mt-3">
                  <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
                  <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection




