<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("koneksi.php");

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

// Continue with the code if already logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap offline -->
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
    <form class="form row" method="POST" action="" name="myForm" onsubmit="return validate();">
    <?php
    $id_dokter = '';
    $hari = '';
    $jam_mulai = '';
    $jam_selesai = '';
    $aktif = '';

    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, 
        "SELECT * FROM jadwal_periksa 
        WHERE id='" . $_GET['id'] . "'");

        // Check if the query was successful
        if (!$ambil) {
            die("Error in SQL query: " . mysqli_error($mysqli));
        }

        while ($row = mysqli_fetch_array($ambil)) {
            $id_dokter = $row['id_dokter'];
            $hari = $row['hari'];
            $jam_mulai = $row['jam_mulai'];
            $jam_selesai = $row['jam_selesai'];
            $aktif = $row['aktif'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <?php
    }
    ?>
        <div class="form-group">
            <label for="inputDokter" class="form-label fw-bold">
                Dokter
            </label>
            <select class="form-control" name="id_dokter" id="inputDokter">
            <?php
            $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");

            // Check if the query was successful
            if (!$dokter) {
                die("Error in SQL query: " . mysqli_error($mysqli));
            }

            while ($data = mysqli_fetch_array($dokter)) {
                $selected = ($data['id'] == $id_dokter) ? 'selected="selected"' : '';
            ?>
                <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>><?php echo $data['nama']; ?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <div class="form-group">
            <label for="inputHari" class="form-label fw-bold">
                Hari
            </label>
            <select class="form-control" name="hari" id="inputHari">
                <?php
                $daysOfWeek = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
                foreach ($daysOfWeek as $day) {
                    $selected = ($hari == $day) ? "selected" : "";
                    echo "<option value='{$day}' $selected>{$day}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="inputJamMulai" class="form-label fw-bold">
                Jam Mulai
            </label>
            <input type="time" class="form-control" name="jam_mulai" id="inputJamMulai" placeholder="Jam Mulai" value="<?php echo $jam_mulai; ?>">
        </div>
        <div class="form-group">
            <label for="inputJamSelesai" class="form-label fw-bold">
                Jam Selesai
            </label>
            <input type="time" class="form-control" name="jam_selesai" id="inputJamSelesai" placeholder="Jam Selesai" value="<?php echo $jam_selesai; ?>">
        </div>
        <div class="form-group">
            <label for="inputAktif" class="form-label fw-bold">
                Aktif
            </label>
            <select class="form-control" name="aktif" id="inputAktif">
                <option value="Y" <?php echo ($aktif == 'Y') ? 'selected' : ''; ?>>Y</option>
                <option value="N" <?php echo ($aktif == 'N') ? 'selected' : ''; ?>>N</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Dokter</th>
                <th scope="col">Hari</th>
                <th scope="col">Jam Mulai</th>
                <th scope="col">Jam Selesai</th>
                <th scope="col">Aktif</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli,"SELECT * FROM jadwal_periksa"
            );

            // Check if the query was successful
            if (!$result) {
                die("Error in SQL query: " . mysqli_error($mysqli));
            }

            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++; ?></th>
                    <td><?php echo $data['id_dokter']; ?></td>
                    <td><?php echo $data['hari']; ?></td>
                    <td><?php echo $data['jam_mulai']; ?></td>
                    <td><?php echo $data['jam_selesai']; ?></td>
                    <td><?php echo $data['aktif']; ?></td>
                    <td>
                        <a class="btn btn-info rounded-pill px-3" 
                        href="jadwal_periksa.php?id=<?php echo $data['id']; ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="jadwal_periksa.php?id=<?php echo $data['id']; ?>&aksi=hapus">Hapus
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>

<?php
if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE jadwal_periksa SET 
                                        id_dokter = '" . $_POST['id_dokter'] . "',
                                        hari = '" . $_POST['hari'] . "',
                                        jam_mulai = '" . $_POST['jam_mulai'] . "',
                                        jam_selesai = '" . $_POST['jam_selesai'] . "',
                                        aktif = '" . $_POST['aktif'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO jadwal_periksa(id_dokter, hari, jam_mulai, jam_selesai, aktif) 
                                        VALUES ( 
                                            '" . $_POST['id_dokter'] . "',
                                            '" . $_POST['hari'] . "',
                                            '" . $_POST['jam_mulai'] . "',
                                            '" . $_POST['jam_selesai'] . "',
                                            '" . $_POST['aktif'] . "'
                                            )");

        // Check if the query was successful
        if (!$tambah) {
            die("Error in SQL query: " . mysqli_error($mysqli));
        }
    }

    echo "<script> 
            document.location='jadwal_periksa.php';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM jadwal_periksa WHERE id = '" . $_GET['id'] . "'");
        
        // Check if the query was successful
        if (!$hapus) {
            die("Error in SQL query: " . mysqli_error($mysqli));
        }
    }
    echo "<script> 
            document.location='jadwal_periksa.php';
            </script>";
}
?>
