@extends('layouts.app-back')

@section('content')
    @include('admin.users.roles.add-role-modal')
    @include('admin.users.roles.edit-role-modal')

    <div class="card">
        <x-layouts.header.table-header :addButtonText="'Tambah Role'" :customPermission="'Roles-create'" :searchPlaceholder="'Cari Role...'" :addModalTarget="'#add-role-modal'" />

        <div class="card-body py-4">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <!--begin::Datatable-->
                    <table id="user-role-table" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>NO</th>
                                <th class="min-w-50px">Aksi</th>
                                <th>Name</th>
                                <th>Guard Name</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
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
        const form = document.getElementById('add-role-list-form');
        const editForm = document.getElementById('edit-role-list-form');
        const submitButton = document.getElementById('add-button');
        const editSubmitButton = document.getElementById('edit-button');

        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table
            var dt;
            var roles;

            table = document.getElementById('user-role-table');

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
                        [5, 'desc']
                    ],
                    ajax: {
                        url: "/user/roles/data", // send request for datatable
                        type: 'GET',
                        error: function(xhr, textStatus, errorMessage) {
                            showAlert('error', 'Gagal memuat daftar role, silahkan coba lagi nanti');
                        },
                        complete: function() {
                            $('.dataTables_processing').hide();
                        }
                    },
                    columns: [{
                            data: null,
                            name: 'row_number',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
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
                            render: function(data, type, full, meta) {
                                switch (data) {
                                    case 'super admin':
                                        return `<span class="badge badge-dark fs-5">${data}</span>`;
                                    case 'admin':
                                        return `<span class="badge badge-light-success fs-5">${data}</span>`;
                                    case 'user':
                                        return `<span class="badge badge-light-warning fs-5">${data}</span>`;
                                    default:
                                        var colors = ["blue", "indigo", "purple", "pink", "red",
                                            "orange", "yellow", "green", "teal", "cyan"
                                        ];
                                        var randomColor = colors[Math.floor(Math.random() * colors
                                            .length)];
                                        return `<span class="badge badge-light-${randomColor} fs-5">${data}</span>`;
                                }
                            }
                        },
                        {
                            data: 'guard_name',
                            name: 'guard_name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at'
                        },
                    ],
                    responsive: true,
                    stateSave: false,
                });

                closeButton.addEventListener('click', function() {
                    resetForm(form, null);
                });

                // Initialize form validation
                const validator = FormValidation.formValidation(form, formValidationConfig);
                const editValidator = FormValidation.formValidation(editForm, editFormValidationConfig);

                // Function to handle form submission
                function handleFormSubmission() {
                    // Validate form before submit
                    if (validator) {
                        validator.validate().then(function(status) {
                            if (status == 'Valid') {
                                disableSubmitButton(submitButton);

                                let formData = $(form).serialize();
                                // Make AJAX request to the server
                                $.ajax({
                                    url: '/user/roles/store',
                                    method: 'POST',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // type: 'success', // Add a comma here
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Membuat Role Baru!');
                                        $('#add-role-modal').modal('hide');

                                        // Add reset form if needed
                                        resetForm(form, null);
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
                $('#user-role-table').on('click', '#edit-role-button', function(e) {
                    e.preventDefault();
                    dataId = $(this).data('id');

                    $.ajax({
                        url: '/user/roles/edit/' + dataId,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            populateForm(editForm, response);
                            var permissions = response.permissions;
                            // Loop through the permissions
                            for (var i = 0; i < permissions.length; i++) {
                                // Get the permission name
                                var permissionName = permissions[i].name;

                                // Check the checkbox with the permission name
                                $('input[name="permission[]"][value="' + permissionName + '"]')
                                    .prop('checked', true);
                            }
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
                                    url: '/user/roles/update/' + dataId,
                                    method: 'PUT',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // type: 'success', // Add a comma here
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Memperbarui Role!');
                                        $('#edit-role-modal').modal('hide');
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
                                $('#edit-role-modal').modal('show');
                            }
                        });
                    }
                }

                // Event listener for submit button
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFormSubmission();
                });

                editSubmitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleEditFormSubmission();
                });
                editCloseButton.addEventListener('click', function() {
                    confirmAction('update', 'role').then(function(isValid) {
                        if (isValid.value) {
                            handleEditFormSubmission();
                        } else {
                            $('#edit-role-modal').modal('hide');
                            resetForm(editForm, null, null);
                        }
                    });
                });

                $('#user-role-table').on('click', '#delete-role-button', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let url = '/user/roles/delete/' + id;

                    confirmAction('delete', name).then(function(isValid) {
                        if (isValid.value) {
                            deleteData(dt, name, url);
                        }
                    });
                });


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
                    exportButtons(table, '#user-role-table', 'Role Report_' + new Date().toISOString().slice(0,
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
