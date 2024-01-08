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
        $id = '';
        $nama = '';
        $alamat = '';
        $no_ktp = '';
        $no_hp = '';
        $no_rm = '';
        
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM pasien
            WHERE id='" . $_GET['id'] . "'");
            
            while ($row = mysqli_fetch_array($ambil)) {
                $id = $row['id'];
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_ktp = $row['no_ktp'];
                $no_hp = $row['no_hp'];
                $no_rm = $row['no_rm'];
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php
        }
        ?>
        <div class="form-group">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama; ?>">
        </div>
        <div class="form-group">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat; ?>">
        </div>
        <div class="form-group">
            <label for="inputNoKTP" class="form-label fw-bold">
                Nomor KTP
            </label>
            <input type="text" class="form-control" name="no_ktp" id="inputNoKTP" placeholder="Nomor KTP" value="<?php echo $no_ktp; ?>">
        </div>
        <div class="form-group">
            <label for="inputNoHP" class="form-label fw-bold">
                Nomor HP
            </label>
            <input type="text" class="form-control" name="no_hp" id="inputNoHP" placeholder="Nomor HP" value="<?php echo $no_hp; ?>">
        </div>
        <div class="form-group">
            <label for="inputNoRM" class="form-label fw-bold">
                Nomor Rekam Medis
            </label>
            <input type="text" class="form-control" name="no_rm" id="inputNoRM" placeholder="Nomor Rekam Medis" value="<?php echo $no_rm; ?>">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Nomor KTP</th>
                <th scope="col">Nomor HP</th>
                <th scope="col">Nomor Rekam Medis</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli,"SELECT * FROM pasien"
            );
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_ktp'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
                    <td>
                        <a class="btn btn-info rounded-pill px-3" 
                        href="pasien.php?id=<?php echo $data['id'] ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="pasien.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
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
        $ubah = mysqli_query($mysqli, "UPDATE pasien SET 
                                        nama = '" . $_POST['nama'] . "',
                                        alamat = '" . $_POST['alamat'] . "',
                                        no_ktp = '" . $_POST['no_ktp'] . "',
                                        no_hp = '" . $_POST['no_hp'] . "',
                                        no_rm = '" . $_POST['no_rm'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO pasien(nama,alamat,no_ktp,no_hp,no_rm) 
                                        VALUES ( 
                                            '" . $_POST['nama'] . "',
                                            '" . $_POST['alamat'] . "',
                                            '" . $_POST['no_ktp'] . "',
                                            '" . $_POST['no_hp'] . "',
                                            '" . $_POST['no_rm'] . "'
                                            )");
    }

    echo "<script> 
            document.location='pasien.php';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }
    echo "<script> 
            document.location='pasien.php';
            </script>";
}
?>
