<?php

$host    = "localhost";
$user    = "root";
$pass    = "";
$db      = "final";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("koneksi gagal" . mysqli_connect_error());
}

$nim        = "";
$nama       = "";
$umur       = "";
$angkatan   = "";
$sukses     = "";
$error      = "";

if (isset($_GET["op"])) {
    $op = $_GET["op"];
} else {
    $op = "";
}

if ($op == "delete") {
    $id     = $_GET["id"];
    $sql1   = "DELETE FROM `mahasiswa` WHERE id = '$id'";
    $q1      = mysqli_query($conn, $sql1);
    if ($q1) {
        $sukses = "berhasil Hapus data";
    } else {
        $error = "gagal hapus data";
    }
}

if ($op == "edit") {
    $id      = $_GET["id"];
    $sql1    = "SELECT * FROM `mahasiswa` WHERE id = '$id'";
    $q1      = mysqli_query($conn, $sql1);
    $r1      = mysqli_fetch_array($q1);
    $nim         = $r1['nim'];
    $nama        = $r1['nama'];
    $umur        = $r1['umur'];
    $angkatan    = $r1['angkatan'];
}

if (isset($_POST["simpan"])) {
    $nim        = $_POST["nim"];
    $nama       = $_POST["nama"];
    $umur       = $_POST["umur"];
    $angkatan   = $_POST["angkatan"];

    if ($nim && $nama && $umur && $angkatan) {
        if ($op == 'edit') { //edit data
            $sql1   = "UPDATE `mahasiswa` SET `nim`='$nim',`nama`='$nama',`umur`='$umur',`angkatan`='$angkatan' WHERE id = '$id'";
            $q1     = mysqli_query($conn, $sql1);

            if ($q1) {
                $sukses = "berhasil update data";
            } else {
                $error = "gagal update data";
            }
        } else { //tambah data
            $sql1   = "INSERT INTO `mahasiswa`(`nim`, `nama`, `umur`, `angkatan`) VALUES ('$nim','$nama','$umur','$angkatan')";
            $q1     = mysqli_query($conn, $sql1);

            if ($q1) {
                $sukses = "berhasil masukkan data";
            } else {
                $error = "gagal masukkan data";
            }
        }
    } else {
        $error = "lengkapi data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- tambah data -->
        <div class="card">
            <div class="card-header">
                Tambah Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                header("refresh:2; url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:2; url=index.php");
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="umur" name="umur" value="<?php echo $umur ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="angkatan" class="col-sm-2 col-form-label">Angkatan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="angkatan" id="angkatan">
                                <option value="">Pilih Angkatan</option>
                                <option value="2020" <?php if ($angkatan == "2020") echo "selected" ?>>2020</option>
                                <option value="2021" <?php if ($angkatan == "2021") echo "selected" ?>>2021</option>
                                <option value="2022" <?php if ($angkatan == "2022") echo "selected" ?>>2022</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- tampilkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Tambah Data
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Umur</th>
                            <th scope="col">Angkatan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM `mahasiswa` order by id desc ";
                        $q2 = mysqli_query($conn, $sql2);
                        $urut = 1;

                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id         = $r2['id'];
                            $nim        = $r2['nim'];
                            $nama       = $r2['nama'];
                            $umur       = $r2['umur'];
                            $angkatan   = $r2['angkatan'];
                        ?>
                            <tr>
                                <th scope="row"> <?php echo $urut++ ?> </th>
                                <td scope="row"> <?php echo $nim ?> </td>
                                <td scope="row"> <?php echo $nama ?> </td>
                                <td scope="row"> <?php echo $umur ?> </td>
                                <td scope="row"> <?php echo $angkatan ?> </td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('yakin akan menghapus data')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>