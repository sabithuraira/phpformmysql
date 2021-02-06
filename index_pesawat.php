<html>  
    <head>
        <title>Daftar PESAWAT</title>
        <style>
            /* MENAMPILKAN BORDER PADA TABLE */
            table,td,tr,th { border: 1px solid black}
        </style>
    </head>
    <body>
        <?php
            //MENDEFINISIKAN KONEKSI DATABASE
            $username = "root";
            $password = "";
            $server_name = "localhost";
            $database_name = "penerbangan"; 
        
            $connection = new mysqli($server_name, $username, $password, $database_name);
            if($connection->connect_error)
                echo "Error, konfigurasi DB salah";
            else
                echo "Database berhasil dikoneksikan";
            echo "<br/>";
            $keyword = "";
            if(count($_GET)>0){
                $keyword = $_GET['keyword'];
            }
        ?>
        <b>Daftar Pesawat</b>
        <a href="insert_pesawat.php">Tambah Pesawat</a>
        <a href="index.php">Daftar Bandara</a>

        <form action="" method="GET">
            <input type="text" name="keyword" value="<?php echo $keyword; ?>">
            <button type="submit">SEARCH</button>
        </form>

        <table>
            <tr>
                <td>Nomor</td>
                <td>Kode Pesawat</td>
                <td>Nama</td>
                <td>Tahun Pembuatan</td>
                <td>Maskapai</td>
                <td>Update</td>
                <td>Delete</td>
            </tr>
            <?php
                $sql_pesawat = "SELECT * FROM pesawat";
                if($keyword!=""){
                    $sql_pesawat = "SELECT * FROM pesawat WHERE 
                        nama_pesawat LIKE '%".$keyword."%' OR 
                        nama_maskapai LIKE '%".$keyword."%'";
                }

                $result_pesawat = $connection->query($sql_pesawat);
                //MENGECEK APAKAH HASIL DATANYA ADA
                if($result_pesawat->num_rows>0){
                    $i = 1;
                    //PERULANGAN UNTUK MENGAMBIL DATA HASIL QUERY
                    while($row = $result_pesawat->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['kode_pesawat']."</td>";
                        echo "<td>".$row['nama_pesawat']."</td>";
                        echo "<td>".$row['tahun_pembuatan']."</td>";
                        echo "<td>".$row['nama_maskapai']."</td>";
                        echo "<td><a href='update_pesawat.php?id=".$row['id']."'>Update</a></td>";
                        echo "<td><a href='delete_pesawat.php?id=".$row['id']."'>Delete</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                }else{
                    echo "<tr><td colspan='7'>Tidak ada data yang ditampilkan</td></tr>";
                }
            ?>
        </table>
    </body>
</html>