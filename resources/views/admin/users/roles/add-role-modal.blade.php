<x-molecules.modal id="add-role-modal" title="Add role" type="add" formId="add-role-list-form" formMethod="POST"
    confirmButton="Konfirmasi" buttonId="add-button">

    <x-molecules.input label="Role Name" name="name" type="text" placeholder="Enter a role name" required />

    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-5 fw-bold form-label mb-2 required">Permission</label>
        <!--end::Label-->
        <!--begin::Table wrapper-->
        <div class="table-responsive">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody class="text-gray-600 fw-semibold">
                    <tr>
                        <td class="text-gray-800">Administrator Access
                            <span class="ms-1" data-bs-toggle="tooltip"
                                aria-label="Allows a full access to the system">
                            </span>
                        </td>
                        <td>
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-9">
                                <input class="form-check-input" type="checkbox" value="*"
                                    id="kt_roles_select_all">
                                <span class="form-check-label" for="kt_roles_select_all">Select all</span>
                            </label>
                            <!--end::Checkbox-->
                        </td>
                    </tr>

                    @foreach ($abilities as $ability)
                        <tr>
                            <td class="text-gray-800">{{ $ability }}</td>

                            <td id="abilities-container">
                                <div class="d-flex">
                                    @foreach (['create', 'read', 'update', 'delete'] as $action)
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                            <input class="form-check-input ability-checkbox" type="checkbox"
                                                value="{{ $ability . '-' . $action }}" name="permission[]">
                                            <span class="form-check-label">{{ ucfirst($action) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table wrapper-->
    </div>
</x-molecules.modal>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('kt_roles_select_all');
            const abilityCheckboxes = document.querySelectorAll('.ability-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = selectAllCheckbox.checked;

                abilityCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });

                // Dispatch custom event
                const eventName = isChecked ? 'selectAll' : 'deselectAll';
                const selectAllEvent = new Event(eventName);
                document.dispatchEvent(selectAllEvent);
            });

            abilityCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const allOptionCheckboxesChecked = [...abilityCheckboxes].every(function(
                        checkbox) {
                        return checkbox.checked;
                    });

                    selectAllCheckbox.checked = allOptionCheckboxesChecked;
                });
            });
        });
    </script>
@endpush
