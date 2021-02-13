<html>
    <head>
        <title>Form Insert Penumpang</title>
    </head>
    <body>
        <?php
            $server_name = "localhost";
            $name = "root";
            $password = "";
            $database = "penerbangan";

            $connection = new mysqli($server_name, $name, $password, $database);

            $get_id = $_GET['id'];
            $id_penerbangan = 0;
            
            $sql_penumpang = "SELECT penumpang_penerbangan.id,
                penumpang_penerbangan.id_penerbangan,
                customer.nama, customer.alamat, 
                penumpang_penerbangan.status_penumpang 
                FROM penumpang_penerbangan, customer 
                WHERE penumpang_penerbangan.id_penumpang=customer.id 
                    AND penumpang_penerbangan.id=".$get_id;
            // print_r($sql_penumpang);die();
            $result_penumpang = $connection->query($sql_penumpang);
            $data_update = '';
            if($result_penumpang->num_rows>0){
                $data_update = $result_penumpang->fetch_assoc();
            }
            
            $id_penerbangan = $data_update['id_penerbangan'];
        ?>

        <h1>Update Status Penumpang</h1>
        <form method="POST" action="">
            <?php
                echo "Nama Penumpang :".$data_update["nama"];
            ?>
            <select name="status">
                <option value="1">Belum Terbang</option>
                <option value="2">Sudah Terbang</option>
                <option value="3">Batal Terbang</option>
            </select><br/>
            <button type="submit">Update</button>
        </form>

        <?php
            if(count($_POST)>0){
                if(!$connection->connect_error){
                    $sql_update_penumpang = "UPDATE penumpang_penerbangan 
                    SET status_penumpang='".$_POST['status']."' 
                    WHERE id=".$get_id;

                    // print_r($sql_update_customer);die();

                    if($connection->query($sql_update_penumpang)==TRUE){
                        header('location: detail_penerbangan.php?id='.$id_penerbangan);
                    }else{
                        echo "<script>Gagal mengupdate Data</script>".$connection->error;
                    }
                }
            }
        ?>

    </body>
</html>