<?php
/**
 * Created by PhpStorm.
 * User: KhoSeokHyun
 * Date: 2016-09-25
 * Time: 오후 7:26
 */

session_start();

require_once "connectvar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['id']) && !empty($_POST['pwd'])) {
        $id = $_POST['id'];
        $pwd = $_POST['pwd'];

        $query = "SELECT * FROM users WHERE id='$id' AND password=SHA1('$pwd')";

        $result = $conn->query($query);
        if(!$result) die("Database access failed: " . $conn->error);

        if ($result->num_rows == 1) {
            $result->data_seek(1);

            $_SESSION['is_login'] = true;
            $_SESSION['nickname'] = $result->fetch_assoc()['nickname'];
            header('Location: ./session.php');
            exit;
        } else {
            echo "아이디와 비밀번호를 확인해 주시기 바랍니다.";
        }
    } else {
        echo "아이디와 비밀번호를 정확히 입력해 주시기 바랍니다.";
    }
}

require_once "login.html"
?>