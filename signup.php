<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Title</title>
</head>
<body>

<?php

require_once "connectvar.php";

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = $nName = $pwd1 = $pwd2 = "";


// check validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["id"])) {
        $idErr = "ID is required";
    } else {
        $id = test_input($_POST["id"]);
    }

    if (empty($_POST["nName"])) {
        $nNameErr = "Nickname is required";
    } else {
        $nName = test_input($_POST["nName"]);
    }

    if (empty($_POST["pwd1"])) {
        $pwdErr1 = "Password is required";
    } else {
        $pwd1 = test_input($_POST["pwd1"]);
    }

    if (empty($_POST["pwd2"])) {
        $pwdErr2 = "Password(retype) is required";
    } else {
        $pwd2 = test_input($_POST["pwd2"]);
    }


    if (!empty($id) && !empty($nName) && !empty($pwd1) && !empty($pwd2)) {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result = $conn->query($query);
        if (!$result) die("Database access failed: " . $conn->error);

        if ($result->num_rows > 0) {
            echo "이 아이디는 이미 존재하는 아이디입니다.";
        } else {
            $query = "SELECT * FROM users WHERE nickname = '$nName'";
            $result = $conn->query($query);
            if (!$result) die("Database access failed: " . $conn->error);

            if ($result->num_rows > 0) {
                echo "이미 사용중인 닉네임입니다.";
            } else {
                if($pwd1 != $pwd2) {
                    echo "비밀번호와 비밀번호(retype)가 다릅니다.";
                } else {
                    $query = "INSERT INTO users (nickname, id, password) VALUE ('$nName', '$id', SHA1('$pwd1'))";

                    if ($conn->query($query) === TRUE) {
                        echo "New data created successfully";
                    } else {
                        echo "Error: " . $query . "<br>" . $conn->error;
                    }
                }
            }
        }

        $result->close();
    } else {
        echo "모든 데이터를 정확하게 채워 넣어 주시기 바랍니다.";
    }
}

$conn->close();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<h2>회원가입</h2>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    ID: <input type="text" id="id" name="id">
    <span class="error"><?php echo $idErr; ?></span><br>
    NickName: <input type="text" id="nName" name="nName">
    <span class="error"><?php echo $nNameErr; ?></span><br>
    PASSWORD: <input type="text" id="pwd1" name="pwd1">
    <span class="error"><?php echo $pwdErr1; ?></span><br>
    PASSWORD(retype): <input type="text" id="pwd2" name="pwd2">
    <span class="error"><?php echo $pwdErr2; ?></span><br>
    <input type="submit" value="Sign up" name="submit">
</form>

</body>
</html>