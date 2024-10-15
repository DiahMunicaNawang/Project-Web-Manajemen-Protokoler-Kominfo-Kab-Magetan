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
    'max' => null,
    'data_name' => null,
    'data_value' => null,
])

<div class="fv-row mb-10 {{ $class }}">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>

    <input type="{{ $type }}" id="{{ $id ?? $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        @if ($value) value="{{ $value }}" @endif class="form-control mb-3 mb-lg-0 "
        @if ($data_name) data-{{ $data_name }}="{{ $data_value }}" @endif
        {{ $type == 'number' ? 'min=0' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}  @if ($max) max="{{ $max }}" @endif />
</div>
