<?php

class AuthController {
        public function login() {
            
            include  './config/koneksi.php';

            if (isset($_POST['login'])) {  
                $username=$_POST['username'];
                $password=$_POST['password'];    

                $sql_login = "SELECT * FROM users WHERE BINARY username='$username'";
                $query_login = mysqli_query($conn, $sql_login);
                $data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
                $jumlah_login = mysqli_num_rows($query_login);
                
                if ($jumlah_login == 1 ){
                    if (password_verify($password, $data_login['password'])) {
                        session_start();
                        $_SESSION["ses_id"]=$data_login["id_user"];
                        $_SESSION["ses_nama"]=$data_login["fullname"];
                        $_SESSION["ses_username"]=$data_login["username"];
                        $_SESSION["ses_level"]= $data_login["level"];
                        echo "<script>
                        Swal.fire({title: 'Login Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'index.php?page=dashboard';
                            }
                        })</script>";
                    }else{
                        echo "<script>
                        Swal.fire({title: 'Invalid password',text: '',icon: 'error',confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.value) {
                                window.location = 'login.php';
                            }
                        })</script>";
                }
            }else{
                echo "<script>
                    Swal.fire({title: 'Invalid username or password',text: '',icon: 'error',confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location = 'login.php';
                        }
                    })</script>";
            }
        }
    }


    public function register(){
        include "./config/koneksi.php";
        if (isset($_POST['register'])) {
            $username = trim($_POST['username']);
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];
            $email = trim($_POST['email']);
            $alamat = $_POST['alamat'];
        
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $checkUser = $conn->prepare("SELECT * FROM users WHERE email=? Or username=?");
            $checkUser->bind_param("ss", $email , $username);
            $checkUser->execute();
        
            if ($checkUser->get_result()->num_rows > 0) {
                echo "<script>
                Swal.fire({title: 'Username Or Email already taken! Please use another Username.',text: '',icon: 'error',confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'register.php';
                    }
                })</script>";
            } else {
                $tambahData = $conn->prepare("INSERT INTO users (username, password, email, fullname, alamat) VALUES (?,?,?,?,?)");
                $tambahData->bind_param("sssss", $username, $hashedPassword, $email, $fullname, $alamat);
                $tambahData->execute();
                echo "<script>
                    Swal.fire({title: 'Berhasil',text: '',icon: 'error',confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location = 'login.php';
                        }
                    })</script>";
            }
        } 
    }
}


?>
