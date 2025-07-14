<?php

class Reports extends Controller {

    public function index() {
        session_start();

        if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
            header('Location: /home');
            exit;
        }

        $reminderModel = $this->model('Remainder');
        $userCounts = $reminderModel->getReminderCountsPerUser();

        $userModel = $this->model('User');
        $loginCounts = $userModel->get_login_counts();

        $this->view('reports/index', [
            'userCounts' => $userCounts,
            'loginCounts' => $loginCounts
        ]);
    }
}
