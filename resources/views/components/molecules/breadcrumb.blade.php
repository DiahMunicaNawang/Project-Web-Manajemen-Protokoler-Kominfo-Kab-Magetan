@props([
    'title' => '',
    'breadcrumb' => '',
])

<div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container"
        class="app-container  container-xxl d-flex flex-stack ">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <!--begin::Title-->
            <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0"
                id="page-title">
                {{ $title }}
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ol class="breadcrumb breadcrumb-line text-muted fs-6 fw-semibold">
                @if (isset($breadcrumb))
                    @foreach ($breadcrumb as $row)
                        @if ($loop->last)
                            <li class="breadcrumb-item text-muted">{{ $row['title'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $row['url'] }}">{{ $row['title'] }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ol>
            <!--end::Breadcrumb-->
        </div>
    </div>
    <!--end::Toolbar container-->
</div>