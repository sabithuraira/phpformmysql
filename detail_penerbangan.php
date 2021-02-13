<html>
    <head>
        <title>Form Detail penerbangan</title>
        
        <style>
            /* MENAMPILKAN BORDER PADA TABLE */
            table,td,tr,th { border: 1px solid black}
        </style>
    </head>
    <body>
        <?php
            $server_name = "localhost";
            $name = "root";
            $password = "";
            $database = "penerbangan";

            $connection = new mysqli($server_name, $name, $password, $database);

            $get_id = $_GET['id'];
            $sql_get_data = "SELECT 
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
                    penerbangan.id=".$get_id;

            $result_data_penerbangan = $connection->query($sql_get_data);

            $data_update = '';
            if($result_data_penerbangan->num_rows>0){
                $data_update = $result_data_penerbangan->fetch_assoc();
            }
        ?>

        <h1>Detail Data penerbangan</h1>
            <?php echo "Pesawat:  ".$data_update['nama_pesawat'] ?><br/>
            <?php echo "Bandara Dari:  ".$data_update['bandara_asal'] ?><br/>
            <?php echo "Bandara Tujuan:  ".$data_update['bandara_tujuan'] ?><br/>
            <?php echo "Waktu Penerbangan:  ".date('d M Y h:i', strtotime($data_update['waktu_penerbangan']))  ?><br/>
            <?php
                if($data_update['status_penerbangan']==1) 
                    echo "Status Penerbangan:  Belum Terbang";
                else if($data_update['status_penerbangan']==2)
                    echo "Status Penerbangan:  Menunggu Terbang";
                else if($data_update['status_penerbangan']==3)
                    echo "Status Penerbangan:  Sudah Terbang";
                else if($data_update['status_penerbangan']==2)
                    echo "Status Penerbangan:  Sudah Sampai";
                
            ?><br/>
            
        <hr/>

        <a href="insert_penumpang.php?id=<?php echo $data_update['id']; ?>">Tambah Penumpang</a>
        <table>
            <tr>
                <td>Nomor</td>
                <td>Nama</td>
                <td>Alamat</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        <?php 
            $sql_penumpang = "SELECT  
                penumpang_penerbangan.id,
                customer.nama, 
                customer.alamat,
                penumpang_penerbangan.status_penumpang 
                FROM penumpang_penerbangan, 
                customer WHERE
                penumpang_penerbangan.id_penumpang=customer.id AND 
                penumpang_penerbangan.id_penerbangan=".$get_id;
            

            $result_penumpang = $connection->query($sql_penumpang);
            if($result_penumpang->num_rows>0){
                $i = 1;
                //PERULANGAN UNTUK MENGAMBIL DATA HASIL QUERY
                while($row = $result_penumpang->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$row['nama']."</td>";
                    echo "<td>".$row['alamat']."</td>";
                    if($row['status_penumpang']==1)
                        echo "<td>Belum Terbang</td>";
                    else if($row['status_penumpang']==2)
                        echo "<td>Sudah Terbang</td>";
                    else
                        echo "<td>Batal Terbang</td>";  
                    echo "<td><a href='update_status.php?id=".$row['id']."'>Update Status</a></td>";    
                    echo "</tr>";
                    $i++;
                }
            }else{
                echo "<tr><td colspan='4'>Tidak ada data yang ditampilkan</td></tr>";
            }
        ?>
        </table>
    </body>
</html>