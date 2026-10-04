<style>
    .excel-table-export-toolbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: .5rem;
    }
</style>
<script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tables = Array.from(document.querySelectorAll('table')).filter((table) =>
            !table.closest('[data-no-excel-export]')
        );

        tables.forEach((table, index) => {
            if (table.id && document.querySelector(
                `[data-excel-export-for="${CSS.escape(table.id)}"]`)) {
                return;
            }

            const toolbar = document.createElement('div');
            toolbar.className = 'excel-table-export-toolbar';
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-sm btn-outline-success';
            button.innerHTML =
                '<i class="fas fa-file-excel me-1" aria-hidden="true"></i> Exporter Excel';
            button.setAttribute('aria-label', 'Exporter ce tableau vers Excel');
            toolbar.append(button);

            const host = table.closest('.table-responsive, .table-wrapper') || table.parentElement;
            host.parentNode.insertBefore(toolbar, host);

            button.addEventListener('click', function() {
                if (!window.XLSX?.utils || !window.XLSX?.writeFile) {
                    alert('Export impossible : le module Excel est indisponible.');
                    return;
                }

                const exportTable = table.cloneNode(true);
                exportTable.querySelectorAll('tbody tr').forEach((row) => {
                    if (row.hidden || row.style.display === 'none' || row.querySelector(
                            '.empty-state') ||
                        row.hasAttribute('data-empty-row')) {
                        row.remove();
                    }
                });

                const headerRow = exportTable.querySelector('thead tr:last-child');
                const excludedColumns = [];
                if (headerRow) {
                    Array.from(headerRow.children).forEach((cell, columnIndex) => {
                        const label = cell.textContent.trim().toLocaleLowerCase();
                        if (cell.querySelector('input[type="checkbox"]') || ['action',
                                'actions'
                            ].includes(label)) {
                            excludedColumns.push(columnIndex);
                        }
                    });
                }
                exportTable.querySelectorAll('tr').forEach((row) => {
                    excludedColumns.slice().reverse().forEach((columnIndex) => row
                        .children[columnIndex]?.remove());
                });

                if (!exportTable.querySelector('tbody tr')) {
                    alert('Aucune ligne à exporter.');
                    return;
                }

                const workbook = XLSX.utils.table_to_book(exportTable, {
                    sheet: 'Données'
                });
                const sourceName = (table.id || document.title || `tableau_${index + 1}`)
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-zA-Z0-9_-]+/g, '_').replace(/^_|_$/g, '') ||
                    `tableau_${index + 1}`;
                const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
                XLSX.writeFile(workbook, `${sourceName}_${timestamp}.xlsx`);
            });
        });
    });
</script>
