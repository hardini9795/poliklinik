<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("koneksi.php");
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">

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

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Pasien</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Tanggal Periksa</th>
                <th scope="col">Catatan</th>
                <th scope="col">Obat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli, "SELECT pr.*, d.nama as 'nama_dokter', p.nama as 'nama_pasien', o.nama_obat, o.kemasan, o.harga
            FROM periksa pr
            LEFT JOIN dokter d ON (pr.id_dokter = d.id)
            LEFT JOIN pasien p ON (pr.id_pasien = p.id)
            LEFT JOIN obat o ON (pr.id_obat = o.id)
            ORDER BY pr.tgl_periksa DESC;
            "
            );
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_pasien'] ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['tgl_periksa'] ?></td>
                    <td><?php echo $data['catatan'] ?></td>
                    <td><?php echo $data['nama_obat'] . ' - ' . $data['kemasan'] . ' - Rp ' . number_format($data['harga'], 0, ',', '.') ?></td>
                    <td>
                        <a class="btn btn-primary rounded-pill px-3" href="nota.php?page=periksa&id_invoice=<?php echo $data['id'] ?>">Nota</a>
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
