<html>  
    <head>
        <title>Daftar Penerbangan</title>
        <style>
            table,td,tr,th { border: 1px solid black}
        </style>
    </head>
    <body>
        <?php
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
        <b>Daftar Penerbangan</b>
        <a href="insert_penerbangan.php">Tambah penerbangan</a>
        <a href="index.php">Daftar Bandara</a>
    
        <form action="" method="GET">
            <input type="text" name="keyword" value="<?php echo $keyword; ?>">
            <button type="submit">SEARCH</button>
        </form>

        <table>
            <tr>
                <td>No</td>
                <td>Pesawat</td>
                <td>Bandara Asal</td>
                <td>Bandara Tujuan</td>
                <td>Waktu Penerbangan</td>
                <td>Status Penerbangan</td>
                <td>Detail</td>
                <td>Update</td>
                <td>Delete</td>
            </tr>
            <?php
                $sql_penerbangan = "SELECT 
                    penerbangan.id,
                    penerbangan.waktu_penerbangan,
                    penerbangan.status_penerbangan, 
                    pesawat.kode_pesawat,
                    pesawat.nama_pesawat,
                    bandaraAsal.nama_bandara as bandara_asal,
                    bandaraTujuan.nama_bandara as bandara_tujuan
                    FROM penerbangan, 
                    bandara as bandaraAsal,  bandara as bandaraTujuan,
                    pesawat 
                    WHERE 
                        penerbangan.id_pesawat=pesawat.id AND 
                        penerbangan.id_bandara_dari=bandaraAsal.id AND 
                        penerbangan.id_bandara_tujuan=bandaraTujuan.id 
                    ORDER BY penerbangan.id DESC";
                if($keyword!=""){
                    $sql_penerbangan = "SELECT 
                    penerbangan.id,
                    penerbangan.waktu_penerbangan,
                    penerbangan.status_penerbangan, 
                    pesawat.kode_pesawat,
                    pesawat.nama_pesawat,
                    bandaraAsal.nama_bandara as bandara_asal,
                    bandaraTujuan.nama_bandara as bandara_tujuan
                    FROM penerbangan, 
                    bandara as bandaraAsal,  bandara as bandaraTujuan,
                    pesawat 
                    WHERE 
                        penerbangan.id_pesawat=pesawat.id AND 
                        penerbangan.id_bandara_dari=bandaraAsal.id AND 
                        penerbangan.id_bandara_tujuan=bandaraTujuan.id AND 
                        (
                            bandaraAsal.nama_bandara LIKE '%".$keyword."%' OR 
                            bandaraTujuan.nama_bandara LIKE '%".$keyword."%' OR 
                            pesawat.nama_pesawat LIKE '%".$keyword."%'
                        )
                        ORDER BY penerbangan.id DESC";
                    //keyword='bandara'

                }

                $result_penerbangan = $connection->query($sql_penerbangan);
                if($result_penerbangan->num_rows>0){
                    $i = 1;
                    //PERULANGAN UNTUK MENGAMBIL DATA HASIL QUERY
                    while($row = $result_penerbangan->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$row['kode_pesawat'].' - '.$row['nama_pesawat']."</td>";
                        echo "<td>".$row['bandara_asal']."</td>";
                        echo "<td>".$row['bandara_tujuan']."</td>";
                        echo "<td>".date('d M Y h:i', strtotime($row['waktu_penerbangan']))."</td>";
                        if($row['status_penerbangan']==1)
                            echo "<td>Belum Terbang</td>";
                        else if($row['status_penerbangan']==2)
                            echo "<td>Menunggu Penumpang</td>";
                        else if($row['status_penerbangan']=3)
                            echo "<td>Sudah Terbang</td>";
                        else if($row['status_penerbangan']==4)
                            echo "<td>Sudah Sampai</td>";
                        echo "<td><a href='detail_penerbangan.php?id=".$row['id']."'>Detail</a></td>";
                        echo "<td><a href='update_penerbangan.php?id=".$row['id']."'>Update</a></td>";
                        echo "<td><a href='delete_penerbangan.php?id=".$row['id']."'>Delete</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                }else{
                    echo "<tr><td colspan='9'>Tidak ada data yang ditampilkan</td></tr>";
                }
            ?>
        </table>
    </body>
</html>