<?php
session_start();
if(isset($_POST['submit'])){

    include 'dbh.php';

    //mysqli_real_escape_string - proverava dali korisnik unosi sumnjiv(opasan)kod
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    //Error handlers
    //Check if inputs are empty
    if(empty($uid) || empty($pwd)){

        header("Location: ../index.php?login=empty");
        exit();

    }
    else{

        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);

        //Check if user exist
        if(!$resultCheck>0){

            header("Location: ../index.php?login=nosuchuser");
            exit();

        }else{

            //mysqli_fetch_assoc - Returns an associative array that corresponds to the fetched row or NULL if there are no more rows.
            if($row = mysqli_fetch_assoc($result)){ 

                //De-hashing password and checking the equality
                $hashedPwdCheck = password_verify($pwd,$row['user_pwd']);

                if($hashedPwdCheck != true){

                    header("Location: ../index.php?login=error");
                    exit();

                }else{

                    //Log in the user here
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];

                    header("Location: ../index.php?login=succsess");
                    exit();
                }


            }
        }
    }

}else{
    header("Location: ../index.php");
    exit();
}

?>