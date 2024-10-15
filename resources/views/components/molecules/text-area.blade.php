@props([
    'label',
    'id',
    'name' => null,
    'type' => null,
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'class' => '',
    'data_name' => null,
    'data_value' => null,
])

<div class="fv-row mb-10 {{ $class }}">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>

    @if ($value != null)
    <textarea class="form-control" data-kt-autosize="true" id="{{ $id ?? $name }}" name="{{ $name }}"
    placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
    @if ($data_name) data-{{ $data_name }}="{{ $data_value }}" @endif
    {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
    @else
    <textarea class="form-control" data-kt-autosize="true" id="{{ $id ?? $name }}" name="{{ $name }}"
        placeholder="{{ $placeholder }}" {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
        @if ($data_name) data-{{ $data_name }}="{{ $data_value }}" @endif
        {{ $required ? 'required' : '' }}></textarea>
    @endif
</div>
