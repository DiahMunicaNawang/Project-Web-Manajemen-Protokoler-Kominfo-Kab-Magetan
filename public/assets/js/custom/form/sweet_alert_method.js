function showAlert(type, message, customIcon) {
    let iconClass = "";
    let confirmButtonClass = "";

    switch (type) {
        case "success":
            iconClass = "success";
            confirmButtonClass = "btn btn-success";
            break;
        case "info":
            iconClass = "info";
            confirmButtonClass = "btn btn-info";
            break;
        case "warning":
            iconClass = "warning";
            confirmButtonClass = "btn btn-warning";
            break;
        case "error":
            iconClass = "error";
            confirmButtonClass = "btn btn-danger";
            break;
        case "question":
            iconClass = "question";
            confirmButtonClass = "btn btn-primary";
            break;
        default:
            iconClass = "info";
            confirmButtonClass = "btn btn-info";
            break;
    }

    let iconHtml;
    if (customIcon) {
        iconHtml =
            '<img src="' +
            customIcon +
            '" class="h-150px" alt="Custom Icon" />';

        return Swal.fire({
            text: message,
            iconHtml: iconHtml,
            showCancelButton: false,
            buttonsStyling: false,
            confirmButtonText: "Oke, Mengerti",
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        });
    } else {
        return Swal.fire({
            text: message,
            icon: iconClass,
            showCancelButton: false,
            buttonsStyling: false,
            confirmButtonText: "Oke, Mengerti",
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        });
    }
}

/* 
--------------------------------------------------------------
| Confirmation Alert, type = add, update, delete, finish
--------------------------------------------------------------
*/
function confirmAction(type, username, message = null, customIcon) {
    let confirmButtonText;
    let confirmButtonClass;
    let iconClass = "";
    let text;

    switch (type) {
        case "add":
            confirmButtonText = "Ya, tambah!";
            confirmButtonClass = "btn fw-bold btn-success";
            text = "Apakah Anda yakin ingin menambah " + username + "?";
            iconClass = "question";
            break;
        case "update":
            confirmButtonText = "Simpan Perubahan!";
            confirmButtonClass = "btn fw-bold btn-primary";
            text =
                "Apakah Anda yakin ingin menutup? Perubahan yang dilakukan ke " +
                username +
                " tidak akan disimpan.";
            iconClass = "info";
            break;
        case "finish":
            confirmButtonText = "Selesaikan Ujian";
            confirmButtonClass = "btn fw-bold btn-info";
            text =
                "Apakah Anda yakin ingin menyelesaikan Ujian Akhir " +
                username +
                "?";
            iconClass = "question";
            break;
        case "warning":
            confirmButtonText = "Ya, Kumpulkan";
            confirmButtonClass = "btn fw-bold btn-warning";
            text = "Ada Pertanyaan yang belum terjawab, Yakin Kumpulkan?";
            iconClass = "warning";
            break;
        case "delete":
            confirmButtonText = "Ya, hapus!";
            confirmButtonClass = "btn fw-bold btn-danger";
            text = "Apakah Anda yakin ingin menghapus " + username + "?";
            iconClass = "warning";
            break;
        default:
            throw new Error("Invalid action type");
    }

    if (message) {
        text = message;
    }

    let iconHtml; // Declare iconHtml variable
    if (customIcon) {
        iconHtml =
            '<img src="' +
            customIcon +
            '" class="h-150px" alt="Custom Icon" />';

        return Swal.fire({
            text: text,
            iconHtml: iconHtml,
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: confirmButtonText,
            cancelButtonText: "Tidak",
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        });
    } else {
        return Swal.fire({
            text: text,
            icon: iconClass,
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: confirmButtonText,
            cancelButtonText: "Tidak",
            customClass: {
                confirmButton: confirmButtonClass,
                cancelButton: "btn fw-bold btn-active-light-primary",
            },
        });
    }
}

/* 
--------------------------------------------------------------
| Delete Singgle Or Multiple Data For Crud
--------------------------------------------------------------
*/
function deleteData(datatable, featureName, url) {
    $.ajax({
        type: "DELETE",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (response) {
            if (response.meta.code == 200) {
                datatable.rows(".selected").remove().draw(false);

                let successMsg = response.meta.message.body;
                showAlert("success", successMsg);
                datatable.draw();
            }
        },
        error: function (xhr, textStatus, errorMessage) {
            enableSubmitButton(submitButton);
            var response = JSON.parse(xhr.responseText);
            var message = response.meta.message.body;
            showAlert("error", message);
        },
    });
}

function multipleDelete(table, datatable, url, featureName, message = null) {
    // Select all checkboxes
    const container = document.querySelector(table);
    const deleteSelected = document.querySelector(
        '[data-kt-docs-table-select="delete_selected"]'
    );
    const headerCheckbox = document.getElementById("header-checkbox");

    // Checkbox on click event
    const toolbarBase = document.querySelector(
        '[data-kt-docs-table-toolbar="base"]'
    );
    const toolbarSelected = document.querySelector(
        '[data-kt-docs-table-toolbar="selected"]'
    );
    const selectedCount = document.querySelector(
        '[data-kt-docs-table-select="selected_count"]'
    );
    container.addEventListener("click", function (e) {
        if (e.target.type === "checkbox") {
            setTimeout(function () {
                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll(
                    'tbody [type="checkbox"]'
                );
                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach((c) => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Check if all checkboxes are checked
                let allChecked = Array.from(allCheckboxes).every(
                    (c) => c.checked
                );
                // If not all checkboxes are checked, uncheck the "select all" checkbox
                if (allChecked == false) {
                    headerCheckbox.checked = false;
                }

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add("d-none");
                    toolbarSelected.classList.remove("d-none");
                } else {
                    toolbarBase.classList.remove("d-none");
                    toolbarSelected.classList.add("d-none");
                }
            }, 50);
        }
    });

    // ---------------------------------------------
    // Declare Ajax request this will be called using
    // the confirmSelectedDelete function
    // ---------------------------------------------
    function handleSelectedDelete(selectedIds, datatable, featureName) {
        // Make AJAX request to delete selected users
        $.ajax({
            url: url + selectedIds.join(","),
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                showAlert(
                    "success",
                    "Berhasil menghapus " + featureName + " yang dipilih!"
                );

                datatable.rows(".selected").remove().draw(false);

                // Remove header checked box
                headerCheckbox.checked = false;
                toolbarBase.classList.remove("d-none");
                toolbarSelected.classList.add("d-none");
            },
            error: function (xhr, textStatus, errorMessage) {
                var response = JSON.parse(xhr.responseText);
                var message = response.data;
                showAlert("error", message);
            },
        });
    }

    // ---------------------------------------------
    // Perform the request to delete selected users
    // ---------------------------------------------
    deleteSelected.addEventListener("click", function () {
        // Get all selected user ids
        const selectedIds = $("#select-all-checkbox:checked")
            .map(function () {
                return $(this).data("selected-ids");
            })
            .get();

        if (selectedIds.length === 0) {
            showAlert("warning", "Please select at least one user to delete!");
            return;
        }

        confirmAction("delete", featureName, message).then(function (isValid) {
            if (isValid.value) {
                handleSelectedDelete(
                    selectedIds,
                    datatable,
                    featureName,
                    message
                );
            }
        });
    });
}
