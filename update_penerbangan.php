<html>
    <head>
        <title>Form Update penerbangan</title>
    </head>
    <body>
        <?php
            $server_name = "localhost";
            $name = "root";
            $password = "";
            $database = "penerbangan";

            $connection = new mysqli($server_name, $name, $password, $database);

            $get_id = $_GET['id'];
            $sql_get_data = "SELECT * FROM penerbangan WHERE id=".$get_id;
            $result_data_penerbangan = $connection->query($sql_get_data);

            $data_update = '';
            if($result_data_penerbangan->num_rows>0){
                $data_update = $result_data_penerbangan->fetch_assoc();
            }

            $sql_pesawat = "SELECT * FROM pesawat";
            $result_pesawat = $connection->query($sql_pesawat);

            $sql_bandara = "SELECT * FROM bandara";
            $result_bandara = $connection->query($sql_bandara);
            $result_bandara_tujuan = $connection->query($sql_bandara);
        ?>

        <h1>Update Data penerbangan</h1>
        <form method="POST" action="">
            Pesawat: 
            <select name="id_pesawat">
                <?php
                while($row = $result_pesawat->fetch_assoc()){
                    $is_selected = "";
                    if($row['id']==$data_update['id_pesawat']) $is_selected='selected="selected"';
                    echo "<option value=".$row['id']." ".$is_selected.">".$row['nama_pesawat']."</option>";
                    //<option value=1">Lion Air</option>
                    //<option value=2" >Garuda</option>
                    //<option value=3" selected="selected" >Sriwijaya Air</option>
                }
                ?>
            </select><br/>
            Bandara Asal: 
            <select name="id_bandara_dari">
                <?php
                while($row = $result_bandara->fetch_assoc()){
                    $is_selected = "";
                    if($row['id']==$data_update['id_bandara_dari']) $is_selected='selected="selected"';
                    echo "<option value=".$row['id']." ".$is_selected.">".$row['nama_bandara']."</option>";
                }
                ?>
            </select><br/>
            Bandara Tujuan: 
            <select name="id_bandara_tujuan">
                <?php
                while($row = $result_bandara_tujuan->fetch_assoc()){
                    $is_selected = "";
                    if($row['id']==$data_update['id_bandara_tujuan']) $is_selected='selected="selected"';
                    echo "<option value=".$row['id']." ".$is_selected.">".$row['nama_bandara']."</option>";
                }
                ?>
            </select><br>
            Waktu Penerbangan:
            <?php
                $waktu = $data_update['waktu_penerbangan'];
                $tanggal = date('Y-m-d', strtotime($waktu));
                $jam = date('h:i', strtotime($waktu));
            ?>
            <input type="date" name="tanggal_penerbangan" value="<?php echo $tanggal ?>"><input type="time" name="jam_penerbangan" value="<?php echo $jam ?>"><br/>
            Status: 
            <select name="status_penerbangan">
                <option value="1" <?php if($data_update['status_penerbangan']==1) echo 'selected="selected"'; ?>>Belum Terbang</option>
                <option value="2" <?php if($data_update['status_penerbangan']==2) echo 'selected="selected"'; ?>>Menunggu Penumpang</option>
                <option value="3" <?php if($data_update['status_penerbangan']==3) echo 'selected="selected"'; ?>>Sudah Terbang</option>
                <option value="4" <?php if($data_update['status_penerbangan']==4) echo 'selected="selected"'; ?>>Sudah Sampai</option>
            </select><br/>
            <button type="submit">Update</button>
        </form>

        <?php
            if(count($_POST)>1){
                if(!$connection->connect_error){
                    $gabung_tanggal = $_POST['tanggal_penerbangan'].' '.$_POST['jam_penerbangan'];
                    $sql_update_penerbangan = "UPDATE penerbangan SET 
                    id_pesawat='".$_POST['id_pesawat']."',
                    id_bandara_dari='".$_POST['id_bandara_dari']."',
                    id_bandara_tujuan='".$_POST['id_bandara_tujuan']."',
                    status_penerbangan='".$_POST['status_penerbangan']."',
                    waktu_penerbangan='".$gabung_tanggal."',
                    updated_at='".date('Y-m-d h:i:s')."'
                    WHERE id=".$get_id;

                    if($connection->query($sql_update_penerbangan)==TRUE){
                        header('location: index_penerbangan.php');
                    }else{
                        echo "<script>Gagal mengupdate Data</script>".$connection->error;
                    }
                }
            }
        ?>

    </body>
</html>