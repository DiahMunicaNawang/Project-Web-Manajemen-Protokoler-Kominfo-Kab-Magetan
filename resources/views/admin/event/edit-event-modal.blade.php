<x-molecules.modal id="edit-product-modal" title="Update Event" type="edit" formId="edit-product-form" formMethod="POST"
    confirmButton="Simpan" buttonId="edit-button">

    {{-- NAME --}}
    <x-molecules.input class="col-12" label="Nama" name="name" id="edit_" type="text" placeholder="Acara" required />

    {{-- START DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Mulai" id="edit_start_date" name="start_date" type="datetime-local"
        required />

    {{-- END DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Selesai" id="edit_end_date" name="end_date" type="datetime-local" required/>

    {{-- DINAS --}}
    <x-molecules.select2 id="edit_dinas" label="Pelaksana" name="dinas"
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
    <x-molecules.dropzone required="true" label="File PDF" id="edit_pdf_file" name="pdf_file"
        maxFiles="1" maxFilesSize="2" folderName="FilePDF"
        acceptedFiles=".pdf" />

    {{-- CK EDITOR --}}
    <x-molecules.ck-editor label="Deskripsi" id="edit_event_editor" name="description" folderName="uploads" required>
        </x-molecules>

    @if (auth()->user()->hasRole('super-admin'))
        {{-- STATUS --}}
        <label class="fw-semibold fs-6 mb-2" for="checkbox-container">Tampilkan ke Publik</label>
        <div class="d-flex align-items-center">
            <label class="form-check-label me-2" for="edit_flexSwitchCheckChecked">Tidak</label>
            
            <div class="form-check form-switch">
                <input name="status" class="form-check-input" type="checkbox" id="edit_flexSwitchCheckChecked">

            </div>
            
            <label class="form-check-label ms-2" for="edit_flexSwitchCheckChecked">Ya</label>
        </div>
    @endif
</x-molecules.modal>

@push('scripts')
    <script>
        $(document).ready(function() {
            var select2Config = {
                dropdownParent: $('#edit-product-modal'),
            };

            $("#edit_dinas").select2(select2Config);
        });
    </script>
@endpush