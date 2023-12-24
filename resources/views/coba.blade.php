<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<label for="startDate">Start Date:</label>
<input type="date" id="startDate">

<label for="endDate">End Date:</label>
<input type="date" id="endDate">

<button id="filterButton">Filter</button>

<div id="result">
    <p>Total Approved: <span id="totalApproved">0</span></p>
    <p>Total Rejected: <span id="totalRejected">0</span></p>
</div>


</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.getElementById('filterButton').addEventListener('click', function () {
        // Ambil nilai tanggal dari input
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        // Kirim request AJAX ke backend (contoh menggunakan jQuery)
        $.ajax({
            url: '/get-data-from-dbb', // Ganti dengan URL yang sesuai
            method: 'GET',
            data: { startDate: startDate, endDate: endDate },
            success: function (response) {
                // Update nilai total approved dan rejected di HTML
                document.getElementById('totalApproved').innerText = response.totalApproved;
                document.getElementById('totalRejected').innerText = response.totalRejected;
            },
            error: function () {
                console.log('Gagal mengambil data dari database');
            }
        });
    });
</script>

</html>