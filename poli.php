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
        $nama_poli = '';
        $keterangan = '';
        
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM poli
            WHERE id='" . $_GET['id'] . "'");
            
            while ($row = mysqli_fetch_array($ambil)) {
                $nama_poli = $row['nama_poli'];
                $keterangan = $row['keterangan'];
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
        <div class="form-group">
            <label for="inputNamaPoli" class="form-label fw-bold">
                Nama Poli
            </label>
            <input type="text" class="form-control" name="nama_poli" id="inputNamaPoli" placeholder="Nama Poli" value="<?php echo $nama_poli; ?>">
        </div>
        <div class="form-group">
            <label for="inputKeterangan" class="form-label fw-bold">
                Keterangan
            </label>
            <textarea class="form-control" name="keterangan" id="inputKeterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Poli</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli,"SELECT * FROM poli"
            );
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td>
                        <a class="btn btn-info rounded-pill px-3" 
                        href="poli.php?id=<?php echo $data['id'] ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="poli.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
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
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                        nama_poli = '" . $_POST['nama_poli'] . "',
                                        keterangan = '" . $_POST['keterangan'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO poli(nama_poli, keterangan) 
                                        VALUES ( 
                                            '" . $_POST['nama_poli'] . "',
                                            '" . $_POST['keterangan'] . "'
                                            )");
    }

    echo "<script> 
            document.location='poli.php';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }
    echo "<script> 
            document.location='poli.php';
            </script>";
}
?>
