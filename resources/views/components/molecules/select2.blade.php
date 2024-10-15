@props(['id', 'name', 'label', 'activate' => true, 'required' => false, 'multiple' => false])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" class="form-select" aria-label="{{ $label }}"
        data-placeholder="Silahkan pilih opsi" data-control="select2" {{ $multiple ? 'multiple' : '' }}>
        <option></option>
        {{ $slot }}
    </select>
</div>