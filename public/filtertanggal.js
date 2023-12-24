const filterButton = document.getElementById("filterButton");
const startDateFilter = document.getElementById("startDateFilter");
const endDateFilter = document.getElementById("endDateFilter");
const table = document.getElementById("table");
const approved = document.getElementById("jlhApproved");
const rejected = document.getElementById("jlhRejected");

let originalTableHTML = table.innerHTML;

filterButton.addEventListener("click", function () {
    const startDateValue = startDateFilter.value;
    const endDateValue = endDateFilter.value;

    // Ambil nilai tanggal dari input
    var startDate = document.getElementById('startDateFilter').value;
    var endDate = document.getElementById('endDateFilter').value;

    // Kirim request AJAX ke backend (contoh menggunakan jQuery)
    $.ajax({
        url: '/get-data-from-dbb', // Ganti dengan URL yang sesuai
        method: 'GET',
        data: { startDate: startDate, endDate: endDate },
        success: function (response) {
            // Update nilai total approved dan rejected di HTML
            document.getElementById('jlhApproved').innerText = "Total Approved: " + response.jlhApproved;
            document.getElementById('jlhRejected').innerText = "Total Rejected: " + response.jlhRejected;
        },
        error: function () {
            console.log('Gagal mengambil data dari database');
        }
    });

    // Kembalikan data tabel ke kondisi awal jika kedua kotak filter kosong
    if (startDateValue === "" && endDateValue === "") {
        table.innerHTML = originalTableHTML;
        return;
    }

    // Filter data berdasarkan rentang tanggal
    const rows = table.getElementsByTagName("tr");
    for (let i = 1; i < rows.length; i++) {
        const tanggal = rows[i].getElementsByTagName("td")[1].textContent;
        var hasilSplit = tanggal.split(", ");
        var parts = hasilSplit[1].split(" "); // Memisahkan tanggal menjadi array

        //cek tanggal
        var tgl = "";
        if (parts[0].length === 1) {
            tgl = "0" + parts[0];
        } else {
            tgl = parts[0];
        }

        var bulan = parts[1]; // Mengambil nama bulan
        var tahun = parts[2]; // Mengambil tahun

        // Objek untuk mengonversi nama bulan menjadi angka bulan
        var daftarBulan = {
            "Januari": "01",
            "Februari": "02",
            "Maret": "03",
            "April": "04",
            "Mei": "05",
            "Juni": "06",
            "Juli": "07",
            "Agustus": "08",
            "September": "09",
            "Oktober": "10",
            "November": "11",
            "Desember": "12"
        };

        var angkaBulan = daftarBulan[bulan]; // Mendapatkan angka bulan

        var tanggalBaru = tahun + "-" + angkaBulan + "-" + tgl;

        // Cek apakah tanggal berada dalam rentang yang diinginkan
        if ((startDateValue === "" || tanggalBaru >= startDateValue) &&
            (endDateValue === "" || tanggalBaru <= endDateValue)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});
