<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
  header("location:login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 
  <title>BUKU TAMU</title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <!-- CSS Files -->
  <link id="pagestyle" href="assetss/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome untuk ikon -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="icon" href="img/booktamu.png" type="jpg">
  <style>
    /* Custom CSS untuk efek hover pada tabel */
    .table-hover tbody tr:hover {
      background-color: #f8f9fa;
      /* Warna latar saat hover */
    }

    .navbar-main {
      background: linear-gradient(90deg, #4e73df, #224abe);
      /* Gradient untuk navbar */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* Bayangan navbar */
    }

    .card {
      border: none;
      /* Hilangkan border card */
      border-radius: 10px;
      /* Sudut melengkung */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* Bayangan card */
    }

    .submenu-animated {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.8s ease;
      /* lebih lambat */
    }

    .submenu-animated.show {
      max-height: 600px;
      /* sesuaikan agar cukup untuk semua isi */
    }

    .rotate {
      transform: rotate(180deg);
    }

    #masterToggleBtn.active-toggle {
      background-color: #4ca9d8 !important;
      transition: background-color 0.3s;
    }
  </style>
</head>

<body class="bg-dark">
  

  <aside class="bg-dark sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3"
    id="sidenav-main">

    <div class="sidenav-header d-flex justify-content-center align-items-center">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>


      <!-- Side Bar -->
      <span class=" font-weight-bold text-white">BUKU TAMU</span>
      <!-- Logo Image -->

    </div>

    </div>
    <hr class="horizontal dark mt-0" />
    <div class="d-flex align-items-center justify-content-center"><img src="img/booktamu.png" alt="Logo"
        class="logo-image" style="width: 50px; height: auto; margin-top: 10px;" /></div>
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main ">

      <ul class="navbar-nav mt-10">
        <li class="nav-item ">
          <a class="nav-link active text-white" style="background-color: #62b8e1;" href="index.php">

            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white" style="background-color: #62b8e1;" href="?dashboard=user">

            <span class="nav-link-text ms-1">ADMIN</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white" style="background-color: #62b8e1;" href="?dashboard=tamu">
            <span class="nav-link-text ms-1">TAMU</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white" style="background-color: #62b8e1;" href="?dashboard=rekap">

            <span class="nav-link-text ms-1">REKAP</span>
          </a>

        </li>

        <li class="nav-item">
          <a id="masterToggleBtn" href="javascript:void(0);"
            class="nav-link active text-white d-flex justify-content-between align-items-center"
            style="background-color: #62b8e1;" onclick="toggleMasterMenu()">
            Master Data
            <span id="arrowIcon" style="transition: transform 0.5s;">▼</span>
          </a>
        </li>

        <div class="collapse submenu-animated" id="masterSubmenu">
          <ul class="navbar-nav ms-3 mt-1">
            <li class="nav-item">
              <a class="nav-link active text-white" style="background-color: #7cc9ee;" href="?dashboard=desa">Desa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-white" style="background-color: #7cc9ee;"
                href="?dashboard=instansi">Instansi</a>
            </li>
          </ul>
        </div>
        <li class="nav-item mt-3">
          <a class="nav-link active text-white" style="background-color: #62b8e1;" href="logout.php"
            onclick="return confirm(' Anda yakin ingin Logout?')" class="nav-link active">

            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>

      </ul>
    </div>
  </aside>

  <div class="collapse" id="masterSubmenu">
    <ul class="navbar-nav ms-3 mt-1">
      <li class="nav-item">
        <a class="nav-link text-white" style="background-color: #7cc9ee;" href="?dashboard=desa">Desa</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" style="background-color: #7cc9ee;" href="?dashboard=instansi">Instansi</a>
      </li>
    </ul>
  </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 shadow" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"></li>
          </ol>
          <h6 class="font-weight-bolder mb-0 text-white">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <form action="" method="get">
              <div class="row">
                <div class="col">
                  <input type="text" class="form-control" placeholder="Cari Tamu..." name="cari" />
                  <input type="hidden" name="dashboard" value="tamu" />
                </div>
                <div class="col">
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-search"></i> Cari
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- Konten Utama -->
    <div class="container-fluid py-4">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <?php
          if (!empty($_GET['dashboard'])) {
            if ($_GET['dashboard'] == "tamu") {
              include "tamu.php";
            } elseif ($_GET['dashboard'] == "user") {
              include "user.php";
            } elseif ($_GET['dashboard'] == "user-add") {
              include "user_add.php";
            } elseif ($_GET['dashboard'] == "user-edit") {
              include "user_edit.php";
            } elseif ($_GET['dashboard'] == "tamu-add") {
              include "tamu_add.php";
            } elseif ($_GET['dashboard'] == "tamu-edit") {
              include "tamu_edit.php";
            } elseif ($_GET['dashboard'] == "rekap") {
              include "rekap_tamu.php";
            } elseif ($_GET['dashboard'] == "master") {
              include "master.php";
            } elseif ($_GET['dashboard'] == "desa") {
              include "m_desa.php";
            } elseif ($_GET['dashboard'] == "desa-edit") {
              include "m_desa_edit.php";
            } elseif ($_GET['dashboard'] == "desa-hapus") {
              include "m_desa_hapus.php";
            } elseif ($_GET['dashboard'] == "instansi") {
              include "m_instansi.php";
            } elseif ($_GET['dashboard'] == "instansi-edit") {
              include "m_instansi_edit.php";
            } elseif ($_GET['dashboard'] == "instansi-hapus") {
              include "m_instansi_hapus.php";
            }
             else {
              include "user.php";
            }
          } else {
            ?>
            <!-- Card Tanggal Hari Ini -->
            <div class="card shadow mb-4">
              <div class="card-body bg-primary text-white">
                <h5 class="card-title fw-bold text-uppercase">Hari Ini</h5>
                <p class="card-text">
                  <?php
                  // Array Nama Hari
                  $hariIndo = [
                    'Sunday' => 'Minggu',
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu'
                  ];

                  // Array Nama Bulan
                  $bulanIndo = [
                    'January' => 'Januari',
                    'February' => 'Februari',
                    'March' => 'Maret',
                    'April' => 'April',
                    'May' => 'Mei',
                    'June' => 'Juni',
                    'July' => 'Juli',
                    'August' => 'Agustus',
                    'September' => 'September',
                    'October' => 'Oktober',
                    'November' => 'November',
                    'December' => 'Desember'
                  ];

                  // Ambil nama hari dan bulan dalam bahasa Inggris
                  $hariInggris = date("l");  // Misal: Friday
                  $bulanInggris = date("F"); // Misal: March
                
                  // Konversi ke bahasa Indonesia
                  $hari = $hariIndo[$hariInggris];
                  $bulan = $bulanIndo[$bulanInggris];

                  // Format akhir
                  echo $hari . ", " . date("d") . " " . $bulan . " " . date("Y");
                  ?>
                </p>
              </div>
            </div>

            <!-- Card Statistik Tamu -->
            <div class="card shadow">
              <div class="card-body">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">
                    <i class="fas fa-chart-line me-2"></i> Statistik Tamu
                  </h1>
                </div>

                <?php
                // Koneksi database
                include "koneksi.php";

                // Mendapatkan tanggal-tanggal yang dibutuhkan
                $tgl_sekarang = date('Y-m-d');
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime($tgl_sekarang)));
                $seminggu_lalu = date('Y-m-d', strtotime('-1 week', strtotime($tgl_sekarang)));
                $bulan_ini = date('m');

                // Query untuk menghitung jumlah pengunjung berdasarkan rentang waktu
                $jumlah_hari_ini = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM tamu WHERE Tanggal = '$tgl_sekarang'"))[0];
                $jumlah_kemarin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM tamu WHERE Tanggal = '$kemarin'"))[0];
                $jumlah_seminggu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM tamu WHERE Tanggal BETWEEN '$seminggu_lalu' AND '$tgl_sekarang'"))[0];
                $jumlah_bulan_ini = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM tamu WHERE MONTH(Tanggal) = '$bulan_ini'"))[0];
                $jumlah_keseluruhan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM tamu"))[0];
                ?>

                <!-- Tabel Statistik -->
                <table class="table table-bordered table-hover text-center">
                  <thead class="table-primary">
                    <tr>
                      <th>Keterangan</th>
                      <th>Tanggal</th>
                      <th>Jumlah Tamu</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="table-success">
                      <td>Hari Ini</td>
                      <td><?= $tgl_sekarang ?></td>
                      <td><?= $jumlah_hari_ini ?></td>
                    </tr>
                    <tr class="table-warning">
                      <td>Kemarin</td>
                      <td><?= $kemarin ?></td>
                      <td><?= $jumlah_kemarin ?></td>
                    </tr>
                    <tr class="table-info">
                      <td>Minggu Ini</td>
                      <td><?= $seminggu_lalu . " s/d " . $tgl_sekarang ?></td>
                      <td><?= $jumlah_seminggu ?></td>
                    </tr>
                    <tr class="table-primary">
                      <td>Bulan Ini</td>
                      <td><?= date('F Y') ?></td>
                      <td><?= $jumlah_bulan_ini ?></td>
                    </tr>
                    <tr class="table-secondary">
                      <td>Keseluruhan</td>
                      <td>-</td>
                      <td><?= $jumlah_keseluruhan ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </main>

  <!-- Bootstrap JS dan dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

 
  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: [
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#fff",
          data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
          maxBarThickness: 6,
        },],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
              color: "#fff",
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            },
          },
        },
      },
    });

    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, "rgba(203,12,159,0.2)");
    gradientStroke1.addColorStop(0.2, "rgba(72,72,176,0.0)");
    gradientStroke1.addColorStop(0, "rgba(203,12,159,0)"); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, "rgba(20,23,39,0.2)");
    gradientStroke2.addColorStop(0.2, "rgba(72,72,176,0.0)");
    gradientStroke2.addColorStop(0, "rgba(20,23,39,0)"); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: [
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#cb0c9f",
          borderWidth: 3,
          backgroundColor: gradientStroke1,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6,
        },
        {
          label: "Websites",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#3A416F",
          borderWidth: 3,
          backgroundColor: gradientStroke2,
          fill: true,
          data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
          maxBarThickness: 6,
        },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
        },
        interaction: {
          intersect: false,
          mode: "index",
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              padding: 10,
              color: "#b2b9bf",
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5],
            },
            ticks: {
              display: true,
              color: "#b2b9bf",
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: "normal",
                lineHeight: 2,
              },
            },
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <script>
    function toggleMasterMenu() {
      const submenu = document.getElementById("masterSubmenu");
      const arrow = document.getElementById("arrowIcon");
      const toggleBtn = document.getElementById("masterToggleBtn");

      submenu.classList.toggle("show");
      arrow.classList.toggle("rotate");
      toggleBtn.classList.toggle("active-toggle");
    }

    document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("masterSubmenu").classList.remove("show");
      document.getElementById("arrowIcon").classList.remove("rotate");
      document.getElementById("masterToggleBtn").classList.remove("active-toggle");
    });
  </script>
  <!-- Footer -->
  <footer class="bg-dark text-center text-white py-4">
    <div class="container">
      <p class="mb-0">Buku Tamu &copy; 2025. All Rights Reserved.</p>
      <a href="https://www.instagram.com/ramine4u_" target="_blank" class="text-white">
        <i class="fab fa-instagram"></i> Follow us on Instagram
      </a>
    </div>
  </footer>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>