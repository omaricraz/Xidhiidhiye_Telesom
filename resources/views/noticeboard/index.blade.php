@extends('layouts.master')

@section('title', 'Noticeboard')

@section('content')

<x-breadcrumb item="Noticeboard" active="Announcements"/>

        <!-- [ Main Content ] start -->
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Noticeboard</h5>
                @can('create', App\Models\Notice::class)
                  <a href="{{ route('noticeboard.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus"></i> Create Notice
                  </a>
                @endcan
              </div>
              <div class="card-body">
                @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @if($notices->count() > 0)
                  <div class="px-0 py-2">
                    <ul class="list-group list-group-flush">
                      @foreach($notices as $notice)
                      <li class="list-group-item">
                        <div class="d-flex align-items-center">
                          <div class="flex-shrink-0">
                            <div class="avtar bg-light-primary">
                              <i class="ti ti-bell f-20"></i>
                            </div>
                          </div>
                          <div class="flex-grow-1 mx-3">
                            <h6 class="mb-1">{{ $notice->title }}</h6>
                            <small class="text-muted">
                              <i class="ti ti-user"></i> {{ $notice->creator->name ?? 'Unknown' }} 
                              <span class="mx-2">|</span>
                              <i class="ti ti-clock"></i> {{ $notice->created_at->format('M d, Y h:i A') }}
                            </small>
                          </div>
                          <div class="flex-shrink-0">
                            <button 
                              class="avtar avtar-s btn-link-secondary" 
                              type="button" 
                              data-bs-toggle="collapse" 
                              data-bs-target="#noticeDetails{{ $notice->id }}" 
                              aria-expanded="true" 
                              aria-controls="noticeDetails{{ $notice->id }}"
                            >
                              <i class="ti ti-chevron-up f-20"></i>
                            </button>
                          </div>
                        </div>
                        <div class="collapse show mt-3" id="noticeDetails{{ $notice->id }}">
                          <div class="card card-body border-0 bg-light">
                            <p class="mb-3">{{ $notice->content }}</p>
                            @canany(['update', 'delete'], $notice)
                              <div class="d-flex gap-2">
                                @can('update', $notice)
                                  <a href="{{ route('noticeboard.edit', $notice) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-edit"></i> Edit
                                  </a>
                                @endcan
                                @can('delete', $notice)
                                  <form action="{{ route('noticeboard.destroy', $notice) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                      <i class="ti ti-trash"></i> Delete
                                    </button>
                                  </form>
                                @endcan
                              </div>
                            @endcanany
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                      {{ $notices->links() }}
                    </div>
                  </div>
                @else
                  <div class="text-center py-5">
                    <p class="text-muted">No announcements at this time.</p>
                    @can('create', App\Models\Notice::class)
                      <a href="{{ route('noticeboard.create') }}" class="btn btn-primary mt-2">
                        <i class="ti ti-plus"></i> Create First Notice
                      </a>
                    @endcan
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- [ Main Content ] end -->
@endsection

@section('scripts')
<script>
  // Rotate chevron icon when collapse is toggled
  document.addEventListener('DOMContentLoaded', function() {
    const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
    collapseElements.forEach(function(element) {
      const icon = element.querySelector('i');
      const targetId = element.getAttribute('data-bs-target');
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        // Set initial icon state based on whether collapse is shown
        if (targetElement.classList.contains('show')) {
          if (icon) {
            icon.classList.remove('ti-chevron-down');
            icon.classList.add('ti-chevron-up');
          }
        }
        
        // Handle collapse show event
        targetElement.addEventListener('shown.bs.collapse', function() {
          if (icon) {
            icon.classList.remove('ti-chevron-down');
            icon.classList.add('ti-chevron-up');
          }
          element.setAttribute('aria-expanded', 'true');
        });
        
        // Handle collapse hide event
        targetElement.addEventListener('hidden.bs.collapse', function() {
          if (icon) {
            icon.classList.remove('ti-chevron-up');
            icon.classList.add('ti-chevron-down');
          }
          element.setAttribute('aria-expanded', 'false');
        });
      }
    });
  });
</script>
@endsection

