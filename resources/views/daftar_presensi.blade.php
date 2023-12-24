<?php
Use Carbon\Carbon;
Use Jenssegers\Date\Date;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->

    <title>Presensi Satunama</title>
    <!-- Bootstrap Core CSS -->
    <link href=" {{ asset('style/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{ asset('style/assets/plugins/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style/assets/plugins/chartist-js/dist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('style/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="{{ asset('style/assets/plugins/c3-master/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('style/lite/css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('style/lite/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    [if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-toggleable-sm navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <img style="height: 50px; weight: 50px;" src="Logo_SN_Text.png" alt="logo">
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="/" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/daftar_presensi" aria-expanded="false"><i class="mdi mdi-calendar-check"></i><span class="hide-menu">Daftar Presensi</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="/karyawan" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Karyawan</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->

        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Daftar Presensi</h3>
                        <span id="jlhApproved">Total Approved : {{ $jlhApproved }}</span>
                        <span id="jlhRejected" style="margin-left: 50px;">Total Rejected : {{ $jlhRejected }}</span>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-block">
                                <!-- <h4 class="card-title">Basic Table</h4> -->
                                <div class="filterTanggal">
                                    <input type="date" name="start" id="startDateFilter">
                                    <input type="date" name="end" id="endDateFilter">
                                    <button id="filterButton">Filter</button>
                                    <button onclick="resetTable()">Reset</button>
                                </div>
                                <div class="filterNama">
                                    <input type="text" id="filterInput" placeholder="Cari berdasarkan nama">
                                    <button onclick="filterTable()">Cari</button>
                                    <button onclick="resetTable()">Reset</button>
                                </div>
                            
                                <div class="table-responsive">
                                <form action="{{ route('approve-all') }}" method="get" id="approveForm">
                                    @csrf
                                    <br>
                                    <button type="submit" class="btn btn-info">Approve All</button>
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"/></th>
                                                <th>Hari/Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Kalkulasi</th>
                                                <th>Nama</th>
                                                <th>Lokasi</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hrds as $hrd)
                                            <?php
                                                set_time_limit(120); // Mengatur batas waktu eksekusi menjadi 120 detik (2 menit)

                                                Date::setLocale('id');
                                            
                                                $timestampPresensiMasuk = explode(' ', $hrd->presensi_masuk ?? '0');
                                                $timestampPresensiKeluar = explode(' ', $hrd->presensi_keluar ?? '0');
                                                $carbonDate = Carbon::parse($hrd->presensi_masuk)->format('l');
                                                $ubah = Date::parse($timestampPresensiMasuk[0]);
                                                $namaHariIndonesia = $ubah->format('l, j F Y');

                                                $lat = $hrd->latitude;  
                                                $long = $hrd->longtitude; 
                                                $apiKey = '48a4c96be8b1404d86b8a16241f204cc';
                                                $url = "https://api.opencagedata.com/geocode/v1/json?q={$lat},{$long}&key={$apiKey}";
                                                
                                                $response = file_get_contents($url);
                                                $data = json_decode($response);

                                                if ($data->status->code === 200) {
                                                // Mendapatkan alamat dari hasil geocoding

                                                $address = $data->results[0]->formatted;
                                                $namaKota = explode(',', $address);
                                                // echo "Alamat: " . $address;
                                                } 

                                                // Waktu awal
                                                $waktuAwal = Carbon::parse($timestampPresensiMasuk[1] ?? '0:0:0'); // Gantilah ini dengan waktu awal yang sesuai
                                                // Waktu akhir
                                                $waktuAkhir = Carbon::parse($timestampPresensiKeluar[1] ?? '0:0:0'); // Gantilah ini dengan waktu akhir yang sesuai
                                                // Menghitung selisih waktu
                                                if ($waktuAwal->format('H:i:s') === "00:00:00" || $waktuAkhir->format('H:i:s') === "00:00:00") {
                                                    $selisih = 0; // Atau nilai yang sesuai dengan kebutuhan Anda
                                                } else {
                                                    // Menghitung selisih waktu
                                                    $selisih = $waktuAwal->diff($waktuAkhir);
                                                }
                                               
                                                // dd($selisih)
                                                
                                            ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected[]" value="{{ $hrd->id_presensi }}" class="selectCheckbox">
                                                    </td>
                                                    <td>{{ $namaHariIndonesia ?? '-'}}</td>
                                                    <td>{{ $timestampPresensiMasuk[1] ?? '-' }}</td>
                                                    <td>{{ $timestampPresensiKeluar[1] ?? '-'}}</td>
                                                    <td style="color: <?php echo is_object($selisih) && $selisih->h > 8 ? 'red' : '#cc9900'; ?>">
                                                        {{$selisih ? $selisih->format('%H:%I:%S') : '00:00:00'}}
                                                    </td>
                                                    <td>{{$hrd->nama_karyawan ?? '-'}}</td>
                                                    <td>{{$address ?? '-'}}</td>
                                                    <td>
                                                        <!-- <form method="post" action="/simpan-data">
                                                        @csrf
                                                        <select name="status" id="status">
                                                            <option value="approved">Approved</option>
                                                            <option value="rejected">Rejected</option>
                                                        </select>
                                                        </form> -->
                                                        <a href="daftar_presensi/{{ $hrd->id_presensi }}" class="btn btn-sm btn-{{ $hrd->id_approval ? 'success' : 'danger'}}">
                                                            {{ $hrd->id_approval ? 'Approved' : 'Rejected' }} 
                                                        </a>

                                                    </td>
                                                    <td>
                                                        <button class="btn btn-themecolor mdi mdi-alert-circle-outline tampilkanPopup" data-popup-id="{{$hrd->id_presensi}}"></button>
                                                        <div id="overlay{{$hrd->id_presensi}}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>
                                                        <div id="popup{{$hrd->id_presensi}}" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 2; border-radius:8px;">
                                                            <img src="data:image/png;base64,{{$hrd->url_gambar}}" alt="Image">
                                                            <p>{{ $hrd->deskripsi_kegiatan ?? '-'}}</p>
                                                            <button class="tutupPopup" data-popup-id="{{$hrd->id_presensi}}">Tutup</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src=" {{ asset('style/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('style/assets/plugins/bootstrap/js/tether.min.js') }}"></script>
    <script src="{{ asset('style/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('style/lite/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('style/lite/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('style/lite/js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('style/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('style/lite/js/custom.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="{{ asset('style/assets/plugins/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('style/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 JavaScript -->
    <script src="{{ asset('style/assets/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('style/assets/plugins/c3-master/c3.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('style/lite/js/dashboard1.js') }}"></script>

    <script src="filterTanggal.js"></script>
    <script src="filternama.js"></script>

<script>
    // Fungsi untuk menampilkan pop-up
    function tampilkanPopUp(id) {
        const overlay = document.getElementById('overlay' + id);
        const popup = document.getElementById('popup' + id);

        overlay.style.display = 'block';
        popup.style.display = 'block';
    }

    // Fungsi untuk menutup pop-up
    function tutupPopUp(id) {
        const overlay = document.getElementById('overlay' + id);
        const popup = document.getElementById('popup' + id);

        overlay.style.display = 'none';
        popup.style.display = 'none';
    }

    // Dapatkan semua tombol dengan class "tampilkanPopup"
    const tombolTampilkanPopup = document.querySelectorAll('.tampilkanPopup');

    // Tambahkan event listener ke setiap tombol "tampilkanPopup"
    tombolTampilkanPopup.forEach(function(tombol) {
        tombol.addEventListener('click', function() {
            // Dapatkan id yang sesuai dengan data masing-masing pop-up
            const id = tombol.getAttribute('data-popup-id');
            tampilkanPopUp(id);
        });
    });

    // Dapatkan semua tombol-tutup dengan class "tutupPopup"
    const tombolTutupPopup = document.querySelectorAll('.tutupPopup');

    // Tambahkan event listener ke setiap tombol "tutupPopup"
    tombolTutupPopup.forEach(function(tombol) {
        tombol.addEventListener('click', function() {
            // Dapatkan id yang sesuai dengan data masing-masing pop-up
            const id = tombol.getAttribute('data-popup-id');
            tutupPopUp(id);
        });
    });
</script>

<!--UNTUK APPROVED ALL-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.selectCheckbox');

        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    });
</script>



</body>

</html>
