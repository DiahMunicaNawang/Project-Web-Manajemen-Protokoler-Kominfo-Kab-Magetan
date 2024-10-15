@props(['suggestion' => null])
<!--begin::Main wrapper-->
<div id="kt_docs_search_handler_basic" class="col-12" data-kt-search-keypress="true" data-kt-search-min-length="2"
    data-kt-search-enter="true" data-kt-search-layout="inline">

    <!--begin::Input Form-->
    <form data-kt-search-element="form" class="w-100 d-flex align-items-center position-relative my-1" autocomplete="off">
        <!--begin::Hidden input(Added to disable form autocomplete)-->
        <input type="hidden" />
        <!--end::Hidden input-->

        <!--begin::Icon-->
        <!--begin::Input-->
        <input type="text"
            class="form-control form-control-lg form-control-solid px-15 w-100"
            name="search" value="" placeholder="Cari..." data-kt-search-element="input" />
        <!--end::Input-->

        <!--begin::Icon-->
        <button type="submit" class="btn position-absolute end-0 me-6 p-2">
            <i class="fas fa-search"></i>
        </button>
        <!--end::Icon-->

        <!--begin::Spinner-->
        <span class="position-absolute top-50 ms-6 translate-middle-y lh-0 d-none me-5 spinner"
            data-kt-search-element="spinner">
            <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
        </span>
        <!--end::Spinner-->

        <!--begin::Reset-->
        <span
            class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none"
            data-kt-search-element="clear">

            <!--begin::Svg Icon | path: cross-->
        </span>
        <!--end::Reset-->
    </form>
    <!--end::Form-->

    <!--begin::Wrapper-->
    <div class="py-5 position-relative">
        <!--being::Search suggestion-->
        <div data-kt-search-element="suggestions"
            class="card position-absolute col-12 scroll d-none suggestion-container py-5"
            style="max-height: 300px; z-index: 99;">
        </div>
        <!--end::Suggestion wrapper-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Main wrapper-->

@push('scripts')
    <script>
        let typingTimer; // Timer identifier
        const spinnerElement = $('.spinner');
        const doneTypingInterval = 300; // Time in milliseconds (100ms)
        $(document).on('click', function(e) {
            if ($(e.target).closest('.suggestion-container').length === 0) {
                $('.suggestion-container').addClass('d-none');
            }
        });

        // Input handler
        const handleInput = () => {
            const inputField = element.querySelector("[data-kt-search-element='input']");

            inputField.addEventListener('keyup', (event) => {
                // Clear the timeout if it has already been set.
                clearTimeout(typingTimer);

                // If the input field is empty, hide the spinner and suggestions
                if (inputField.value.trim() === '') {
                    suggestionsElement.innerHTML = '';
                    spinnerElement.addClass('d-none');
                }

                // Start a new timer to wait for user to stop typing
                typingTimer = setTimeout(sendRequest, doneTypingInterval);

                // If the user presses the enter key, redirect to the /catalogue page with the search term as a query parameter
                if (event.key === 'Enter') {
                    window.location.href = '/catalogue?search=' + inputField.value.trim();
                }
            });
        };

        // Function to send request
        const sendRequest = () => {
            const searchTerm = element.querySelector("[data-kt-search-element='input']").value.trim();

            if (searchTerm.length >= 1) {
                // Make AJAX request to server with search term
                fetch('/catalogue/suggestion?search=' + searchTerm)
                    .then(response => response.json())
                    .then(data => {
                        spinnerElement.addClass('d-none');

                        $('.suggestion-container').removeClass('d-none');

                        // Clear current suggestions
                        suggestionsElement.innerHTML = '';
                        // Check if data is empty
                        if (data.length === 0) {
                            suggestionsElement.innerHTML = `
                                <div data-kt-search-element="empty" class="card-body text-center postition-absolute">
                                        <!--begin::Icon-->
                                        <div class="pb-5">
                                            <img loading="lazy" src="{{ asset('assets/media/illustrations/sigma-1/21.png') }}" class="h-200px"
                                                alt="Empty Illustration" />
                                        </div>
                                        <!--end::Icon-->

                                        <!--begin::Message-->
                                        <div class="pb-15 fw-semibold">
                                            <h3 class="text-gray-600 fs-5 mb-2">Data Tidak Ditemukan</h3>
                                        </div>
                                        <!--end::Message-->
                                </div>
                            `;
                        } else {
                            // Populate suggestions with data from server
                            data.forEach(item => {
                                const suggestionHTML = `
                                        <div class="d-flex align-items-center ms-6 my-2">
                                            <i class="ki-duotone ki-magnifier fs-3">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                            <span>
                                                <a href="/classes/details/${item.id}?page=catalogue" class="col-8 fs-4 ms-3 text-gray-800 text-hover-primary fw-semibold text-capitalize">${item.name}</a>
                                            </span>
                                        </div>
                                    `;
                                suggestionsElement.innerHTML += suggestionHTML;
                            });
                        }
                    });
            } else {
                $('.suggestion-container').addClass('d-none');
            }
        };

        // Elements
        element = document.querySelector('#kt_docs_search_handler_basic');
        wrapperElement = element.querySelector("[data-kt-search-element='wrapper']");
        suggestionsElement = element.querySelector("[data-kt-search-element='suggestions']");
        resultsElement = element.querySelector("[data-kt-search-element='results']");
        emptyElement = element.querySelector("[data-kt-search-element='empty']");

        // Initialize search handler
        searchObject = new KTSearch(element);

        // Handle input enter keypress
        handleInput();
    </script>
@endpush
