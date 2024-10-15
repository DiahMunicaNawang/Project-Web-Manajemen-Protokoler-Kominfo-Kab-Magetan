function resetForm(selector, ckeditorId = null) {
    // 1. Reset the form fields using the built-in method
    const form = $(selector); // Wrap the selector with $() to ensure it's a jQuery object
    form[0].reset();

    // Uncheck all checkboxes
    form.find('input[type="checkbox"]').prop('checked', false);
    const activeRadio = form.find('input[name="status"][value="1"]');
    activeRadio.prop('checked', true);

    // 2. Reset CKEditor if ckeditorId is provided
    if (ckeditorId) {
        ckeditorId.setData('')
    }

    form.find('.fv-plugins-message-container').empty(); // Hide the error message
}

function populateForm(formSelector, response) {
    const form = $(formSelector);

    Object.keys(response).forEach(key => {
        const input = form.find(`[name="${key}"]`);

        if (input.is(':checkbox')) {
            // Handle checkboxes
            input.prop('checked', response[key]);
        } else if (input.is('select')) {
            // Handle select elements
            const select = input;
            const selectName = Array.isArray(response[key]) && response[key].length > 0 ?
                response[key][0].name :
                response[key];
            const option = select.find(`option[value="${selectName}"]`);
            if (option.length > 0) {
                option.prop('selected', true);
            }
        } else {
            // Handle other input types (text, password, etc.)
            input.val(response[key]);
        }
    });
}

/* 
--------------------------------------------------------------
| Enable & Disable Submit Button In Modal
--------------------------------------------------------------
*/
function enableSubmitButton(submitButton) {
    // Remove loading indication
    submitButton.removeAttribute('data-kt-indicator');
    // Enable button
    submitButton.disabled = false;
}

function disableSubmitButton(submitButton) {
    // Show loading indication
    submitButton.setAttribute('data-kt-indicator', 'on');
    // Disable button to avoid multiple clicks
    submitButton.disabled = true;
}