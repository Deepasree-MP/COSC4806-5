<?php

class Reports extends Controller {

    public function index() {
        session_start();

        // Admin-only ACL check
        if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
            header('Location: /home');
            exit;
        }

        $this->view('reports/index');
    }
}
