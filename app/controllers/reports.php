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

        $loginStats = $userModel->get_login_attempt_summary();
        $userCounts = $remainderModel->get_reminder_counts_per_user();
        usort($userCounts, fn($a, $b) => strcmp($a['username'], $b['username']));
        $allReminders = $remainderModel->get_all_remainders();

        $topUser = null;
        $maxReminders = -1;

        foreach ($userCounts as $row) {
            if ((int)$row['total_reminders'] > $maxReminders) {
                $topUser = [
                    'username' => $row['username'],
                    'total_reminders' => $row['total_reminders'],
                    'completed_count' => $row['completed_count'],
                    'pending_count' => $row['pending_count'],
                    'cancelled_count' => $row['cancelled_count'],
                    'success_count' => 0,
                    'failure_count' => 0
                ];
                $maxReminders = (int)$row['total_reminders'];
            }
        }

        if (!$topUser && count($userCounts) > 0) {
            $first = $userCounts[0];
            $topUser = [
                'username' => $first['username'],
                'total_reminders' => 0,
                'completed_count' => 0,
                'pending_count' => 0,
                'cancelled_count' => 0,
                'success_count' => 0,
                'failure_count' => 0
            ];
        }

        foreach ($loginStats as $loginRow) {
            if ($loginRow['username'] === $topUser['username']) {
                $topUser['success_count'] = $loginRow['success_count'];
                $topUser['failure_count'] = $loginRow['failure_count'];
                break;
            }
        }

        $this->view('reports/index', [
            'loginStats' => $loginStats,
            'userCounts' => $userCounts,
            'allReminders' => $allReminders,
            'topUser' => $topUser
        ]);
    }
}
