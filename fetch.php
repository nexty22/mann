<?php
if(!isset($_GET['url'])) die("No URL provided");

$url = trim($_GET['url']);

// Extract video ID
parse_str(parse_url($url, PHP_URL_QUERY), $vars);
$videoId = $vars['v'] ?? basename(parse_url($url, PHP_URL_PATH));

$api = "https://fam-official.serv00.net/api/ytapi.php?video=".$videoId;
$json = @file_get_contents($api);
if(!$json) die("API not responding");

$data = json_decode($json, true);
if(!$data || !$data['success']) die("Invalid video or API error");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Select Quality • NEXTY</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="box">
  <h2><?= htmlspecialchars($data['details']['title']) ?></h2>
  <img src="<?= htmlspecialchars($data['details']['thumbnail']) ?>">

  <?php foreach($data['formats'] as $f): ?>
    <a class="btn" href="<?= htmlspecialchars($f['url']) ?>" target="_blank">
      <?= strtoupper($f['type']) ?> | <?= $f['quality'] ?> | <?= $f['size'] ?>
    </a>
  <?php endforeach; ?>

  <p class="credit">Made by <b>NEXTY</b> ❤️</p>
</div>

</body>
</html>
