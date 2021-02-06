<html>
    <head>
        <title>Insert MySQL dg FORM</title>
    </head>
    <body>
        <b>Form Bandara</b><br/>
        <form method="POST" action="">
            Kode Bandara: <input type="text" name="kode_bandara"><br/>
            Nama Bandara: <input type="text" name="nama_bandara"><br/>
            Alamat Bandara: <input type="text" name="alamat_bandara"><br/>
            <button type="submit">SIMPAN</button>
        </form>
        <?php
            //JIKA ADA VARIBEL POST, MAKA JALANKAN KODE INI
            //VARIABEL POST DIDAPATKAN DARI PROSES KETIKA SIMPAN DATA
            //ATAU KLIK SUBMIT
            if(count($_POST)>1){
                $username = "root";
                $password = "";
                $server_name = "localhost";
                $database_name = "penerbangan"; 
            
                $connection = new mysqli($server_name, $username, $password, $database_name);
                if(!$connection->connect_error){
                    $sql_bandara = "INSERT INTO bandara (kode_bandara, 
                        nama_bandara, alamat_bandara, created_at, 
                        updated_at) VALUE(
                        '".$_POST['kode_bandara']."',
                        '".$_POST['nama_bandara']."', 
                        '".$_POST['alamat_bandara']."', 
                        '".date('Y-m-d h:i:s')."', 
                        '".date('Y-m-d h:i:s')."')";

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