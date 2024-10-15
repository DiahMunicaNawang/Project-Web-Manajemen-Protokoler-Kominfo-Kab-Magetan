@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'checked' => null,
    'radio1_name' => null,
    'radio2_name' => null,
])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2"
           for="checkbox-container">{{ $label }}</label>

    <div class="d-flex flex-wrap" name="checkbox-container">
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-4 me-2 status-label">
            <div class="d-flex align-items-center me-2">
                <div class="form-check form-check-custom form-check-solid form-check-info me-6">
                    <input class="form-check-input status-radio" type="radio" name="{{ $name }}" value="1" {{ $checked === null || $checked == "1" ? 'checked' : '' }} />
                </div>
                <span>{{ $radio1_name ? $radio1_name : 'Aktif' }}</span>
            </div>
        </label>

        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-4 status-label">
            <div class="d-flex align-items-center me-2">
                <div class="form-check form-check-custom form-check-solid form-check-info me-6">
                    <input class="form-check-input status-radio" type="radio" name="{{ $name }}" value="0" {{ $checked === "0" ? 'checked' : '' }} />
                </div>
                <span>{{ $radio2_name ? $radio2_name : 'Tidak Aktif' }}</span>
            </div>
        </label>
    </div>
</div>
