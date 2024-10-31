<x-molecules.modal id="filter-event-modal" title="Filter" type="center" formId="filter-event-form" formMethod="GET"
    confirmButton="Apply" buttonId="filter-event-button">

    {{-- NAME --}}
    <x-molecules.input class="col-12" label="Nama" name="name" type="text" placeholder="Acara" />

    {{-- START DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Mulai" id="start_date" name="start_date" type="date"
        />

    {{-- END DATE --}}
    <x-molecules.input class="col-12" label="Tanggal Selesai" id="end_date" name="end_date" type="date"/>

    {{-- DINAS --}}
    <x-molecules.select2 id="filter_dinas" label="Pelaksana" name="dinas"
       >
        <option value="HR">
            HR
        </option>
        <option value="KOMINFO">
            KOMINFO
        </option>
        <option value="PERKIM">
            PERKIM
        </option>
    </x-molecules.select2>
</x-molecules.modal>

@push('scripts')
    <script>
        $(document).ready(function() {
            var select2Config = {
                dropdownParent: $('#filter-event-modal'),
            };

            $("#filter_dinas").select2(select2Config);
        });
    </script>
@endpush