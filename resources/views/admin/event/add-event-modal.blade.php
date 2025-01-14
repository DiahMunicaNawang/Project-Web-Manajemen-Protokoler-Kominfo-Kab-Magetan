<x-molecules.modal id="add-product-modal" title="Tambah Event" type="add" formId="add-product-form" formMethod="POST"
    confirmButton="Simpan" buttonId="add-button">

    {{-- NAME --}}
    <x-molecules.input class="col-12" label="Nama" name="name" type="text" placeholder="Acara" required />

    {{-- START DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Mulai" id="start_date" name="start_date" type="datetime-local"
        required />

    {{-- END DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Selesai" id="end_date" name="end_date" type="datetime-local" required/>

    {{-- DINAS --}}
    <x-molecules.select2 id="add_dinas" label="Pelaksana" name="dinas"
        required>
        <option value="HR">
            HR
        </option>
        required>
        <option value="KOMINFO">
            KOMINFO
        </option>
        required>
        <option value="PERKIM">
            PERKIM
        </option>
    </x-molecules.select2>

    {{-- LOCATION --}}
    <x-molecules.input class="col-12" label="Lokasi" name="location" type="text" placeholder="Lokasi Event" required />

    {{-- UPLOAD PDF --}}
    <x-molecules.dropzone required="true" label="File PDF" id="pdf_file" name="pdf_file"
        maxFiles="1" maxFilesSize="2" folderName="FilePDF"
        acceptedFiles=".pdf" />

    {{-- CK EDITOR --}}
    <x-molecules.ck-editor label="Deskripsi" id="event_editor" name="description" folderName="uploads" required>
        </x-molecules>
</x-molecules.modal>

@push('scripts')
    <script>
        $(document).ready(function() {
            var select2Config = {
                dropdownParent: $('#add-product-modal'),
            };

            $("#add_dinas").select2(select2Config);
        });
    </script>
@endpush
