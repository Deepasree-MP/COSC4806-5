<?php

class Reports extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['auth']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $userModel = $this->model('User');
        $remainderModel = $this->model('Remainder');

        
        $loginCounts = $userModel->get_login_counts();
        $userCounts = $remainderModel->get_reminder_counts_per_user();
        $allReminders = $remainderModel->get_all_remainders();

        
        $loginStats = $userModel->get_login_attempt_stats();

        
        $topUser = null;
        $maxReminders = -1;
        foreach ($userCounts as $row) {
            if ((int)$row['total_reminders'] > $maxReminders) {
                $topUser = $row;
                $maxReminders = (int)$row['total_reminders'];
            }
        }

        
        $this->view('reports/index', [
            'loginCounts' => $loginCounts,     
            'loginStats' => $loginStats,       
            'userCounts' => $userCounts,
            'allReminders' => $allReminders,
            'topUser' => $topUser
        ]);
    }
}
