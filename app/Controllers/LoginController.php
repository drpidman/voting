<?php
namespace App\Controllers;

use App\Models\AdminUser;
use Symfony\Component\Routing\RouteCollection;

session_start();

class LoginController {
    public function showAction(RouteCollection $routes)
    {
        $panel = $routes->get('painel')->getPath();

        if (isset($_SESSION['user'])) {
            header('Location: ' . $panel);
        }

        if (isset($_POST['username']) or isset($_POST['password'])) {

            $password = $_POST['password'];

            $users = new AdminUser();
            $user = $users->getUser($_POST['username'], $_POST['password']);

            if (!isset($user)) {
                $error = "Email ou senha invalidos";
                require_once APP_ROOT . '/views/auth/login.php';
                return;
            }
            
            if (password_verify($password, $user->password)) {
                $_SESSION['user'] = $user;
                header('Location: ' . $panel);
            } else {
                $error = "Email ou senha invalidos";
            }
        }

        require_once APP_ROOT . '/views/auth/login.php';
    }
}