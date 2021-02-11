<html>
    <head>
        <title>Form Update CUSTOMER</title>
    </head>
    <body>
        <?php
            $server_name = "localhost";
            $name = "root";
            $password = "";
            $database = "penerbangan";

            $connection = new mysqli($server_name, $name, $password, $database);

            $get_id = $_GET['id'];
            $sql_get_data = "SELECT * FROM customer WHERE id=".$get_id;
            $result_data_customer = $connection->query($sql_get_data);

            $data_update = '';
            if($result_data_customer->num_rows>0){
                $data_update = $result_data_customer->fetch_assoc();
            }
        ?>

        <h1>Update Data CUSTOMER</h1>
        <form method="POST" action="">
            Nama : 
            <input type="text" name="nama" value="<?php echo $data_update['nama'] ?>"><br>
            NOmor KTP :
            <input type="text" name="nomor_ktp" value="<?php echo $data_update['nomor_ktp'] ?>"><br>
            Alamat :
            <input type="text" name="alamat" value="<?php echo $data_update['alamat'] ?>"><br>
            Jenis Kelamin :
            <select name="jenis_kelamin">
                <option value="1" <?php if($data_update['jenis_kelamin']==1) echo 'selected="selected"'; ?>>Laki-laki</option>
                <option value="2" <?php if($data_update['jenis_kelamin']==2) echo 'selected="selected"'; ?> >Perempuan</option>
            </select><br/>
            Tanggal Lahir :
            <input type="date" name="tanggal_lahir" value="<?php echo $data_update['tanggal_lahir'] ?>"><br>
            <button type="submit">Update</button>
        </form>

        <?php
            if(count($_POST)>1){
                if(!$connection->connect_error){
                    $sql_update_customer = "UPDATE customer SET 
                    nama='".$_POST['nama']."',
                    nomor_ktp='".$_POST['nomor_ktp']."',
                    alamat='".$_POST['alamat']."',
                    jenis_kelamin='".$_POST['jenis_kelamin']."',
                    tanggal_lahir='".$_POST['tanggal_lahir']."',
                    updated_at='".date('Y-m-d h:i:s')."'
                    WHERE id=".$get_id;

                    if($connection->query($sql_update_customer)==TRUE){
                        header('location: index_customer.php');
                    }else{
                        echo "<script>Gagal mengupdate Data</script>".$connection->error;
                    }
                }
            }
        ?>

    </body>
</html>