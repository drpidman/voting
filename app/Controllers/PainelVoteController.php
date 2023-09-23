<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserVote;
use Symfony\Component\Routing\RouteCollection;


session_start();

class PainelVoteController
{
	public function showPainel(RouteCollection $routes)
	{
        $homepage = $routes->get('homepage')->getPath();
        $allowvote = $routes->get('painel-vote-control-allow')->getPath();
        
        $user_session = $_SESSION['user'];
    
        if (!isset($user_session)) {
            header('Location: ' . $homepage);
            return;
        }

        require_once APP_ROOT . '/views/painel/votecontrol.php';
	}

    public function registerUser(RouteCollection $routes) {
        $homepage = $routes->get('homepage')->getPath();

        $user_session = $_SESSION['user'];
    
        if (!isset($user_session)) {
            header('Location: ' . $homepage);
            return;
        }

        $username = filter_input(INPUT_POST, "user_name", FILTER_DEFAULT);
        $surname = filter_input(INPUT_POST, "user_surname", FILTER_DEFAULT);
        $cpf = filter_input(INPUT_POST, "user_cpf", FILTER_DEFAULT);

        $complete_name = $username . " " . $surname;

        $user = new UserVote();
        $user->name = $complete_name;
        $user->cpf = $cpf;

        $user_model = new UserModel();

        echo json_encode($user_model->new($user));
    }
}