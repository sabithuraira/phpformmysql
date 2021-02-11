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
            
            $sql_customer = "SELECT * FROM customer";
            $result_customer = $connection->query($sql_customer);
        ?>

        <h1>Update Data CUSTOMER</h1>
        <form method="POST" action="">
            <select name="penumpang">
                <?php
                while($row = $result_customer->fetch_assoc()){
                    echo "<option value=".$row['id'].">".$row['nama']."</option>";
                }   
                ?>
            </select><br/>
            <button type="submit">Update</button>
        </form>

        <?php
            if(count($_POST)>0){
                if(!$connection->connect_error){
                    $sql_update_customer = "INSERT INTO penumpang_penerbangan 
                    (id_penerbangan, 
                    id_penumpang, status_penumpang, 
                    created_at, updated_at) VALUE(
                    '".$get_id."',
                    '".$_POST['penumpang']."', 
                    '1', 
                    '".date('Y-m-d h:i:s')."', 
                    '".date('Y-m-d h:i:s')."')";

                    if($connection->query($sql_update_customer)==TRUE){
                        header('location: detail_penerbangan.php?id='.$get_id);
                    }else{
                        echo "<script>Gagal mengupdate Data</script>".$connection->error;
                    }
                }
            }
        ?>

    </body>
</html>