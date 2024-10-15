@extends('layouts.app-back')

@section('content')
    {{-- Import modals --}}
    @include('admin.event.filter-modal')
    @include('admin.event.add-event-modal')
    @include('admin.event.edit-event-modal')

    <div class="card">
        <x-layouts.header.table-header :addButtonText="'Tambah Event'" :customPermission="'Event-create'" :searchPlaceholder="'Cari Event...'" :addModalTarget="'#add-product-modal'"
            :customFilterId="'#filter-event-modal'" />

        <div class="card-body py-4">

            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <!--begin::Datatable-->
                    <table id="event-table" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#event-table .form-check-input" id="header-checkbox"
                                            value="1" />
                                    </div>
                                </th>
                                <th class="min-w-50px">Aksi</th>
                                <th>Nama Acara</th>
                                <th>Tanggal dan waktu</th>
                                <th>Dinas</th>
                                <th>Ketarangan</th>
                                <th>Tempat</th>
                                <th>File Pdf</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const form = document.getElementById('add-product-form');
        const submitButton = document.getElementById('add-button');
        const filterForm = document.getElementById('filter-event-form');
        const submitFilter = document.getElementById('filter-event-button');
        const closeFilter = document.getElementById('close-filter-button');
        const editForm = document.getElementById('edit-product-form');
        const editSubmitButton = document.getElementById('edit-button');

        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table
            var dt;

            table = document.getElementById('event-table');

            // Private functions
            var initDatatable = function() {
                dt = $(table).DataTable({
                    processing: true,
                    serverSide: true,
                    lengthMenu: [
                        [5, 15, 25, 100, 1000],
                        [5, 15, 25, 100, 1000],
                    ],
                    pageLength: 15,
                    order: [
                        [8, 'desc']
                    ],
                    language: {
                        emptyTable: "Gagal memuat daftar acara", // Placeholder text when there's no data
                        loadingRecords: "Memuat daftar acara...", // Text while loading
                        zeroRecords: "Tidak ada acara yang ditemukan" // Text when search/filter returns no records
                    },
                    ajax: {
                        url: "/event/data", // send request for datatable
                        type: 'GET',
                        error: function(xhr, textStatus, errorMessage) {
                            showAlert('error', 'Gagal memuat daftar acara, silahkan coba lagi nanti');
                        },
                        complete: function() {
                            $('.dataTables_processing').hide();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input type="checkbox" class="form-check-input" id="select-all-checkbox" data-selected-ids="${row.id}">
                                    </div>`;
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'time',
                            name: 'time',
                        },
                        {
                            data: 'dinas',
                            name: 'dinas',
                        },
                        {
                            data: 'description',
                            name: 'description',
                            render: function(data, type, row) {
                                let shortDescription = data.split(' ').slice(0, 50).join(' ') +
                                    '...';
                                return shortDescription;
                            }
                        },
                        {
                            data: 'location',
                            name: 'location',
                        },
                        {
                            data: 'pdf_file',
                            name: 'pdf_file',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            visible: false,
                        }
                    ],
                    responsive: true,
                    stateSave: false,
                });

                // Initialize form validation
                const validator = FormValidation.formValidation(form, formValidationConfig);
                const editValidator = FormValidation.formValidation(editForm, editFormValidationConfig);
                const filterValidator = FormValidation.formValidation(filterForm, filterFormValidationConfig);

                // Function to handle form submission
                function handleFormSubmission() {
                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function(status) {
                            if (status == 'Valid') {
                                disableSubmitButton(submitButton);

                                let content = event_editor.getData();
                                let formData = $(form).serialize();
                                formData += '&description=' + encodeURIComponent(content);
                                // Make AJAX request to the server
                                $.ajax({
                                    url: '/event/store',
                                    method: 'POST',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                            .attr('content')
                                    },
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Menambahkan Event!'
                                        );
                                        resetForm(form, event_editor);
                                        resetDropzoneUi(dropzone_pdf_file);

                                        $('#add-product-modal').modal('hide');
                                        // Add reset form if needed
                                        dt.draw();
                                    },
                                    error: function(xhr, textStatus, errorMessage) {
                                        enableSubmitButton(submitButton);
                                        var response = JSON.parse(xhr.responseText);
                                        var message = response.meta.message.body;
                                        showAlert('error', message);
                                    },
                                });
                            };

                        });
                    }
                }

                // ================================================
                // Edit Part
                // ================================================
                var dataId;
                $('#event-table').on('click', '#edit-product-button', function(e) {
                    e.preventDefault();
                    dataId = $(this).data('id');

                    $.ajax({
                        url: '/event/edit/' + dataId,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            const productImage = parseJsonString(response.pdf_file);

                            // Set folderName based on response.product.code
                            const folderName = response.product.product_number;
                            $('#edit_pdf_file').attr('folderName', folderName);

                            // Populate dropzone
                            if (productImage && productImage.path != null) {
                                populateDropzone(myDropzone_edit_pdf_file, productImage);
                            }
                            // Populate Ck editor
                            if (response.product.description != null) {
                                edit_event_editor.setData(response.product.description);
                            }

                            // Populate form
                            populateForm(editForm, response.product);

                            // Mapping Selected Categories input based on response.product.categories
                            const selectedCategories = response.product.categories;
                            const selectedCategoryIds = selectedCategories.map(category =>
                                category.id);
                            $('#edit_product_categories').val(selectedCategoryIds).trigger(
                                'change');
                        },
                        error: function(xhr, textStatus, errorMessage) {
                            // Handle error response
                        },
                    });
                });

                function handleEditFormSubmission() {
                    // Validate form before submit
                    if (editValidator) {
                        editValidator.validate().then(function(status) {
                            if (status == 'Valid') {
                                disableSubmitButton(submitButton);
                                let formData = $(editForm).serialize();

                                $.ajax({
                                    url: '/event/update/' + dataId,
                                    method: 'PUT',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // type: 'success', // Add a comma here
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Mengubah Event!');
                                        $('#edit-product-modal').modal('hide');
                                        resetDropzoneUi(dropzone_edit_pdf_file);

                                        dt.draw();
                                    },
                                    error: function(xhr, textStatus, errorMessage) {
                                        enableSubmitButton(submitButton);
                                        var response = JSON.parse(xhr.responseText);
                                        var message = response.meta.message.body;
                                        showAlert('error', message);
                                    },
                                });
                            } else {
                                showAlert('error', 'Tolong isi semua field yang diperlukan!');
                                $('#edit-product-modal').modal('show');
                            }
                        });
                    }
                }

                function handleFilter() {
                    if (filterValidator) {
                        filterValidator.validate().then(function(status) {
                            if (status == 'Valid') {
                                disableSubmitButton(submitFilter);
                                let formData = $(filterForm).serialize();

                                dt.ajax.url('/event/data?' + formData).load(function() {
                                    enableSubmitButton(submitFilter);
                                    $('#filter-event-modal').modal('hide');
                                    resetForm(filterForm);
                                });
                            };

                        });
                    }
                }

                // Event listener for submit button
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFormSubmission();
                });
                // Event listener for Filter
                submitFilter.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFilter();
                });
                // Reset Form and remove dropzone files
                closeButton.addEventListener('click', function() {
                    myDropzone_pdf_file.removeAllFiles();
                    resetForm(form, null, null);
                });

                // Reset Filter
                closeFilter.addEventListener('click', function() {
                    resetForm(filterForm);
                });

                editSubmitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleEditFormSubmission();
                });
                editCloseButton.addEventListener('click', function() {
                    confirmAction('update', 'Event').then(function(isValid) {
                        if (isValid.value) {
                            handleEditFormSubmission();
                        } else {
                            $('#edit-product-modal').modal('hide');
                            resetForm(editForm, null, null);
                            resetDropzoneUi(dropzone_edit_pdf_file);
                        }
                    });
                });

                $('#event-table').on('click', '#delete-product-button', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let url = '/event/delete/' + id;

                    confirmAction('delete', name).then(function(isValid) {
                        if (isValid.value) {
                            deleteData(dt, name, url);
                        }
                    });
                });

                multipleDelete("#event-table", dt, "/event/selected-delete/", "Event",
                    'Aksi ini akan menghapus Event yang dipilih, apakah anda yakin?');

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    KTMenu.createInstances();
                });
            }

            // Public methods
            return {
                init: function() {
                    initDatatable();
                    handleSearchDatatable(dt);
                    exportButtons(table, '#event-table', 'Events Report_' + new Date().toISOString().slice(0,
                        10));
                }
            }
        }();
            
        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });
    </script>
@endpush
