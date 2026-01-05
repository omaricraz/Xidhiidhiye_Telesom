@extends('layouts.master')

@section('title', 'Create Notice')

@section('content')

<x-breadcrumb item="Noticeboard" active="Create"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5>Create New Notice</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('noticeboard.store') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" rows="6" required>{{ old('content') }}</textarea>
                        @error('content')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <a href="{{ route('noticeboard.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Notice</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection








