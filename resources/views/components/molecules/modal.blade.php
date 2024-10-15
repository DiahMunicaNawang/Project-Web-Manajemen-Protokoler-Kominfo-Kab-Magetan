@props([
    'id' => '',
    'title' => '',
    'type' => '',
    'formId' => '',
    'formAction' => '',
    'formMethod' => '',
    'confirmButton' => '',
    'buttonId' => '',
    'closeButtonId' => 'close-button', // Add closeButtonId prop with default value
])

<div class="modal fade" tabindex="-1" id="{{ $id }}" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable mw-750px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
            </div>
            <div class="modal-body">
                <form id="{{ $formId }}" class="form" action="{{ $formAction }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    {{ $slot }}
                </form>
            </div>
            
            @if ($type === 'add')
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="close-button"
                        data-bs-dismiss="modal"><Table>Tutup</Table></button>
                    <button id="{{ $buttonId }}" type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            {{ $confirmButton }}
                        </span>
                        <span class="indicator-progress">
                            Loading... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            @elseif($type === 'center')
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" id="close-filter-button"
                        data-bs-dismiss="modal">Tutup</button>
                    <button id="{{ $buttonId }}" type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            {{ $confirmButton }}
                        </span>
                        <span class="indicator-progress">
                            Loading... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            @else
                <div class="modal-footer flex-start">
                    <button id="{{ $buttonId }}" type="submit" class="btn btn-info">
                        <span class="indicator-label">
                            {{ $confirmButton }}
                        </span>
                        <span class="indicator-progress">
                            Loading... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <button type="reset" class="btn btn-light" id="edit-close-button"
                        data-bs-dismiss="modal">Tutup</button>
                </div>
            @endif
        </div>
    </div>
</div>
