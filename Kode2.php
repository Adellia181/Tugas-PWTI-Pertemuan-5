<!DOCTYPE html>
<html>
<head>
    <title>Data Pelajar</title>
</head>
<body>
    <?php
    $host       = "localhost";
    $user       = "root";
    $pass       = "adellia123";
    $db         = "pertemuan5";

    $koneksi    = mysqli_connect($host, $user, $pass, $db);
    if (!$koneksi) {
        die("Tidak terkoneksi");
    }
    // --- Tambah data
    function tambah($koneksi)
    {

        if (isset($_POST['btn_simpan'])) {
            $id_pengguna = time();
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $tanggal_lahir = $_POST['tanggal_lahir'];

            if (!empty($nama) && !empty($alamat) && !empty($tanggal_lahir)) {
                $sql = "INSERT INTO Pelajar(id_pengguna,nama, alamat, tanggal_lahir) VALUES(" . $id_pengguna . ",'" . $nama . "','" . $alamat . "','" . $tanggal_lahir  . "')";
                $simpan = mysqli_query($koneksi, $sql);
                if ($simpan && isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'create') {
                        header('location: Kode2.php');
                    }
                }
            } else {
                $pesan = "Data tidak tersimpan, data belum lengkap!";
            }
        }
    ?>
        <form action="" method="POST">
            <fieldset>
                <legend>
                    <h2>Tambah data</h2>
                </legend>
                <label>Nama <input type="text" name="nama" /></label> <br>
                <label>Alamat <input type="text" name="alamat" /></label><br>
                <label>Tanggal Lahir <input type="number" name="tanggal_lahir" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_simpan" value="Simpan" />
                    <input type="reset" name="reset" value="Hapus" />
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
            </fieldset>
        </form>
        <?php
    }

    // --- Lihat Data
    function tampil_data($koneksi)
    {
        $sql = "SELECT * FROM Pelajar";
        $query = mysqli_query($koneksi, $sql);

        echo "<fieldset>";
        echo "<legend><h2>Data Pelajar</h2></legend>";

        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Action</th>
          </tr>";

        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $data['id_pengguna']; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['alamat']; ?></td>
                <td><?php echo $data['tanggal_lahir']; ?></td>
                <td>
                    <a href="Kode2.php?aksi=update&id_pengguna=<?php echo $data['id_pengguna']; ?>&nama=<?php echo $data['nama']; ?>&alamat=<?php echo $data['alamat']; ?>&tanggal_lahir=<?php echo $data['tanggal_lahir']; ?>">Ubah</a> |
                    <a href="Kode2.php?aksi=delete&id_pengguna=<?php echo $data['id_pengguna']; ?>">Hapus</a>
                </td>
            </tr>
        <?php
        }
        echo "</table>";
        echo "</fieldset>";
    }

    // --- Update data
    function ubah($koneksi)
    {
        // ubah data
        if (isset($_POST['btn_ubah'])) {
            $id_pengguna= $_POST['id_pengguna'];
            $nama = $_POST['nama'];
            $alamat = $_POST['alamat'];
            $tanggal_lahir = $_POST['tanggal_lahir'];

            if (!empty($nama) && !empty($alamat) && !empty($tanggal_lahir)) {
                $perubahan = "nama='" . $nama . "',alamat=" . $alamat . ",tanggal_lahir=" . $tanggal_lahir . "'";
                $sql_update = "UPDATE Pelajar SET " . $perubahan . " WHERE id_pengguna=$id_pengguna";
                $update = mysqli_query($koneksi, $sql_update);
                if ($update && isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'update') {
                        header('location: Kode2.php');
                    }
                }
            } else {
                $pesan = "Data belum lengkap!";
            }
        }

        // tampilkan form ubah
        if (isset($_GET['id_pengguna'])) {
        ?>
            <a href="Kode2.php"> &laquo; Home</a> |
            <a href="Kode2.php?aksi=create"> (+) Tambah Data</a>
            <hr>

            <form action="" method="POST">
                <fieldset>
                    <legend>
                        <h2>Ubah data</h2>
                    </legend>
                    <input type="hidden" name="id_pengguna" value="<?php echo $_GET['id_pengguna'] ?>" />
                    <label>Nama <input type="text" name="nama" value="<?php echo $_GET['nama'] ?>" /></label> <br>
                    <label>Alamat<input type="text" name="alamat" value="<?php echo $_GET['alamat'] ?>" /></label><br>
                    <label>Tanggal Lahir <input type="date" name="tanggal_lahir" value="<?php echo $_GET['tanggal_lahir'] ?>" /></label> <br>
                    <br>
                    <label>
                        <input type="submit" name="btn_ubah" value="Simpan Perubahan" /> atau <a href="Kode2.php?aksi=delete&id_pengguna=<?php echo $_GET['id_pengguna'] ?>"> (x) Hapus data ini</a>!
                    </label>
                    <br>
                    <p><?php echo isset($pesan) ? $pesan : "" ?></p>

                </fieldset>
            </form>
    <?php
        }
    }

    // --- Fungsi Delete
    function hapus($koneksi)
    {
        if (isset($_GET['id_pengguna']) && isset($_GET['aksi'])) {
            $id_pengguna = $_GET['id_pengguna'];
            $sql_hapus = "DELETE FROM Pelajar WHERE id_pengguna=" . $id_pengguna;
            $hapus = mysqli_query($koneksi, $sql_hapus);

            if ($hapus) {
                if ($_GET['aksi'] == 'delete') {
                    header('location: Kode2.php');
                }
            }
        }
    }

    // ===================================================================
    if (isset($_GET['aksi'])) {
        switch ($_GET['aksi']) {
            case "create":
                echo '<a href="Kode2.php"> &laquo; Home</a>';
                tambah($koneksi);
                break;
            case "read":
                tampil_data($koneksi);
                break;
            case "update":
                ubah($koneksi);
                tampil_data($koneksi);
                break;
            case "delete":
                hapus($koneksi);
                break;
            default:
                echo "<h3>Aksi <i>" . $_GET['aksi'] . "</i> tidak ada!</h3>";
                tambah($koneksi);
                tampil_data($koneksi);
        }
    } else {
        tambah($koneksi);
        tampil_data($koneksi);
    }
    ?>
</body>

</html>