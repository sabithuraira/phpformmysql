<html>
    <head>
        <title>CRUD MySQL with PHP</title>
    </head>
    <body>
        <?php
            $username = "root";
            $password = "";
            $server_name = "localhost";
            $database_name = "penerbangan"; 
            $keyword = "";
            if(count($_GET)){
                $keyword = $_GET['keyword'];
            }

            $connection = new mysqli($server_name, $username, $password, $database_name);

            if($connection->connect_error){
                echo "Error, konfigurasi DB salah";
            }
            else{
                // echo "Database berhasil dikoneksikan";
            }
        ?>

        <b>Daftar Bandara</b>
        <form action="" method="GET">
            <input type="text" name="keyword" placeholder="keyword pencarian.." value="<?php echo $keyword; ?>" />
            <button type="submit">SUBMIT</button>
        </form>
        
        <table>
            <tr>
                <td>Nomor</td>
                <td>Kode Bandara</td>
                <td>Nama Bandara</td>
                <td>Alamat</td>
            </tr>
            <?php
                echo "<br/>";
                if(!$connection->connect_error){ 
                    $sql = "SELECT * FROM bandara";
                    if(count($_GET)){
                        $keyword = $_GET['keyword'];
                        $sql = "SELECT * FROM bandara WHERE nama_bandara LIKE '%".$keyword."%' 
                            OR  kode_bandara LIKE '%".$keyword."%'";
                    }

                    $result_bandara = $connection->query($sql);
                    if($result_bandara->num_rows>0){
                        $i = 1;
                        while($row = $result_bandara->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>".$i."</td>";
                            echo "<td>".$row['kode_bandara']."</td>";
                            echo "<td>".$row['nama_bandara']."</td>";
                            echo "<td>".$row['alamat_bandara']."</td>";
                            echo "</tr>";
                            $i++;
                        }
                    }else{
                        echo "<tr><td colspan='4'></td></tr>";
                    }
                }
            ?>
        </table>
    </body>
</html>

