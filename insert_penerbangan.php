<html>
    <head>
        <title>Insert Penerbangan</title>
    </head>
    <body>
        <b>Form Penerbangan</b><br/>
        <?php
            $username = "root";
            $password = "";
            $server_name = "localhost";
            $database_name = "penerbangan"; 
        
            $connection = new mysqli($server_name, $username, $password, $database_name);
            
            $sql_pesawat = "SELECT * FROM pesawat";
            $result_pesawat = $connection->query($sql_pesawat);

            $sql_bandara = "SELECT * FROM bandara";
            $result_bandara = $connection->query($sql_bandara);
            $result_bandara_tujuan = $connection->query($sql_bandara);
        ?>
        <form method="POST" action="" onsubmit="return periksaAsalTujuan()">
            Pesawat: 
            <select name="id_pesawat">
                <?php
                while($row = $result_pesawat->fetch_assoc()){
                    echo "<option value=".$row['id'].">".$row['nama_pesawat']."</option>";
                }
                ?>
            </select>
            <br/>
            Bandara Asal: 
            <select name="id_bandara_dari" id="bandara_dari" onchange="periksaAsalTujuan()">
            <?php
                while($row = $result_bandara->fetch_assoc()){
                    echo "<option value=".$row['id'].">".$row['nama_bandara']."</option>";
                }
                ?>
            </select>
            <br/>
            Bandara Tujuan: 
            <select name="id_bandara_tujuan" id="bandara_tujuan" onchange="periksaAsalTujuan()">
            <?php
                while($row = $result_bandara_tujuan->fetch_assoc()){
                    echo "<option value=".$row['id'].">".$row['nama_bandara']."</option>";
                }
                ?>
            </select>
            <br/>
            Waktu Penerbangan: <input type="date" name="tanggal_penerbangan"><input type="time" name="jam_penerbangan"><br/>
            Status: 
            <select name="status_penerbangan">
                <option value="1">Belum Terbang</option>
                <option value="2">Menunggu Penumpang</option>
                <option value="3">Sudah Terbang</option>
                <option value="4">Sudah Sampai</option>
            </select><br/>
            <button type="submit">SIMPAN</button>
        </form>
        <?php
            if(count($_POST)>1){
                if(!$connection->connect_error){
                    $gabung_tanggal = $_POST['tanggal_penerbangan'].' '.$_POST['jam_penerbangan'];
                    $sql_penerbangan = "INSERT INTO penerbangan (id_pesawat, 
                        id_bandara_dari, id_bandara_tujuan, 
                        waktu_penerbangan, status_penerbangan, 
                        created_at, updated_at) VALUE(
                        '".$_POST['id_pesawat']."',
                        '".$_POST['id_bandara_dari']."', 
                        '".$_POST['id_bandara_tujuan']."', 
                        '".$gabung_tanggal."',
                        '".$_POST['status_penerbangan']."', 
                        '".date('Y-m-d h:i:s')."', 
                        '".date('Y-m-d h:i:s')."')";

                    if($connection->query($sql_penerbangan) === TRUE){
                        header('Location: index_penerbangan.php');
                    }
                    else{
                        echo "Data gagal dimasukkan:".$connection->error;
                    }
                }
            }
        ?>
    <script>
        function periksaAsalTujuan(){
            var bandara_dari = document.getElementById('bandara_dari').value
            var bandara_tujuan = document.getElementById('bandara_tujuan').value
            if(bandara_dari==bandara_tujuan){
                alert("Pilihan Bandara Tidak Boleh Sama");
                return false
            }
            else{
                return true
            }
        }
    </script>
    </body>
</html>