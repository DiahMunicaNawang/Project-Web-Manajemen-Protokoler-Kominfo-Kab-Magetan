@props(['id', 'required' => false, 'label', 'name', 'folderName', 'value' => null])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>
    <div class="py-5" data-bs-theme="light">
        <textarea name="{{ $name }}" id="{{ $id }}">
            {{ $value }}
        </textarea>
    </div>
</div>

@push('scripts')
    <script>
        let {{ $id }} = document.querySelector('#{{ $id }}');

        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor.create({{ $id }}, {
                    ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload', ['folderName' => $folderName, '_token' => csrf_token()]) }}",
                    },
                    image: {
                        resizeUnit: 'px',
                        toolbar: [
                            '|',
                            'imageStyle:alignLeft',
                            'imageStyle:alignCenter',
                            'imageStyle:alignRight'
                        ]
                    }
                })
                .then(editor => {
                    {{ $id }} = editor;
                    if ("{{ $value }}" !== null) {
                        editor.setData(`{!! $value !!}`);
                    }
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });
        });
    </script>
@endpush
