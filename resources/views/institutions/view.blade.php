<x-app-layout>
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    
                    <!-- [ breadcrumb ] start -->
                    <x-breadcrumb title="{{ $title }} Application" />
                    <!-- [ breadcrumb ] end -->
                    
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card card-custom gutter-b example example-compact">
                                        <!--begin::Form-->
                                        {!! Form::model($institution, ['id' => 'formValidation'] ) !!}
                                            <div class="card-body row">
                                                @include ('institutions.form')

                                                @if(@$institution->activeApplication->logs)
                                                    <div class="accordion" id="commentsAccordion">
                                                        {{-- ================= 13. Comments ================= --}}
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments">
                                                                    <strong>Comments </strong>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseComments" class="accordion-collapse collapse" data-bs-parent="#commentsAccordion">
                                                                <div class="accordion-body">
                                                                    @foreach($institution->activeApplication->logs as $log)
                                                                        @if(roleName() != 'School Owner' || (roleName() == 'School Owner' && $log->status == 'Rejected'))
                                                                            <div class="comment">
                                                                                <div class="comment-content">
                                                                                    <div class="author d-flex justify-content-between">
                                                                                        {{ optional($log->fromser)->name }}
                                                                                        <div class="float-right d-none d-md-block ">
                                                                                            @if($log->status == 'Approved')
                                                                                                <span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-success" >Approved</a></span>
                                                                                            @elseif($log->status == 'Rejected')
                                                                                                <span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-danger" >Rejected</a></span>
                                                                                            @else
                                                                                                <span style="overflow: visible; position: relative; width: 130px;"><a href="#" class="badge bg-info" >{{ $log->status }}</a></span>
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="date">{{ date('d M Y h:i a', strtotime($log->created_at)) }}</div>
                                                                                    </div>
                                                                                    <div class="message">{{ $log->comment }}</div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(auth()->user()->can('Review Institution'))
                                                    <!-- buttons start -->
                                                    <div class="d-grid gap-2 d-md-block py-2 ps-1">
                                                        @if(showForwardBtn($institution->activeApplication->status))
                                                            <button type="button" class="btn btn-info action-btn" data-type="Forward" data-bs-toggle="modal" data-bs-target="#reviewModal">Forward</button>
                                                        @endif
                                                        @if(showApproveBtn($institution->activeApplication->status))
                                                            <button type="button" class="btn btn-success action-btn" data-type="Approve" data-bs-toggle="modal" data-bs-target="#reviewModal">Approve</button>
                                                        @endif
                                                        @if(showRejectBtn($institution->activeApplication->status))
                                                            <button type="button" class="btn btn-danger mx-2 action-btn" data-type="Reject" data-bs-toggle="modal" data-bs-target="#reviewModal">Reject</button>
                                                        @endif
                                                        @if(showReturnBtn($institution->activeApplication->status))
                                                            <button type="button" class="btn btn-warning action-btn" data-type="Returned" data-bs-toggle="modal" data-bs-target="#reviewModal">Returned</button>
                                                        @endif
                                                    </div>
                                                    <!-- buttons end -->
                                                @endif
                                            </div>
                                        {!! Form::close() !!}        <!--end::Card-->
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Modal -->
    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['id' => 'application-review', 'method' => 'post']) !!}
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="{{ $institution->activeApplication->uuid }}"/>
                    <input type="hidden" name="action" id="action"/>
                    <div class="mb-3">
                        <label for="comment" class="form-label text-dark fw-bold">Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-submit">Submit</button>
                </div>
            {!! Form::close() !!}
            </div>
        </div>
    </div>
    <!-- modal end -->

    @push('scripts')
    <script type="text/javascript">
        $('document').ready(function() {
            $('input').attr('disabled', 'disabled');
            $('select').attr('disabled', 'disabled');
            $('#add-faculty-btn, .remove-faculty-member').addClass('d-none');
            

            $('.action-btn').on('click', function() {
                $('#id, #action').attr('disabled', false);
                $('#action').val($(this).attr('data-type'));
            });

            $('.btn-submit').on('click', function(e) {
                e.preventDefault(); 
                if ($('#application-review').valid()) {
                    loadingOverlay($('.btn-submit'));
                    ajaxCall('application-review', route('institutions.review'), 'POST', $('#application-review').serializeFiles(), null, saveApplicationReview);
                }
            });

            /**
             * Save Application Review Callback Function
             * @param response
             */
            const saveApplicationReview = (response) => {
                if (response.success) {
                    generalMessage(response);

                    setTimeout(() => {
                        window.location.href = route('institutions.index');
                    }, 3000);
                } else {
                    stopOverlay($('.btn-submit'));
                    generalMessage(response);
                }
            }
        });
    </script>
    @endpush
</x-app-layout>