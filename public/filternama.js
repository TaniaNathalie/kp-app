function filterTable() {
    const input = document.getElementById('filterInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('table');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const cell = rows[i].getElementsByTagName('td')[5];
        console.log(cell);
        if (cell) {
            const textValue = cell.textContent || cell.innerText;
            if (textValue.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

// function resetTable() {
//     const table = document.getElementById('table');
//     const rows = table.getElementsByTagName('tr');
//     for (let i = 0; i < rows.length; i++) {
//         rows[i].style.display = '';
//     }
//     document.getElementById('filterInput').value = '';
//     document.getElementById('startDateFilter').value = '';
//     document.getElementById('endDateFilter').value = '';
// }

function resetTable() {
    // Menjalankan AJAX untuk mengambil data default dari controller
    $.ajax({
        url: '/get-count-approved-rejected', // Ganti dengan URL sesuai dengan proyek Laravel Anda
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Mengembalikan nilai jumlah approved dan rejected ke nilai semula
            document.getElementById('jlhApproved').innerText = "Total Approved: " + data.totalApproved;
            document.getElementById('jlhRejected').innerText = "Total Rejected: " + data.totalRejected;

            // Mengembalikan tampilan semua baris tabel
            const table = document.getElementById('table');
            const rows = table.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                rows[i].style.display = '';
            }

            // Mengosongkan input dan tanggal filter
            document.getElementById('filterInput').value = '';
            document.getElementById('startDateFilter').value = '';
            document.getElementById('endDateFilter').value = '';
        },
        error: function (error) {
            console.error('Gagal mengambil data dari controller:', error);
        }
    });
}

