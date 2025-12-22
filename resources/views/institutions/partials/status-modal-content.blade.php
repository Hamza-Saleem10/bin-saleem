<div class="status-modal-content">
    <div class="text-center mb-3">
        <h6 class="text-muted">Application No: {{ $application->id ?? $institution->id ?? 'N/A' }}</h6>
        @if(isset($application))
            <p class="text-muted small">Current Status: <span class="fw-bold">{{ $application->status }}</span></p>
        @endif
    </div>
    
    <div class="application-status-tracking">
        @foreach($stages as $stage)
            @php
                $status = $stageStatuses[$stage] ?? 'Pending';
            @endphp
            
            <div class="status-step bg-light border rounded p-3 mb-2 
                {{ $status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to') ? 'border-success bg-success-subtle' : '' }}
                {{ str_contains($status, 'Rejected') ? 'border-danger bg-danger-subtle' : '' }}
                {{ $status === 'Pending' ? 'border-warning bg-warning-subtle' : '' }}
                {{ $status === 'N/A' ? 'border-secondary bg-light' : '' }}">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="status-title fw-semibold small text-dark 
                        {{ $status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to') ? 'text-success' : '' }}
                        {{ str_contains($status, 'Rejected') ? 'text-danger' : '' }}
                        {{ $status === 'Pending' ? 'text-warning' : '' }}
                        {{ $status === 'N/A' ? 'text-muted' : '' }}">
                        {{ $stage }}
                    </div>
                    <div class="status-badge">
                        @if($status === 'Completed' || $status === 'Approved')
                            <span class="badge bg-success rounded-pill px-3 py-1">{{ $status }}</span>
                        @elseif(str_contains($status, 'Forwarded to'))
                            <span class="badge bg-primary rounded-pill px-3 py-1">{{ $status }}</span>
                        @elseif(str_contains($status, 'Rejected'))
                            <span class="badge bg-danger rounded-pill px-3 py-1">{{ $status }}</span>
                        @elseif($status === 'Pending')
                            <span class="badge bg-warning rounded-pill px-3 py-1">Pending</span>
                        @elseif($status === 'N/A')
                            <span class="badge bg-secondary rounded-pill px-3 py-1">N/A</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-1">{{ $status }}</span>
                        @endif
                    </div>
                </div>
            </div>
            
            @if(!$loop->last)
                @php
                    $connectorClass = 'border-secondary';
                    if ($status === 'Completed' || $status === 'Approved' || str_contains($status, 'Forwarded to')) {
                        $connectorClass = 'border-success';
                    } elseif (str_contains($status, 'Rejected')) {
                        $connectorClass = 'border-danger';
                    } elseif ($status === 'Pending') {
                        $connectorClass = 'border-warning';
                    } elseif ($status === 'N/A') {
                        $connectorClass = 'border-secondary';
                    }
                @endphp
                
                <div class="status-connector d-flex justify-content-center my-1">
                    <div class="connector-line border-start border-2 h-4 {{ $connectorClass }}"></div>
                </div>
            @endif
        @endforeach
    </div>
</div>