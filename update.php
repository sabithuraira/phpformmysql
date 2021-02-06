<html>
    <head>
        <title>Update MySQL dg FORM</title>
    </head>
    <body>
        <?php 
            $username = "root";
            $password = "";
            $server_name = "localhost";
            $database_name = "penerbangan"; 
            $connection = new mysqli($server_name, $username, $password, $database_name);
            //MENGAMBIL NILAI ID YANG ADA PADA URL
            $id_data = $_GET['id'];
            $sql_get_data = "SELECT * FROM bandara WHERE id=".$id_data;
            $result_get_data = $connection->query($sql_get_data);
            //JIKA DATA YANG DIHASILKAN LEBIH DARI 0
            $data_diupdate = '';
            if($result_get_data->num_rows>0){
                //DEFINISIKAN VARIABEL PERTAMA SEBAGAI DATA YANG AKAN DI UPDATE
                $data_diupdate = $result_get_data->fetch_assoc();
            }
        ?>  
        <b>Form Bandara</b><br/>
        <form method="POST" action="">
            Kode Bandara: <input type="text" name="kode_bandara" value="<?php echo $data_diupdate['kode_bandara']; ?>"><br/>
            Nama Bandara: <input type="text" name="nama_bandara" value="<?php echo $data_diupdate['nama_bandara']; ?>"><br/>
            Alamat Bandara: <input type="text" name="alamat_bandara" value="<?php echo $data_diupdate['alamat_bandara']; ?>"><br/>
            <button type="submit">SIMPAN</button>
        </form>
        <?php
            if(count($_POST)>1){
                if(!$connection->connect_error){
                    $sql_bandara = "UPDATE bandara SET 
                        kode_bandara= '".$_POST['kode_bandara']."',
                        nama_bandara='".$_POST['nama_bandara']."', 
                        alamat_bandara='".$_POST['alamat_bandara']."',  
                        updated_at='".date('Y-m-d h:i:s')."' 
                        WHERE id=".$id_data;

                    if($connection->query($sql_bandara) === TRUE){
                        header('Location: index.php');
                    }
                    else{
                        echo "Data gagal dimasukkan:".$connection->error;
                    }
                }
            }
        ?>
    </body>
</html>