function handleFilterDatatable(dt, filter, filterButton) {
    // Filter datatable on submit
    filterButton.addEventListener('click', function() {
        // Get filter values
        let filterValue = '';

        // Get selected filter value
        filter.forEach(f => {
            if (f.checked) {
                filterValue = f.value;
            }
        });

        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
        dt.search(filterValue).draw();
    });
}

function handleResetFilter(dt, filter, resetButton) {
    resetButton.addEventListener('click', function() {
        // Reset filter options
        filter.forEach(f => {
            f.checked = false;
        });

        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
        dt.search('').draw();
    });
}

function handleSearchDatatable(datatable) {
    const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
    let timeoutId;

    filterSearch.addEventListener('keyup', function(e) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            datatable.search(e.target.value).draw();
        }, 1000);
    });
}

function exportButtons(table, tableId, exportName) {
    const documentTitle = exportName;

    new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: "copyHtml5",
                title: documentTitle,
                exportOptions: {
                    columns: ":visible:not(:nth-child(1))", // Exclude the first and the last column
                },
            },
            {
                extend: "excelHtml5",
                title: documentTitle,
                exportOptions: {
                    columns: ":visible:not(:nth-child(2))", // Exclude the first and the last column
                },
                action: function (e, dt, button, config) {
                    if (dt.rows({ search: 'applied' }).data().length === 0) {
                        showAlert('info', 'Tidak ada data untuk di export');
                        return;
                    }
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                }
            },
            {
                extend: "csvHtml5",
                title: documentTitle,
                exportOptions: {
                    columns: ":visible:not(:nth-child(2))", // Exclude the first and the last column
                },
                action: function (e, dt, button, config) {
                    if (dt.rows({ search: 'applied' }).data().length === 0) {
                        showAlert('info', 'Tidak ada data untuk di export');
                        return;
                    }
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                },
            },
            {
                extend: "pdfHtml5",
                title: documentTitle,
                exportOptions: {
                    columns: ":visible:not(:nth-child(2))", // Exclude the first and the last column
                },
                customize: function (doc) {
                    if (doc.content[1].table.body.length === 1) {
                        doc.content[1].table.body.push([{ text: 'data tidak ada', colSpan: doc.content[1].table.body[0].length, alignment: 'center' }]);
                    }
                }
            },
        ],
    })
        .container()
        .appendTo($(tableId));

    // Hook dropdown menu click event to datatable export buttons
    const exportButtons = document.querySelectorAll(
        "#kt_datatable_example_export_menu [data-kt-export]"
    );
    exportButtons.forEach((exportButton) => {
        exportButton.addEventListener("click", (e) => {
            e.preventDefault();

            // Get clicked export value
            const exportValue = e.target.getAttribute("data-kt-export");
            const target = document.querySelector(
                ".dt-buttons .buttons-" + exportValue
            );

            // Trigger click event on hidden datatable export buttons
            target.click();
        });
    });
}