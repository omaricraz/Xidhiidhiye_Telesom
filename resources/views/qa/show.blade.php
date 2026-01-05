@extends('layouts.master')

@section('title', 'View Question')

@section('content')

<x-breadcrumb item="Q&A" active="View Question"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Question Details</h5>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <h6>Question:</h6>
                  <p>{{ $question->question }}</p>
                </div>
                <div class="mb-3">
                  <h6>Answer:</h6>
                  <p>{!! nl2br(e($question->answer ?? 'No answer provided yet.')) !!}</p>
                </div>
                <div class="mb-3">
                  <h6>Team:</h6>
                  <p>
                    @if($question->team)
                      <span class="badge bg-light-info">{{ $question->team->name }}</span>
                    @else
                      <span class="badge bg-light-secondary">Global (All Teams)</span>
                    @endif
                  </p>
                </div>
                <div class="mb-3">
                  <h6>Created By:</h6>
                  <p>{{ $question->creator->name }}</p>
                </div>
                <div class="mb-3">
                  <h6>Created At:</h6>
                  <p>{{ $question->created_at->format('F d, Y h:i A') }}</p>
                </div>
                <div class="text-end">
                  @can('update', $question)
                  <a href="{{ route('qa.edit', $question) }}" class="btn btn-primary">Edit</a>
                  @endcan
                  @can('delete', $question)
                  <form action="{{ route('qa.destroy', $question) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this question?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>
                  @endcan
                  <a href="{{ route('qa.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection








