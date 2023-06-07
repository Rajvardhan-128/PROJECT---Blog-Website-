<?php
$conn = mysqli_connect("localhost", "root", "", "uploadphp") or die(mysqli_error($conn));

if (isset($_POST['submit'])) {
  $name = $_FILES['photo']['name'];
  $size = $_FILES['photo']['size'];
  $type = $_FILES['photo']['type'];
  $temp = $_FILES['photo']['tmp_name'];
  $caption1 = $_POST['caption'];
  $link = $_POST['link'];

  if (!empty($name)) {
    $stmt = mysqli_prepare($conn, "INSERT INTO upload (name) VALUES (?)");
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);

    move_uploaded_file($temp, "upload/" . $name);

    header("location:upload.php");
    exit();
  } else {
    echo "Please select a file to upload.";
  }
}

$select = mysqli_query($conn, "SELECT * FROM upload ORDER BY id DESC");
?>

<html>
<head>
  <title>Upload And Download Files In PHP</title>
  <link rel="stylesheet" href="upload.css" />
</head>
<body>
  <h3><p align="center">Upload And Download Files In PHP</p></h3>
  <form enctype="multipart/form-data" action="" name="form" method="post">
    <table border="0" cellspacing="0" cellpadding="5" id="table">
      <tr>
        <th>Upload File</th>
        <td><label for="photo"></label>
          <input type="file" name="photo" id="photo" /></td>
      </tr>
      <tr>
        <th colspan="2" scope="row"><input type="submit" name="submit" id="submit" value="Submit" /></th>
      </tr>
    </table>
  </form>
  <br />
  <br />
  <table border="1" align="center" id="table1" cellpadding="0" cellspacing="0">
    <tr><td align="center">Download File</td></tr>
    <?php while($row1=mysqli_fetch_array($select)) {
      $name=$row1['name'];
      $id=$row1['id'];
    ?>
    <tr>
      <td width="300">
        <?php echo $id;?>. <a href="download.php?filename=<?php echo $name;?>"><?php echo $name;?></a><td align="center"><a href="delete.php?id=<?php echo $row1["id"]; ?>">Delete</a></td>
      </td>
    </tr>
    <?php }?>
  </table>
</body>
</html>
