<html>  
    <head>
        <title>CRUD MySQL dengan FORM</title>
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
        <b>Daftar Bandara</b>
        <a href="insert.php">Tambah</a>
        <a href="index_pesawat.php">Daftar Pesawat</a>
        <a href="index_customer.php">Daftar Customer</a>
        <a href="index_penerbangan.php">Daftar Penerbangan</a>

        <form action="" method="GET">
            <input type="text" name="keyword" value="<?php echo $keyword; ?>">
            <button type="submit">SEARCH</button>
        </form>

        <table>
            <tr>
                <td>Nomor</td>
                <td>Kode Bandara</td>
                <td>Bandara</td>
                <td>Alamat</td>
                <td>Update</td>
                <td>Delete</td>
            </tr>
            <?php
                $sql_bandara = "SELECT * FROM bandara";
                if(strlen($keyword)>0){
                    $sql_bandara = "SELECT * FROM bandara WHERE 
                        kode_bandara LIKE '%".$keyword."%' 
                        OR nama_bandara LIKE '%".$keyword."%' 
                        OR alamat_bandara LIKE '%".$keyword."%'";    
                }

                $result_bandara = $connection->query($sql_bandara);
                //MENGECEK APAKAH HASIL DATANYA ADA
                if($result_bandara->num_rows>0){
                    $i = 1;
                    //PERULANGAN UNTUK MENGAMBIL DATA HASIL QUERY
                    while($row = $result_bandara->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['kode_bandara']."</td>";
                        echo "<td>".$row['nama_bandara']."</td>";
                        echo "<td>".$row['alamat_bandara']."</td>";
                        echo "<td><a href='update.php?id=".$row['id']."'>Update</a></td>";
                        echo "<td><a href='delete.php?id=".$row['id']."'>Delete</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                }else{
                    echo "<tr><td colspan='5'>Tidak ada data yang ditampilkan</td></tr>";
                }
            ?>
        </table>
    </body>
</html>