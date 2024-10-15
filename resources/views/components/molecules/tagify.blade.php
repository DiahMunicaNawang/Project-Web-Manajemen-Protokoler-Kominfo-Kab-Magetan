@props([
    'id' => '',
    'name' => '',
    'value' => null,
    'label' => '',
    'placeholder' => '',
    'required' => false,
    'buttonId' => '',
])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>

    <input class="form-control" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ $value }}" autofocus />
    <div class="mt-3">
        <button type="button" id="{{ $buttonId }}" class="btn btn-sm btn-light-primary font-weight-bold">Hapus Semua
            Keywords</button>
    </div>
</div>

@push('plugins-scripts')
    <script>
        var input_{{ $id }} = document.getElementById("{{ $id }}");
        var tagify_{{ $id }} = new Tagify(input_{{ $id }}, {
            placeholder: "{{ $placeholder }}",
            texts: {
                duplicate: "Kata kunci tidak boleh dobel",
            }
        });

        // Add event listener to the button
        let removeButton_{{ $id }} = document.querySelector("#{{ $buttonId }}")
        removeButton_{{ $id }}.addEventListener("click", function() {
            tagify_{{ $id }}.removeAllTags();
        });
    </script>
@endpush
