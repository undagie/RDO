<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>APLIKASI REPORT DELIVERY ORDER | DATA</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/2.png">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <style>
        .scroll-horizontal {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <?php include "../theme-header.php" ?>
        <?php include "../theme-sidebar.php" ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="card-body">
                    <div class="card-header">
                        <h4 class="card-title">DATA SURAT JALAN</h4>
                        <br> <br>
                    </div>
                    <br>
                    <div class="input-group search-area ml-auto d-inline-flex">
                        <input type="text" class="form-control" placeholder="Masukkan Nama Customer" id="searchInput">
                        <div class="input-group-append">
                            <button type="button" class="input-group-text" onclick="searchData()"><i class="flaticon-381-search-2"></i></button>
                        </div>
                    </div>


                    <!-- Bagian form filter -->
                    <div class="container align-items-center">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col form-group">
                                    <label for="inputMulaiTanggal" class="font-weight-bold">Mulai Tanggal :</label>
                                    <input type="date" id="inputMulaiTanggal" name="mulai_tanggal" class="form-control" required>
                                </div>
                                <div class="col form-group">
                                    <label for="inputSampaiTanggal" class="font-weight-bold">Sampai Tanggal :</label>
                                    <input type="date" id="inputSampaiTanggal" name="sampai_tanggal" class="form-control" required>
                                </div>
                                <div class="col-auto form-group">
                                    <button type="submit" name="filter" class="btn btn-success mt-3">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <br>
                    <br>
                    <a href="../pengiriman/index.php" class="btn btn-primary">Lihat Pengiriman</a>
                    <a href="cetak.php" class="btn btn-primary">Cetak Report</a>
                    <br>
                    <br>
                    <div class="scroll-horizontal">
                        <table class="table table-bordered">
                            <tr align="center" bgcolor="#32c8ed">
                                <th>No</th>
                                <th>Id Pengiriman</th>
                                <th>Id Surat</th>
                                <th>Id Customer</th>
                                <th>Nama Customer</th>
                                <th>Telpon</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Rute</th>
                                <th>Pembelian</th>
                                <th>Tanggal Pengiriman</th>
                                <th>NO Plat/Armada</th>
                                <th>Type Armada</th>
                                <th>NIK Driver</th>
                                <th>Nama Driver</th>
                                <th>Aksi</th>
                            </tr>

                            <?php
                            include '../koneksi.php';
                            $no = 1;

                            if (isset($_POST['filter'])) {
                                // Ambil tanggal mulai dan tanggal sampai dari form
                                $mulai_tanggal = $_POST['mulai_tanggal'];
                                $sampai_tanggal = $_POST['sampai_tanggal'];

                                // Buat query dengan kondisi filter tanggal
                                $query = "SELECT 
                                tb_pengirim.*,   
                                tb_surat.*, 
                                tb_customer.*, 
                                tb_armada.type_armada, 
                                tb_driver.nama_driver
                            FROM 
                                tb_pengirim
                            JOIN 
                                tb_surat ON tb_pengirim.id_surat = tb_surat.id_surat
                            JOIN 
                                tb_customer ON tb_pengirim.id_cust = tb_customer.id_cust
                            JOIN 
                                tb_armada ON tb_pengirim.no_plat = tb_armada.no_plat
                            JOIN 
                                tb_driver ON tb_pengirim.nik_driver = tb_driver.nik_driver
                                        WHERE tanggal_kirim BETWEEN '$mulai_tanggal' AND '$sampai_tanggal'
                                        ORDER BY tb_surat.tanggal_kirim";
                                $result = mysqli_query($conn, $query);
                            } else {
                                $query = "SELECT 
                                tb_pengirim.*,   
                                tb_surat.*, 
                                tb_customer.*, 
                                tb_armada.type_armada, 
                                tb_driver.nama_driver
                            FROM 
                                tb_pengirim
                            JOIN 
                                tb_surat ON tb_pengirim.id_surat = tb_surat.id_surat
                            JOIN 
                                tb_customer ON tb_pengirim.id_cust = tb_customer.id_cust
                            JOIN 
                                tb_armada ON tb_pengirim.no_plat = tb_armada.no_plat
                            JOIN 
                                tb_driver ON tb_pengirim.nik_driver = tb_driver.nik_driver
                            
                                ORDER BY id_pengiriman DESC";
                                $result = mysqli_query($conn, $query);
                            }

                            if (mysqli_num_rows($result) > 0) {
                                while ($hasil = mysqli_fetch_assoc($result)) {
                                    // Kode HTML untuk menampilkan data
                            ?>
                                    <tr align="center">
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $hasil['id_pengiriman'] ?></td>
                                        <td><?php echo $hasil['id_surat'] ?></td>
                                        <td><?php echo $hasil['id_cust'] ?></td>
                                        <td><?php echo $hasil['nama_cust'] ?></td>
                                        <td><?php echo $hasil['no_telpon'] ?></td>
                                        <td><?php echo $hasil['alamat_cust'] ?></td>
                                        <td><?php echo $hasil['kecamatan'] ?></td>
                                        <td><?php echo $hasil['rute'] ?></td>

                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#detailModal<?php echo $hasil['id_surat']; ?>">Lihat Detail</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="detailModal<?php echo $hasil['id_surat']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?php echo $hasil['id_surat']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailModalLabel<?php echo $hasil['id_surat']; ?>">Detail Pembelian</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                            $query_pembelian = "SELECT * FROM tb_pembelian WHERE id_surat = " . $hasil['id_surat'];
                                                            $result_pembelian = mysqli_query($conn, $query_pembelian);

                                                            if (mysqli_num_rows($result_pembelian) > 0) {
                                                                while ($pembelian = mysqli_fetch_assoc($result_pembelian)) {
                                                                    echo "<p>ID Pembelian: " . $pembelian['id_pembelian'] . "</p>";
                                                                    echo "<p>ID Surat: " . $pembelian['id_surat'] . "</p>";
                                                                    echo "<p>ID Customer: " . $pembelian['id_cust'] . "</p>";
                                                                    echo "<p>ID Barang: " . $pembelian['kode_brg'] . "</p>";
                                                                    echo "<p>Jumlah: " . $pembelian['qty'] . "</p>";
                                                                    echo "<br>";
                                                                }
                                                            } else {
                                                                echo "Data pembelian tidak tersedia.";
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td><?php echo $hasil['tanggal_kirim'] ?></td>
                                        <td><?php echo $hasil['no_plat'] ?></td>
                                        <td><?php echo $hasil['type_armada'] ?></td>
                                        <td><?php echo $hasil['nik_driver'] ?></td>
                                        <td><?php echo $hasil['nama_driver'] ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="edit.php?id_pengiriman=<?php echo $hasil['id_pengiriman']; ?>" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="hapus.php?id_pengiriman=<?php echo $hasil['id_pengiriman']; ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="7" align="center">Data kosong</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <?php include "../theme-footer.php" ?>

    </div>

    <!-- Required vendors -->
    <script src="../vendor/global/global.min.js"></script>
    <script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/deznav-init.js"></script>
    <script src="../vendor/highlightjs/highlight.pack.min.js"></script>


    <script>
        function searchData() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByClassName("table")[0];
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4]; // Ganti angka 2 dengan indeks kolom nama

                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <!-- Circle progress -->
</body>

</html>