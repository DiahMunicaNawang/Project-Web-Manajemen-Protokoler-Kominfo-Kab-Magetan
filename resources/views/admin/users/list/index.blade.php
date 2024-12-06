@extends('layouts.app-back')

@section('content')
    {{-- Import modals --}}
    @include('admin.users.list.add-list-modal')
    @include('admin.users.list.edit-list-modal')
    {{-- End import modals --}}
    <div class="card">
        <x-layouts.header.table-header :addButtonText="'Tambah User'" :customPermission="'User List-create'" :searchPlaceholder="'Cari Pengguna...'" :addModalTarget="'#add-user-modal'"
            :filterLabel="'Role Type'" :filterType="'role_type'" :data="$roles" :field="'name'" />

        <div class="card-body py-4">
            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <!--begin::Datatable-->
                    <table id="user-list-table" class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#user-list-table .form-check-input" id="header-checkbox"
                                            value="1" />
                                    </div>
                                </th>
                                <th class="min-w-50px">Aksi</th>
                                <th class="text-center">NIP</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
                                <th>Alamat</th>
                                <th>Updated At</th>
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
        const form = document.getElementById('add-user-list-form');
        const editForm = document.getElementById('edit-user-list-form');
        const submitButton = document.getElementById('add-button');
        const editSubmitButton = document.getElementById('edit-button');

        // Filter Datatable
        const filter = document.querySelectorAll(
            '[data-kt-docs-table-filter="role_type"] [name="role_type"]');

        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table
            var dt;
            var roles;

            table = document.getElementById('user-list-table');

            // Private functions
            var initDatatable = function() {
                var currentDraw = 1; // Add this line to declare and initialize currentDraw
                dt = $(table).DataTable({

                    processing: true,
                    serverSide: true,
                    lengthMenu: [
                        [5, 15, 25, 100, 1000],
                        [5, 15, 25, 100, 1000],
                    ],
                    pageLength: 15,
                    order: [
                        [9, 'desc']
                    ],
                    ajax: {
                        url: "/user/list/data", // send request for datatable
                        type: 'GET',
                        error: function(xhr, textStatus, errorMessage) {
                            showAlert('error', 'Gagal memuat daftar pengguna, silahkan coba lagi nanti');
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
                            data: 'person.nip',
                            name: 'person.nip',
                            width: '20%',
                            render: function(data, type, full, meta) {
                                return `<p class="text-center fw-bold text-hover-success">${data}</p>`;
                            }
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'roles',
                            name: 'roles',
                            searchable: true,
                            render: function(data, type, full, meta) {
                                switch (data) {
                                    case 'super-admin':
                                        return `<span class="badge badge-light-purple fs-6 fw-medium">${data}</span>`;
                                    case 'admin-protokoler':
                                        return `<span class="badge badge-light-success fs-6 fw-medium">${data}</span>`;
                                    case 'admin-instansi':
                                        return `<span class="badge badge-light-warning fs-6 fw-medium">${data}</span>`;
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
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'person.phone',
                            name: 'person.phone',
                        },
                        {
                            data: 'person.address',
                            name: 'person.address',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                            visible: false,
                        },
                    ],
                    responsive: true,
                    stateSave: false,
                });

                closeButton.addEventListener('click', function() {
                    myDropzone_User_image.removeAllFiles();
                    resetForm(form, null);
                });

                // Initialize form validation
                const validator = FormValidation.formValidation(form, formValidationConfig);
                const editValidator = FormValidation.formValidation(editForm, editFormValidationConfig);

                // Submit button handler
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
                                    url: '/user/list/store',
                                    method: 'POST',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // type: 'success', // Add a comma here
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Membuat User Baru!');
                                        $('#add-user-modal').modal('hide');
                                        resetDropzoneUi(dropzone_User_image);
                                        dt.draw();
                                    },
                                    error: function(xhr, textStatus, errorMessage) {
                                        if (xhr.status == 422) {
                                            enableSubmitButton(submitButton);
                                            var response = JSON.parse(xhr.responseText);
                                            var message = response.data;
                                            showAlert('error', message);
                                        }
                                    },
                                });
                            };

                        });
                    }
                }

                // ================================================
                // Edit Part
                // ================================================
                $('#user-list-table').on('click', '#edit-user-button', function(e) {
                    e.preventDefault();
                    var dataId = $(this).data('id');
                    $.ajax({
                        url: '/user/list/edit/' + dataId,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            populateForm(editForm, response.user);
                            populateForm(editForm, response.user.person);

                            var roleName = response.user.roles[0].name;
                            $('#edit-role').val(roleName).change();
                            const UserImage = parseJsonString(response.photo);
                            // Populate dropzone
                            if (UserImage && UserImage.path != null) {
                                populateDropzone(myDropzone_edit_User_image, UserImage);
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
                                var dataId = $('#edit-user-button').data('id');
                                $.ajax({
                                    url: '/user/list/update/' + dataId,
                                    method: 'PUT',
                                    data: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // type: 'success', // Add a comma here
                                    success: function(response) {
                                        enableSubmitButton(submitButton);
                                        showAlert('success',
                                            'Berhasil Mengubah User!');
                                        $('#edit-user-modal').modal('hide');
                                        resetDropzoneUi(dropzone_edit_User_image);
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
                                $('#edit-user-modal').modal('show');
                            }
                        });
                    }
                }
                editCloseButton.addEventListener('click', function() {
                    confirmAction('update', 'user').then(function(isValid) {
                        if (isValid.value) {
                            handleEditFormSubmission();
                        } else {
                            $('#edit-user-modal').modal('hide');
                            resetForm(editForm, null, null);
                        }
                    });
                });

                // Event listener for submit button
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleFormSubmission();
                });

                editSubmitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    handleEditFormSubmission();
                });

                // Handle close edit modal
                editCloseButton.addEventListener('click', function() {
                    confirmAction('update', 'user').then(function(isValid) {
                        if (isValid.value) {
                            if (editValidator.validate()) {
                                handleEditFormSubmission();
                            } else {
                                $('#edit-user-modal').modal('show');
                            }
                        } else {
                            $('#edit-user-modal').modal('hide');
                            resetForm(editForm, null, null);
                        }
                    });
                });

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    KTMenu.createInstances();
                });

                $('#user-list-table').on('click', '#delete-user-button', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let url = '/user/list/delete/' + id;

                    confirmAction('delete', name,
                        'Aksi ini akan menghapus akun pengguna, apakah anda yakin?').then(function(
                        isValid) {
                        if (isValid.value) {
                            deleteData(dt, name, url);
                        }
                    });
                });

                multipleDelete("#user-list-table", dt, "/user/list/selected-delete/", "User List",
                    'Aksi ini akan menghapus akun pengguna, apakah anda yakin?');
            }

            // Public methods
            return {
                init: function() {
                    initDatatable();
                    handleSearchDatatable(dt);
                    exportButtons(table, '#user-list-table', 'User Report_' + new Date().toISOString().slice(0,
                        10));
                    handleFilterDatatable(dt, filter, filterButton);
                    handleResetFilter(dt, filter, clearFilterButton);
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });
    </script>
@endpush
