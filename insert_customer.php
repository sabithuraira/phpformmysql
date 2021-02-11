<html>
    <head>
        <title>Insert CUSTOMER</title>
    </head>
    <body>
        <b>Form CUSTOMER</b><br/>
        <form method="POST" action="">
            Nama: <input type="text" name="nama"><br/>
            Nomor KTP: <input type="text" name="nomor_ktp"><br/>
            Alamat: <input type="text" name="alamat"><br/>
            Jenis Kelamin: 
            <select name="jenis_kelamin">
                <option value="1">Laki-laki</option>
                <option value="2">Perempuan</option>
            </select><br/>
            Tanggal Lahir: <input type="date" name="tanggal_lahir"><br/>
            <button type="submit">SIMPAN</button>
        </form>
        <?php
            if(count($_POST)>1){
                $username = "root";
                $password = "";
                $server_name = "localhost";
                $database_name = "penerbangan"; 
            
                $connection = new mysqli($server_name, $username, $password, $database_name);
                if(!$connection->connect_error){
                    $sql_customer = "INSERT INTO customer (nama, 
                        nomor_ktp, alamat, jenis_kelamin,
                        tanggal_lahir, 
                        created_at, updated_at) VALUE(
                        '".$_POST['nama']."',
                        '".$_POST['nomor_ktp']."', 
                        '".$_POST['alamat']."', 
                        '".$_POST['jenis_kelamin']."',
                        '".$_POST['tanggal_lahir']."', 
                        '".date('Y-m-d h:i:s')."', 
                        '".date('Y-m-d h:i:s')."')";

                    if($connection->query($sql_customer) === TRUE){
                        header('Location: index_customer.php');
                    }
                    else{
                        echo "Data gagal dimasukkan:".$connection->error;
                    }
                }
            }
        ?>
    </body>
</html>