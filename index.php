
<?php

// config
register_shutdown_function(function() {
  print_r(error_Get_last());
});
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "myDB";
$error = null;

// bootstrap / db setup

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$successful = false;

try {
  if ($conn->connect_error) {
     throw new Exception("Connection failed: " . $conn->connect_error);
  }

  $name = ( isset($_POST["name"]) ? $_POST['name'] : null);
  $newname = ( isset($_POST["newname"]) ? $_POST['newname'] : null);
  $selectname = ( isset($_POST["selectname"]) ? $_POST['selectname'] : null );
  $sql_delete_all = "DELETE FROM Names";

  if (isset($_POST['delete_all'])) {
    if ($conn->query($sql_delete_all) === TRUE) {
        $successful = true;
    } else {
        throw new Exception("Error deleting records: " . $conn->error);
    }
  }

  if (isset($_POST['delete'])) {
      if (isset($_POST['selectname'])) {
    } else {
      throw new Exception('Please select a name');
    }

    if (! $error) {
      if (nameAlreadyExists($conn, $selectname)) {
        $sql_delete = sprintf(
          "DELETE FROM Names WHERE Name = '%s'"
          ,$conn->real_escape_string($selectname)
        );
        if ($conn->query($sql_delete) === TRUE) {
            $successful = true;
        } else {
            throw new Exception("Error deleting record: " . $conn->error);
        }
      } else {
        throw new Exception('Name Not In Database');
      }
    }
  }

  if (isset($_POST['update'])) {
    if ($_POST['newname'] == '') {
      throw new Exception('Please enter a name');
    }

    if ($_POST['selectname']) {
    } else {
        throw new Exception('Please select a name');
    }

    if (! $error) {
      if (nameAlreadyExists($conn, $newname)) {
          throw new Exception('Name Already In Database');
      } else {
        $sql_update = sprintf(
          "UPDATE Names SET Name=('%s') WHERE Name='%s'",
          $conn->real_escape_string($newname),
          $conn->real_escape_string($selectname)
        );

          if ($conn->query($sql_update) === TRUE) {
                $successful = true;
            } else {
                throw new Exception("Error: " . $sql_update . "<br>" . $conn->error);

            }

      }
    }
  }

  if (isset($_POST['create'])) {
    if ($_POST['name'] == '') {
      throw new Exception('Please enter a name');
    }

    if (! $error) {
      if (nameAlreadyExists($conn, $name)) {
          throw new Exception('Name Already In Database');
      } else {
        $sql_insert = sprintf(
          "INSERT INTO Names (Name) VALUES('%s')",
          $conn->real_escape_string($name)
        );
          if ($conn->query($sql_insert) === TRUE) {
                $successful = true;
            } else {
                throw new Exception("Error: " . $sql_insert . "<br>" . $conn->error);
            }
      }
    }
  }

} catch(Exception $e) {
  $error = $e->getMessage();
}


function nameAlreadyExists($conn, $n)
{
  $sql_select = sprintf("
       SELECT *
       FROM Names
       WHERE Name = '%s'
   ", $conn->real_escape_string($n));
  $result = $conn->query($sql_select);
  return $result->num_rows != 0;
}

$select = "SELECT * FROM Names";
$allselect = $conn->query($select);
$conn->close();

?>
<!DOCTYPE HTML>
<?php include 'header.php'; ?>
  <body>
    <div class="box grey">
      <!--Debug goes here -->
      <h2>Form Test</h2>
      <?php if ($error !== null) { ?>
        <div style="color:red">
          <?= $error ?>
        </div>
      <?php } ?>
      <form action="index.php" method="post" autocomplete="off">
          <input type="text" name="name" value="">
          <button name="create" type="submit">Create</button>
      <p></p>
      <p>-----Names-----</p>

      <?php
      if ($allselect->num_rows > 0) {
        $a = 0; ?>
        <?php
        while($row = $allselect->fetch_assoc()) { ?>

            <input type="radio" name="selectname" value=<?php echo $row["Name"] ?>>
            <?php echo $row["Name"]. "<br>"; ?>

      <?php  } ?>
      <p></p>
      <p></p>
        <input type="text" name="newname">
        <button name="update" type="submit">Update</button>
        <button name="delete" type="submit">Delete</button>
        <button name="delete_all" type="submit">Delete Everything</button>
      </form>
      <?php
      }
      ?>
    </div>
  </body>
</html>



<?php
//<h1>DEBUG</h1>
//<pre>
//  <?= print_r($_REQUEST, true); ?><?php
//</pre>
?>
