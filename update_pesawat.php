<html>
    <head>
        <title>Form Update Pesawat</title>
    </head>
    <body>
        <?php
            $server_name = "localhost";
            $name = "root";
            $password = "";
            $database = "penerbangan";

            $connection = new mysqli($server_name, $name, $password, $database);

            $get_id = $_GET['id'];
            $sql_get_data = "SELECT * FROM pesawat WHERE id=".$get_id;
            $result_data_pesawat = $connection->query($sql_get_data);

            $data_update = '';
            if($result_data_pesawat->num_rows>0){
                $data_update = $result_data_pesawat->fetch_assoc();
            }
        ?>

        <h1>Update Data Pesawat</h1>
        <form method="POST" action="">
            Kode Pesawat : 
            <input type="text" name="kode_pesawat" value="<?php echo $data_update['kode_pesawat'] ?> "><br>
            Tahun Pembuatan :
            <input type="text" name="tahun_pembuatan" value="<?php echo $data_update['tahun_pembuatan'] ?> "><br>
            Nama Pesawat :
            <input type="text" name="nama_pesawat" value="<?php echo $data_update['nama_pesawat'] ?> "><br>
            Nama Maskapai :
            <input type="text" name="nama_maskapai" value="<?php echo $data_update['nama_maskapai'] ?> "><br>

            <button type="submit">Update</button>
        </form>

        <?php
            if(count($_POST)>1){
                if(!$connection->connect_error){
                    $sql_update_pesawat = "UPDATE pesawat SET 
                    kode_pesawat='".$_POST['kode_pesawat']."',
                    tahun_pembuatan='".$_POST['tahun_pembuatan']."',
                    nama_pesawat='".$_POST['nama_pesawat']."',
                    nama_maskapai='".$_POST['nama_maskapai']."',
                    updated_at='".date('Y-m-d h:i:s')."'
                    WHERE id=".$get_id;

                    if($connection->query($sql_update_pesawat)==TRUE){
                        header('location: index_pesawat.php');
                    }else{
                        echo "<script>Gagal mengupdate Data</script>".$connection->error;
                    }
                }
            }
        ?>

    </body>
</html>