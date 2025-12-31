@extends('layouts.master')

@section('title', 'Create Question')

@section('content')

<x-breadcrumb item="Q&A" active="Create Question"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Create Question</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('qa.store') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Question</label>
                        <textarea class="form-control @error('question') is-invalid @enderror" name="question" rows="3" required>{{ old('question') }}</textarea>
                        @error('question')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control @error('answer') is-invalid @enderror" name="answer" rows="5">{{ old('answer') }}</textarea>
                        @error('answer')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Team (Optional - Leave blank for global question)</label>
                        <select class="form-select @error('team_id') is-invalid @enderror" name="team_id">
                          <option value="">Global (All Teams)</option>
                          @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                          @endforeach
                        </select>
                        @error('team_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <a href="{{ route('qa.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Question</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection


