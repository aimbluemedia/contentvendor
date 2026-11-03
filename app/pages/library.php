<?php
$user = require_login();
$status = $_GET['status'] ?? '';
$channel = $_GET['channel'] ?? '';
$search = trim((string) ($_GET['q'] ?? ''));

$where = ['user_id = ?'];
$params = [$user['id']];
if (isset(STATUS_LABELS[$status])) { $where[] = 'status = ?'; $params[] = $status; }
if (isset(CHANNELS[$channel])) { $where[] = 'channel = ?'; $params[] = $channel; }
if ($search !== '') { $where[] = '(title LIKE ? OR body LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }

$items = q('SELECT * FROM content_items WHERE ' . implode(' AND ', $where) . ' ORDER BY updated_at DESC LIMIT 200', $params)->fetchAll();
$campaigns = q('SELECT c.*, (SELECT COUNT(*) FROM content_items i WHERE i.campaign_id = c.id) AS n FROM campaigns c WHERE c.user_id = ? ORDER BY c.created_at DESC LIMIT 20', [$user['id']])->fetchAll();
render('library', ['title' => 'Content library', 'user' => $user, 'items' => $items, 'campaigns' => $campaigns, 'status' => $status, 'channel' => $channel, 'search' => $search]);
