@extends('layouts.app-back')

@section('content')
    @if ($events->isEmpty())
        <div class="container">
            <div class="text-center">
                <!--begin::Icon-->
                <div class="pb-5">
                    <img loading="lazy" src="{{ asset('assets/media/illustrations/sigma-1/13.png') }}" class="h-200px"
                        alt="Empty Illustration" />
                </div>
                <!--end::Icon-->

                <!--begin::Message-->
                <div class="pb-15 fw-semibold">
                    <h3 class="text-gray-600 fs-5 mb-2">Tidak Terdapat Event</h3>
                </div>
                <!--end::Message-->
            </div>
        </div>
    @else
        <div class="container" id="custom-pagination">
            <h1 class="my-4">Latest Events</h1>

            <div class="row">
                @foreach ($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->name }}</h5>
                                @php
                                    $startDate = \Carbon\Carbon::parse($event->start_date);
                                    $now = \Carbon\Carbon::now();
                                @endphp
                                @if ($startDate->isToday())
                                    <span class="badge badge-light-success">Hari Ini</span>
                                @else
                                    <span class="badge badge-light-info">{{ $startDate->diffInDays($now) }} hari lagi</span>
                                @endif
                                <div class="d-flex justify-content-around align-items-center my-5">
                                    <div class="fw-bold text-dark">
                                        <label for="">Start Date</label>
                                        <p>{{ \Carbon\Carbon::parse($event->start_date)->format('d M, H:i') }}</p>
                                    </div>

                                    <div class="fw-bold text-dark">
                                        <label for="">End Date</label>
                                        <p>{{ \Carbon\Carbon::parse($event->end_date)->format('d M, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-2 my-5">
                                    <i class="ki-duotone ki-geolocation text-danger fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <p>{{ $event->location }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <img src="{{ asset('images/logo/Logo-magetan.jpg') }}" alt="">
                                        </div>
                                        <!--end::Avatar-->
                                        <span class="fw-bold d-flex align-items-center text-dark text-hover-primary fs-8">
                                            {{ $event->dinas }}
                                        </span>
                                    </div>
                                    <a href="{{ route('event.show', $event->id) }}"
                                        class="btn btn-sm btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination links -->
            {{ $events->links('components.molecules.pagination') }}
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#custom-pagination').html($(response).find('#custom-pagination')
                            .html());
                        $('html, body').animate({
                            scrollTop: 0
                        }, 'slow'); // Scroll to the top of the page
                    }
                });
            });
        });
    </script>
@endpush
