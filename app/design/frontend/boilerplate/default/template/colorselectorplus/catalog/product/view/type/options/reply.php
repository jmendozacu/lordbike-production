   <?php
        $selected_val='';
          if(isset($_GET['size'])){
            $selected_val = $_GET['size'];
        }
        echo $selected_val;
?>