@extends('layouts.master')

@section('title', 'Onboarding - Learning Goals')

@section('content')

<x-breadcrumb item="Onboarding" active="Learning Goals"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            @can('create', App\Models\LearningGoal::class)
            <div class="text-end mb-3">
              <a href="{{ route('onboarding.create') }}" class="btn btn-primary">Add Learning Goal</a>
            </div>
            @endcan
            <div class="card">
              <div class="card-header">
                <h5>Onboarding Learning Goals</h5>
              </div>
              <div class="card-body">
                @if($goals->count() > 0)
                  @foreach($goals as $goal)
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                          <h5 class="mb-2">{{ $goal->title }}</h5>
                          <p class="text-muted mb-2">{{ $goal->description }}</p>
                          <p class="mb-2">
                            <strong>Team:</strong> {{ $goal->team_id ? ($goal->team ? $goal->team->name : 'N/A') : 'All Teams' }}
                            @if($goal->resource_url)
                              | <a href="{{ $goal->resource_url }}" target="_blank" class="text-primary">Resource Link</a>
                            @endif
                          </p>
                          <div class="d-flex align-items-center">
                            @if(isset($userProgress[$goal->id]) && $userProgress[$goal->id])
                              <span class="badge bg-light-success me-2">Completed</span>
                            @else
                              <span class="badge bg-light-secondary me-2">In Progress</span>
                            @endif
                            @if((!isset($userProgress[$goal->id]) || !$userProgress[$goal->id]) && (Auth::user()->isEmployee() || Auth::user()->isIntern()))
                              <form action="{{ route('onboarding.mark-completed', $goal) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Mark as Completed</button>
                              </form>
                            @endif
                          </div>
                        </div>
                        @can('update', $goal)
                        <div class="d-flex gap-2">
                          <a href="{{ route('onboarding.edit', $goal) }}" class="btn btn-sm btn-primary">Edit</a>
                          @can('delete', $goal)
                          <form action="{{ route('onboarding.destroy', $goal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this learning goal?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                          </form>
                          @endcan
                        </div>
                        @endcan
                      </div>
                    </div>
                  </div>
                  @endforeach
                @else
                  <p class="text-muted">No learning goals available.</p>
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection

