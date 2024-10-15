@props([
    'required' => false,
    'label',
    'id',
    'name',
    'maxFiles',
    'maxFilesSize',
    'folderName',
    'acceptedFiles',
    'value' => null,
    'uploadMultiple' => false,
])

<div class="fv-row mb-10">
    <label class="{{ $required ? 'required' : '' }} fw-semibold fs-6 mb-2">{{ $label }}</label>
    <div class="dropzone" id="{{ $id }}">
        <!--begin::Message-->
        <div class="dz-message needsclick">
            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                    class="path2"></span></i>

            <!--begin::Info-->
            <div class="ms-4">
                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Seret file di sini atau klik untuk mengunggah.</h3>
                <span class="fs-7 fw-semibold text-gray-500">Maksimal Unggahan {{ $maxFiles }} |</span>
                <span class="fs-7 fw-semibold text-gray-500">Ukuran Maksimal {{ $maxFilesSize }}Mb</span>
            </div>
            <!--end::Info-->
        </div>
    </div>
    <input type="hidden" id="uploaded_file_{{ $id }}" name="{{ $name }}">
</div>

@push('css')
    <style>
        .dz-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@push('plugins-scripts')
    <script>
        function parseJsonString(jsonString) {
            let parsedObject;
            try {
                let decodeString = decodeURIComponent(jsonString.replace(/&quot;/g, '"'));
                parsedObject = JSON.parse(decodeString);
            } catch (error) {
                return null;
            }

            // Normalize the path by replacing escaped forward slashes
            if (parsedObject.path) {
                parsedObject.path = parsedObject.path.replace(/\//g, '/');
            }

            return parsedObject;
        }

        var dropzone_{{ $id }} = '{{ $id }}';
        let hiddenInput_{{ $id }} = document.getElementById('uploaded_file_{{ $id }}');
        var existing = parseJsonString(@json($value));
        if (@json($value)) {
            hiddenInput_{{ $id }}.value = existing.path;
        }

        var myDropzone_{{ $id }} = new Dropzone("#" + dropzone_{{ $id }}, {
            url: "/media/upload/{{ $folderName }}/{{ $name }}", // Set the url for your upload script location
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            paramName: "files",
            maxFiles: {{ $maxFiles }},
            maxFilesize: {{ $maxFilesSize }},
            addRemoveLinks: true,
            acceptedFiles: "{{ $acceptedFiles }}",
            uploadMultiple: {{ $uploadMultiple ? 'true' : 'false' }},
            dictDefaultMessage: "Seret file di sini atau klik untuk mengunggah.",

            init: function() {
                // Display existing file if it exists
                if (existing && existing.path) {
                    populateDropzone(this, existing);
                    this.options.maxFiles = 1; // Disable further uploads
                }

                // Event listener for the success of file upload
                this.on("success", function(file, response) {
                    hiddenInput_{{ $id }}.value = response.path;
                    file.path = response.path; // Store the file ID
                });

                this.on("addedfile", function(file) {
                    var thumbnailPath = getThumbnailPath(file);
                    this.emit("thumbnail", file, thumbnailPath);
                });

                // Event listener for the remove file button
                this.on("removedfile", function(file) {
                    if (file.path) {
                        $.ajax({
                            url: '/media/delete',
                            method: 'DELETE',
                            data: {
                                "file_path": file.path,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(data) {
                                hiddenInput_{{ $id }}.value = null;
                                existingInput.value = null;
                            },
                            error: function(e) {}
                        });
                    }
                });
            }
        });

        myDropzone_{{ $id }}.autoDiscover = false;

        /**
         * Displays an existing file in the dropzone.
         *
         * @param {Object} dropzone - The dropzone object.
         * @param {Object} existing - The existing file object.
         */
        function populateDropzone(dropzone, file) {
            var mockFile = {
                name: file.name,
                size: file.size
            };

            dropzone.options.addedfile.call(dropzone, mockFile);

            thumbnail = getThumbnailPath(file);
            dropzone.options.thumbnail.call(dropzone, mockFile, thumbnail);

            mockFile.path = file.path; // Store the file ID
            dropzone.files.push(mockFile);
            dropzone.options.complete.call(dropzone, mockFile);
            hiddenInput_{{ $id }}.value = file.path;

            // Check if mockFile is not null
            if (mockFile !== null) {
                // Disable Dropzone
                dropzone.disable();
            }

            // Listen for file removed event
            dropzone.on("removedfile", function(removedFile) {
                // Check if the removed file is the mockFile
                if (removedFile === mockFile) {
                    // Enable Dropzone
                    dropzone.enable();
                }
            });
        }

        function getThumbnailPath(file) {
            var baseUrl = window.location.origin;
            var thumbnailPath;
            var fileType = file.name.split('.').pop().toLowerCase();

            switch (fileType) {
                case 'pdf':
                    thumbnailPath = baseUrl + '/assets/media/svg/files/pdf.svg';
                    break;
                case 'doc':
                case 'docx':
                    thumbnailPath = baseUrl + '/assets/media/svg/files/doc.svg';
                    break;
                case 'xls':
                case 'xlsx':
                    thumbnailPath = baseUrl + '/assets/media/svg/files/excel.svg';
                    break;
                case 'ppt':
                case 'pptx':
                    thumbnailPath = baseUrl + '/assets/media/svg/files/upload.svg';
                    break;
                default:
                    // For images, use the default thumbnail path
                    thumbnailPath = baseUrl + '/' + file.path;
            }

            return thumbnailPath;
        }

        function resetDropzoneUi(dropzoneId) {
            // Get the Dropzone instance
            var dropzone = document.getElementById(dropzoneId);
            if (dropzone) {
                var dropzoneInstance = Dropzone.forElement(dropzone);
                if (dropzoneInstance) {
                    // Remove the "removedfile" event listener temporarily
                    dropzoneInstance.off("removedfile");

                    // Clear all files from Dropzone instance
                    dropzoneInstance.removeAllFiles();

                    // Remove HTML elements associated with the files
                    $(dropzone).find(".dz-preview").remove();

                    // Re-attach the "removedfile" event listener
                    dropzoneInstance.on("removedfile", function(file) {
                        $.ajax({
                            url: '/media/delete',
                            method: 'DELETE',
                            data: {
                                "file_path": file.path,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(data) {
                                $(dropzone).find(".dz-preview").remove();
                                existingInput.value = null;
                                dropzoneInstance.enable(); // Re-enable the Dropzone
                            },
                            error: function(e) {}
                        });
                        // existingInput.value = null;
                    });
                }
            }
        }
    </script>
@endpush
