<?php
require_once(SRC_PATH . '/model/model-journal.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: /?page=login');
    exit;
}

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$total = getJournalConnexionsCount();
$notifications = getJournalConnexionsWithUsersLimit($limit, $offset);

require_once(SRC_PATH . '/view/view-notifications.php');
