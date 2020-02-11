
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

  $name = $_POST["name"];
  $newname = $_POST["newname"];
  $sql_delete_all = "DELETE FROM Names";

  if (isset($_POST['delete_all'])) {
    if ($conn->query($sql_delete_all) === TRUE) {
        $successful = true;
    } else {
        throw new Exception("Error deleting records: " . $conn->error);
    }
  }

  if (isset($_POST['delete'])) {
    if ($_POST['selectname'] == '') {
      throw new Exception('Please select a name');
    }

    if (! $error) {
      if (nameAlreadyExists($conn, $name)) {
        $sql_delete = sprintf(
          "DELETE FROM Names WHERE Name = '%s'"
          ,$conn->real_escape_string($name)
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

    if (! $error) {
      if (nameAlreadyExists($conn, $newname)) {
          throw new Exception('Name Already In Database');
      } else {
        $sql_update = sprintf(
          "UPDATE Names SET Name=('$newname') WHERE Name='$name'"
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
$prettyTime = date("H:i");


?>
<!DOCTYPE HTML>
<html>
  <head>
  </head>
  <body>
      Time: <?= $prettyTime ?>
      <h1>DEBUG</h1>
      <pre>
        <?= print_r($_REQUEST, true); ?>
      </pre>
      <h2>Form Test</h2>
      <?php if ($error !== null) { ?>
        <div style="color:red">
          <?= $error ?>
        </div>
      <?php } ?>
      <form action="index.php" method="post">
          Name: <input type="text" name="name" value="<?= $name ?>">
          <button name="create" type="submit">Create</button>
      <!</form>
      <p></p>
      <p>-----Names-----</p>

      <?php
      if ($allselect->num_rows > 0) {
        $a = 0; ?>
        <!<form action="index.php" method="post">
        <?php
        while($row = $allselect->fetch_assoc()) { ?>
            <input type="radio" name="selectname" value=<?php ('$a+1') ?>>
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
    </body>
</html>