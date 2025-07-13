<?php

class Remainders extends Controller
{
    private $remainderModel;
    private $userModel;
    private $userId;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['auth'])) {
            header('Location: /login');
            die;
        }

        $this->remainderModel = $this->model('Remainder');
        $this->userModel = $this->model('User');

        $username = $_SESSION['username'] ?? '';
        $user = $this->userModel->get_user_by_username($username);

        if (!$user) {
            echo 'User not authorized';
            die;
        }

        $this->userId = $user['id'];
    }

    public function index()
    {
        $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
        $this->view('remainders/index', ['remainders' => $remainders]);
    }

    public function create()
    {
        $this->view('remainders/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = trim($_POST['subject']);
            $description = trim($_POST['description']);

            if ($subject && $description) {
                $this->remainderModel->create_remainder(
                    $this->userId,
                    htmlspecialchars($subject),
                    htmlspecialchars($description)
                );
            }

            header('Location: /remainders');
            die;
        }
    }

    public function edit($id)
    {
        $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
        $remainder = $this->findRemainder($remainders, $id);

        if (!$remainder) {
            echo 'Remainder not found';
            die;
        }

        $this->view('remainders/edit', ['remainder' => $remainder]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
            $remainder = $this->findRemainder($remainders, $id);

            if (!$remainder) {
                echo 'Remainder not found';
                die;
            }

            $oldRow = $this->remainderModel->get_remainder_by_id($id);

            $subject = trim($_POST['subject']);
            $description = trim($_POST['description']);

            if ($subject && $description) {
                $this->remainderModel->update_remainder(
                    $id,
                    htmlspecialchars($subject),
                    htmlspecialchars($description)
                );
            }

            $newRow = $this->remainderModel->get_remainder_by_id($id);

            $this->view('remainders/edit', [
                'remainder' => $newRow,
                'oldRow' => $oldRow,
                'newRow' => $newRow,
                'updated' => true
            ]);
        }
    }

    public function delete($id)
    {
        $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
        $remainder = $this->findRemainder($remainders, $id);

        if (!$remainder) {
            echo 'Remainder not found';
            die;
        }

        $this->view('remainders/delete', ['remainder' => $remainder]);
    }

    public function confirm_delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
            $oldRow = $this->findRemainder($remainders, $id);

            if (!$oldRow) {
                echo 'Remainder not found';
                die;
            }

            $this->remainderModel->delete_remainder($id);
            $newRow = $this->remainderModel->get_remainder_by_id($id);

            $this->view('remainders/delete', [
                'remainder' => $oldRow,
                'oldRow' => $oldRow,
                'newRow' => $newRow,
                'updated' => true
            ]);
        }
    }

    public function complete($id)
    {
        $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
        $remainder = $this->findRemainder($remainders, $id);

        if (!$remainder) {
            echo 'Remainder not found';
            die;
        }

        $this->view('remainders/complete', ['remainder' => $remainder]);
    }

    public function confirm_complete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $remainders = $this->remainderModel->get_all_remainders_by_id($this->userId);
            $oldRow = $this->findRemainder($remainders, $id);

            if (!$oldRow) {
                echo 'Remainder not found';
                die;
            }

            $this->remainderModel->complete_remainder($id);
            $newRow = $this->remainderModel->get_remainder_by_id($id);

            $this->view('remainders/complete', [
                'remainder' => $oldRow,
                'oldRow' => $oldRow,
                'newRow' => $newRow,
                'updated' => true
            ]);
        }
    }

    private function findRemainder($remainders, $id)
    {
        foreach ($remainders as $rem) {
            if ($rem['id'] == $id) {
                return $rem;
            }
        }
        return null;
    }
}
