<?php
require_once(SRC_PATH . '/model/model-journal.php');
session_start();

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$total = getJournalConnexionsCount();

$notifications = getJournalConnexionsWithUsersLimit($limit, $offset);

require_once(SRC_PATH . '/view/view-notifications.php');
