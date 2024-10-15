@props([
    'addButtonText' => '',
    'customPermission' => '',
    'customFilterId' => '',
    'searchPlaceholder' => '',
    'addModalTarget' => '',
    'filterLabel' => '',
    'filterType' => '',
    'data' => null,
    'field' => '',
    'fieldValue' => null,
])

<div class="card-header border-0 pt-6">
    <div class="card-title">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6">
                <span class="path1"></span><span class="path2"></span>
            </i>
            <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15"
                placeholder="{{ $searchPlaceholder }}" />
            <!--begin::Filter-->

            @if ($customFilterId != '')
                <button type="button" class="btn btn-light-primary ms-3" data-bs-toggle="modal"
                    data-bs-target="{{ $customFilterId }}">
                    <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Filter
                </button>
            @elseif (isset($data))
                <button type="button" class="btn btn-light-primary ms-3" data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-filter fs-2"><span class="path1"></span><span class="path2"></span></i>
                    Filter
                </button>
                <!--end::Filter-->

                {{-- begin::Menu --}}
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                    id="kt-toolbar-filter" style="">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-4 text-gray-900 fw-bold">Filter</div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Separator-->

                    <!--begin::Content-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fs-5 fw-semibold mb-3">{{ $filterLabel }}</label>
                            <!--end::Label-->

                            <!--begin::Options-->
                            <div class="d-flex flex-column flex-wrap fw-semibold"
                                data-kt-docs-table-filter="{{ $filterType }}">
                                <!--begin::Option-->
                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                    <input class="form-check-input" type="radio" name="{{ $filterType }}"
                                        value="">
                                    <span class="form-check-label text-gray-600">
                                        All
                                    </span>
                                </label>
                                <!--end::Option-->

                                <!--begin::Option-->
                                @if (is_iterable($data))
                                    @foreach ($data as $item)
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                            <input class="form-check-input" type="radio" name="{{ $filterType }}"
                                                value="{{ $item->$fieldValue == null ? $item->$field : $item->$fieldValue }}">

                                            <span class="form-check-label text-gray-600">
                                                {{ $item->$field }}
                                            </span>
                                        </label>
                                    @endforeach
                                @endif
                                <!--end::Option-->
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset</button>

                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true"
                                data-kt-docs-table-filter="filter">Apply</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Content-->
                </div>
                {{-- end::Menu --}}
            @endif
        </div>
        <!--end::Search-->
    </div>

    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
            <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-end">
                <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
                Export Data
            </button>
            <!--begin::Menu-->
            <div id="kt_datatable_example_export_menu"
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="copy">Salin ke clipboard</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="excel">Export sebagai Excel</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="csv">Export sebagai CSV</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3" data-kt-export="pdf">Export sebagai PDF</a>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Export dropdown-->

            <!--begin::Hide default export buttons-->
            <div id="user-list-table-buttons" class="d-none"></div>

            @can($customPermission)
                <!--begin::Add customer-->
                <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal"
                    data-bs-target="{{ $addModalTarget }}">
                    <i class="ki-duotone ki-plus fs-2"></i>
                    {{ $addButtonText }}
                </button>
                <!--end::Add customer-->
            @endcan
        </div>
    </div>

    <!--begin::Group actions-->
    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
        <div class="fw-bold me-5">
            <span class="me-2" data-kt-docs-table-select="selected_count"></span> Data Terpilih
        </div>

        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip"
            data-kt-docs-table-select="delete_selected">
            Hapus Data
        </button>
    </div>
    <!--end::Group actions-->
</div>
