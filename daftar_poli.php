<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("koneksi.php");
if (!isset($_SESSION['username'])) {
    header("Location: LoginUser.php");
    exit;
}
// Lanjutkan kode halaman ini jika sudah login
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Offline -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Bootstrap Online -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <hr>

        <form class="row" method="POST" action="" name="myForm" onsubmit="return validate();">
            <?php
            $id_pasien = '';
            $id_jadwal = '';
            $keluhan = '';
            $no_antrian = '';

            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM daftar_poli WHERE id='" . $_GET['id'] . "'");
                if ($ambil) { // Periksa apakah kueri dieksekusi dengan sukses
                    $row = mysqli_fetch_array($ambil);
                    $id_pasien = $row['id_pasien'];
                    $id_jadwal = $row['id_jadwal'];
                    $keluhan = $row['keluhan'];
                    $no_antrian = $row['no_antrian'];
                } else {
                    echo "Error: " . mysqli_error($mysqli); // Tampilkan pesan kesalahan jika kueri gagal
                }
                ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
            }
            ?>

            <div class="form-group">
                <label for="inputPasien" class="form-label fw-bold">Pasien</label>
                <select class="form-control" name="id_pasien" id="inputPasien">
                    <?php
                    $resultPasien = mysqli_query($mysqli, "SELECT * FROM pasien");
                    if ($resultPasien) {
                        while ($dataPasien = mysqli_fetch_array($resultPasien)) {
                            $selectedPasien = ($dataPasien['id'] == $id_pasien) ? 'selected="selected"' : '';
                    ?>
                            <option value="<?php echo $dataPasien['id'] ?>" <?php echo $selectedPasien ?>><?php echo $dataPasien['nama'] ?></option>
                    <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($mysqli);
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="inputJadwal" class="form-label fw-bold">Jadwal</label>
                <select class="form-control" name="id_jadwal" id="inputJadwal">
                    <?php
                    $resultJadwal = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa");
                    if ($resultJadwal) {
                        while ($dataJadwal = mysqli_fetch_array($resultJadwal)) {
                            $selectedJadwal = ($dataJadwal['id'] == $id_jadwal) ? 'selected="selected"' : '';
                    ?>
                            <option value="<?php echo $dataJadwal['id'] ?>" <?php echo $selectedJadwal ?>><?php echo $dataJadwal['hari'] . " - " . $dataJadwal['jam_mulai'] . " - " . $dataJadwal['jam_selesai'] ?></option>
                    <?php
                        }
                    } else {
                        echo "Error: " . mysqli_error($mysqli);
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="inputKeluhan" class="form-label fw-bold">Keluhan</label>
                <input type="text" class="form-control" name="keluhan" id="inputKeluhan" placeholder="Keluhan" value="<?php echo $keluhan; ?>">
            </div>

            <div class="form-group">
                <label for="inputNoAntrian" class="form-label fw-bold">Nomor Antrian</label>
                <input type="text" class="form-control" name="no_antrian" id="inputNoAntrian" placeholder="Nomor Antrian" value="<?php echo $no_antrian; ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>

        </form>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pasien</th>
                    <th scope="col">Jadwal</th>
                    <th scope="col">Keluhan</th>
                    <th scope="col">Nomor Antrian</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $resultDaftarPoli = mysqli_query($mysqli, "SELECT * FROM daftar_poli");
                if ($resultDaftarPoli) { // Periksa apakah kueri dieksekusi dengan sukses
                    $no = 1;
                    while ($dataDaftarPoli = mysqli_fetch_array($resultDaftarPoli)) {
                        // Menggabungkan data dari tabel daftar_poli, pasien, dan jadwal_periksa
                        $resultPasien = mysqli_query($mysqli, "SELECT * FROM pasien WHERE id = '" . $dataDaftarPoli['id_pasien'] . "'");
                        $resultJadwal = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id = '" . $dataDaftarPoli['id_jadwal'] . "'");
                        $dataPasien = mysqli_fetch_array($resultPasien);
                        $dataJadwal = mysqli_fetch_array($resultJadwal);
                ?>
                        <tr>
                            <th scope="row"><?php echo $no++ ?></th>
                            <td><?php echo $dataPasien['nama'] ?></td>
                            <td><?php echo $dataJadwal['hari'] . " - " . $dataJadwal['jam_mulai'] . " - " . $dataJadwal['jam_selesai'] ?></td>
                            <td><?php echo $dataDaftarPoli['keluhan'] ?></td>
                            <td><?php echo $dataDaftarPoli['no_antrian'] ?></td>
                            <td>
                                <a class="btn btn-info rounded-pill px-3" href="daftar_poli.php?id=<?php echo $dataDaftarPoli['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="daftar_poli.php?id=<?php echo $dataDaftarPoli['id'] ?>&aksi=hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo "Error: " . mysqli_error($mysqli); // Tampilkan pesan kesalahan jika kueri gagal
                }
                ?>
            </tbody>
        </table>

        <?php
        if (isset($_POST['simpan'])) {
            if (isset($_POST['id'])) {
                $ubah = mysqli_query($mysqli, "UPDATE daftar_poli SET 
                                        id_pasien = '" . $_POST['id_pasien'] . "',
                                        id_jadwal = '" . $_POST['id_jadwal'] . "',
                                        keluhan = '" . $_POST['keluhan'] . "',
                                        no_antrian = '" . $_POST['no_antrian'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
            } else {
                $tambah = mysqli_query($mysqli, "INSERT INTO daftar_poli(id_pasien, id_jadwal, keluhan, no_antrian) 
                                        VALUES ( 
                                            '" . $_POST['id_pasien'] . "',
                                            '" . $_POST['id_jadwal'] . "',
                                            '" . $_POST['keluhan'] . "',
                                            '" . $_POST['no_antrian'] . "'
                                            )");
            }

            echo "<script> 
                document.location='daftar_poli.php';
            </script>";
        }

        if (isset($_GET['aksi'])) {
            if ($_GET['aksi'] == 'hapus') {
                $hapus = mysqli_query($mysqli, "DELETE FROM daftar_poli WHERE id = '" . $_GET['id'] . "'");
            }
            echo "<script> 
                document.location='daftar_poli.php';
            </script>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRfJ9f5jz3I4/3r5F5I5j5qofnVf5U1kAl7vC4ks7x" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-nDLU77O4f9vG4JqF01f8Uxl5KveGqZyl5Ci8FQITu97uQOGcnJw92ag0C6w5W/pj" crossorigin="anonymous"></script>
</body>
</html>
