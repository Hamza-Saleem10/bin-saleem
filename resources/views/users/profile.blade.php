<x-app-layout>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <x-breadcrumb title="Profile" />
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card shadow-sm border-0 rounded-3 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-4 px-4 border-0"
                            style="background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-4">
                                        <div class="avatar-circle" style="width: 72px; height: 72px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.25); transition: transform 0.2s ease;">
                                            <span class="avatar-initials" style="font-size: 28px; font-weight: 600; color: white; letter-spacing: 1px;">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(auth()->user()->name, ' '), 1, 1)) }}
                                            </span>
                                        </div>
                                        <span class="status-dot" style="position: absolute; bottom: 6px; right: 6px; width: 14px; height: 14px; background-color: #22c55e; border: 2px solid white; border-radius: 50%; display: block; box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2); animation: pulse-green 2s infinite;"></span>
                                    </div>
                                    <div>
                                        <h3 class="mb-1 fw-semibold text-dark">{{ auth()->user()->name }}</h3>
                                        <p class="text-secondary mb-0 fs-6">@ {{ auth()->user()->username }}</p>
                                    </div>
                                </div>
                                <div class="info-badge" style="background: #f8fafc; padding: 0.5rem 1rem; border-radius: 1rem; text-align: right; border: 1px solid #eef2f6;">
                                    <div class="small text-uppercase text-secondary mb-1">Last Login</div>
                                    <div class="fw-semibold text-dark">
                                        @if($lastLogin && $lastLogin->created_at)
                                        {{ \Carbon\Carbon::parse($lastLogin->created_at)->format('F d, Y h:i A') }}
                                        @else
                                        No login record found
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details -->
                        <div class="card-body p-4">
                            <!-- Email -->
                            <div class="detail-row d-flex align-items-start gap-3 py-3 border-bottom border-light" style="transition: background-color 0.2s ease;">
                                <div class="detail-icon d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px; color: #4e73df; font-size: 1.1rem; transition: all 0.2s ease;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="detail-content flex-grow-1">
                                    <label class="detail-label small text-uppercase fw-semibold text-secondary mb-1 d-block" style="letter-spacing: 0.5px;">Email Address</label>
                                    <div class="detail-value fw-semibold text-dark" style="font-size: 1rem; word-break: break-word;">{{ auth()->user()->email }}</div>
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="detail-row d-flex align-items-start gap-3 py-3 border-bottom border-light" style="transition: background-color 0.2s ease;">
                                <div class="detail-icon d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px; color: #4e73df; font-size: 1.1rem; transition: all 0.2s ease;">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="detail-content flex-grow-1">
                                    <label class="detail-label small text-uppercase fw-semibold text-secondary mb-1 d-block" style="letter-spacing: 0.5px;">Mobile Number</label>
                                    <div class="detail-value fw-semibold text-dark" style="font-size: 1rem; word-break: break-word;">{{ auth()->user()->mobile ?? '—' }}</div>
                                </div>
                            </div>

                            <!-- CNIC -->
                            <div class="detail-row d-flex align-items-start gap-3 py-3 border-bottom border-light" style="transition: background-color 0.2s ease;">
                                <div class="detail-icon d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px; color: #4e73df; font-size: 1.1rem; transition: all 0.2s ease;">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div class="detail-content flex-grow-1">
                                    <label class="detail-label small text-uppercase fw-semibold text-secondary mb-1 d-block" style="letter-spacing: 0.5px;">CNIC Number</label>
                                    <div class="detail-value fw-semibold text-dark" style="font-size: 1rem; word-break: break-word;">{{ auth()->user()->cnic ?? '—' }}</div>
                                </div>
                            </div>

                            <!-- Member Since -->
                            <div class="detail-row d-flex align-items-start gap-3 py-3" style="transition: background-color 0.2s ease;">
                                <div class="detail-icon d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); border-radius: 12px; color: #4e73df; font-size: 1.1rem; transition: all 0.2s ease;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="detail-content flex-grow-1">
                                    <label class="detail-label small text-uppercase fw-semibold text-secondary mb-1 d-block" style="letter-spacing: 0.5px;">Member Since</label>
                                    <div class="detail-value fw-semibold text-dark" style="font-size: 1rem; word-break: break-word;">{{ auth()->user()->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Status Card -->
                    <div class="card border-0 shadow-sm rounded-3 bg-gradient-light" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-shield-alt text-primary"></i>
                                    <span class="small text-secondary">Account Status</span>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-semibold" style="background-color: rgba(34, 197, 94, 0.1) !important; color: #16a34a !important;">Active</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-verified text-primary"></i>
                                    <span class="small text-secondary">Identity</span>
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill fw-semibold" style="background-color: rgba(59, 130, 246, 0.1) !important; color: #2563eb !important;">Verified</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
</x-app-layout>

<style>
    @keyframes pulse-green {
        0% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }

    .avatar-circle:hover {
        transform: scale(1.02);
    }

    .detail-row:hover {
        background-color: #f8fafc;
        margin: 0 -0.5rem;
        padding: 1rem 0.5rem !important;
        border-radius: 0.5rem;
    }

    .detail-row:hover .detail-icon {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
        color: white !important;
        transform: scale(1.05);
    }

    @media (max-width: 576px) {
        .avatar-circle {
            width: 56px !important;
            height: 56px !important;
        }

        .avatar-initials {
            font-size: 22px !important;
        }

        .detail-icon {
            width: 34px !important;
            height: 34px !important;
            font-size: 0.9rem !important;
        }

        .info-badge {
            width: 100%;
            text-align: left !important;
            margin-top: 0.5rem;
        }

        .detail-value {
            font-size: 0.875rem !important;
        }
    }
</style>