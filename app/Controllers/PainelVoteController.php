<?php

namespace App\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\UserVote;
use App\Models\VotesHistory as ModelsVotesHistory;
use App\Models\VoteStatus;
use App\Models\VoteStatusModel;
use Symfony\Component\Routing\RouteCollection;
use VotesHistory;

session_start();

class PainelVoteController implements Controller
{
    /**
     * Rota para exibir a pagina de painel
     */
    public function load(RouteCollection $routes)
    {
        $homepage = $routes->get('homepage')->getPath();
        $allowvote = $routes->get('painel-vote-control-allow')->getPath();
        /**
         * Rotas com user_session requerem que as requisições sejam autenticadas, isso é:
         * Usuario administrador fez login.
         */
        $user_session = $_SESSION['user'];
        /**
         * Validar se existe valores em $_SESSION['user'] e redirecionar caso não exista.
         */
        if (!isset($user_session)) {
            header('Location: ' . $homepage);
            return;
        }

        require_once APP_ROOT . '/views/painel/votecontrol.php';
    }

    /**
     * Rota para registrar um usuario no sistema e autorizar o voto.
     * Rota autenticada apenas para o votecontrol
     */
    public function registerUser(RouteCollection $routes)
    {
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

        $userModel = new UserModel();
        $user = new UserVote();

        $user->name = $complete_name;
        $user->cpf = $cpf;

        if (!$userModel->exists($user->cpf)) {
            $userModel->new($user);
            echo json_encode($userModel->getByCpf($user->cpf));
            
            return;
        } else {
             echo json_encode(
                [
                    "message" => "Usuario já foi registrado, consequentemente já computou um voto.", 
                    "user" => $userModel->getByCpf($user->cpf)
                ]
            );
             http_response_code(401);
        }
    }

    public function getUser(RouteCollection $routes)
    {
        $user_session = $_SESSION['user'];

        if (!isset($user_session)) {
            http_response_code(401);
            return;
        }

        if (!isset($_POST['cpf'])) {
            http_response_code(401);
            return;
        }

        $cpf = filter_input(INPUT_GET, "user_cpf", FILTER_DEFAULT);
        $userModel = new UserModel();

        echo json_encode($userModel->getByCpf($cpf));
    }

    /**
     * Rota para quando um voto for selecionado no home e enviado
     * por webscoket para o painel.
     * Esta rota precisa ser autenticada, ou seja, o painel deve estar "logado"
     * para que o voto seja validado.
     */
    public function onVoteItem(RouteCollection $routes)
    {
        if (!isset($_POST['product_number'])) {
            http_response_code(401);
            return;
        }

        $product_number = $_POST['product_number'];
        $user_cpf = filter_input(INPUT_POST, "user_cpf", FILTER_DEFAULT);

        $productModel = new ProductModel();
        $statusModel = new VoteStatusModel();
        $userModel = new UserModel();
        $historyModel = new ModelsVotesHistory();

        $product = $productModel->getByNumber($product_number);
        $user = $userModel->getByCpf($user_cpf); 
        /*
        * Solução temporaria até completar a nova estrutura
        */
        $user_fixed = new UserVote();
        $user_fixed->name = $user->name;
        $user_fixed->cpf = $user->cpf;

        $history = new History();
        $history->product_id = $product["product_id"];
        $history->user_id = $user->user_id;
        $historyModel->new($history);

        if ($historyModel->getUserVotes($user->user_id)->votes_time >= 2) {
            $statusModel->updateStatus(12, false, $user_fixed);
        }

        echo json_encode([
            "status" => "vote-success",
            $productModel->getByNumber($product_number)
        ]);
    }

    /**
     * Rota para buscar o estado de voto, se já tem uma solicitação aberta ou se 
     * esta liberado para registrar para um novo usuario.
     * Essa rota salva o estado de votação caso a pagina seja recarregada ou o
     * sistema perca a conexão
     */
    public function getVoteStatus(RouteCollection $routes)
    {
        if (!isset($_POST['id'])) {
            http_response_code(401);
            return;
        }

        $id = $_POST['id'];
        $statusModel = new VoteStatusModel();
        $status = $statusModel->getStatus($id);

        echo json_encode($status);
    }

    /**
     * Rota para atualizar o estado de voto para um novo usuario
     * e um novo estado
     */
    public function updateVoteStatus(RouteCollection $routes)
    {
        if (!isset($_POST['id'])) {
            http_response_code(401);
            return;
        }

        $user_session = $_SESSION['user'];

        if (!isset($user_session)) {
            http_response_code(401);
            return;
        }

        $status = new VoteStatusModel();
        $user = new UserVote();

        $id = $_POST['id'];
        $vote_status = filter_input(INPUT_POST, "vote_status", FILTER_VALIDATE_BOOL);

        $username = filter_input(INPUT_POST, "user_name", FILTER_DEFAULT);
        $surname = filter_input(INPUT_POST, "user_surname", FILTER_DEFAULT);
        $cpf = filter_input(INPUT_POST, "user_cpf", FILTER_DEFAULT);
        $complete_name = $username . " " . $surname;

        $user->name = $complete_name;
        $user->cpf = $cpf;
        
        echo json_encode($status->updateStatus($id, $vote_status, $user));
    }
}
