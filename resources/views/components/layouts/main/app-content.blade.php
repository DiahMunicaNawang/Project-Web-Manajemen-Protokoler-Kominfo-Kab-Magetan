@props([
    'title' => '',
    'breadcrumb' => '',
])

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <x-molecules.breadcrumb :title="$title" :breadcrumb="$breadcrumb"></x-molecules.breadcrumb>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid mb-10">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-xxl">
                @yield('content')
            </div>
            <!--end::Products-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
