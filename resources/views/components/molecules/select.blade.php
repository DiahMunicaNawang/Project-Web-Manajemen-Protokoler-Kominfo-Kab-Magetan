@props(['id' => '', 'name', 'label', 'activate' => true, 'required' => false,])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>
    <select id="{{ $id }}" name="{{ $name }}" class="form-select" aria-label="{{ $label }}">
        <option value="" disabled selected hidden>Pilih Salah Satu Opsi</option>
        {{ $slot }}
    </select>
</div>