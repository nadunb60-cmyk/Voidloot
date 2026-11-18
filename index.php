<?php
require __DIR__ . '/config.php';
$term = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$sql = "SELECT * FROM games WHERE 1";
$args = [];
if ($term !== '') { $sql .= " AND (title LIKE ? OR developer LIKE ? OR genre LIKE ?)"; $like = "%$term%"; array_push($args, $like, $like, $like); }
if ($category !== '') { $sql .= " AND genre = ?"; $args[] = $category; }
$sql .= " ORDER BY featured DESC, created_at DESC";
$stmt = db()->prepare($sql); $stmt->execute($args); $games = $stmt->fetchAll();
$categories = db()->query("SELECT DISTINCT genre FROM games WHERE genre <> '' ORDER BY genre")->fetchAll(PDO::FETCH_COLUMN);
$featured = db()->query("SELECT * FROM games WHERE featured=1 ORDER BY created_at DESC LIMIT 1")->fetch();
$popular = db()->query("SELECT id,title,cover_url FROM games ORDER BY views DESC, created_at DESC LIMIT 5")->fetchAll();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>VOIDLOOT | Discover PC Games</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="logo" href="index.php">VOID<span>LOOT</span></a><nav><a href="index.php">Discover</a><a href="#library">Games</a><a href="admin/index.php">Admin</a></nav><form class="top-search" method="get"><input name="q" placeholder="Search games..." value="<?=e($term)?>"><button>Search</button></form></header>
<main class="shell">
<?php if ($featured): ?><section class="hero" style="--hero:url('<?=e($featured['cover_url'])?>')"><div class="hero-copy"><span class="eyebrow">FEATURED TRANSMISSION</span><h1><?=e($featured['title'])?></h1><p><?=e(mb_strimwidth($featured['description'],0,190,'…'))?></p><a class="btn primary" href="game.php?id=<?=$featured['id']?>">Explore game <b>↗</b></a></div></section><?php endif; ?>
<div class="layout"><aside class="side"><h3>EXPLORE</h3><a class="side-link" href="index.php">All games</a><?php foreach($categories as $c): ?><a class="side-link" href="?category=<?=urlencode($c)?>"><?=e($c)?></a><?php endforeach; ?><div class="side-note"><b>VOIDLOOT</b><p>Enter the void. Find your next game.</p></div></aside>
<section id="library" class="catalog"><div class="section-head"><div><span class="eyebrow">THE GAME VAULT</span><h2><?= $category ? e($category) : 'Discover games' ?></h2></div><span class="muted"><?=count($games)?> titles found</span></div>
<div class="cards"><?php foreach($games as $g): ?><a class="game-card" href="game.php?id=<?=$g['id']?>"><div class="cover"><img src="<?=e($g['cover_url'])?>" alt="<?=e($g['title'])?>" loading="lazy"><span class="cover-tag"><?=e($g['genre'])?></span></div><div class="game-info"><h3><?=e($g['title'])?></h3><p><?=e($g['developer'])?> · <?=e($g['release_date'])?></p></div></a><?php endforeach; ?><?php if(!$games): ?><p class="muted">No games found. Try another search.</p><?php endif; ?></div></section>
<aside class="right"><h3>POPULAR SIGNALS</h3><?php foreach($popular as $p): ?><a class="popular" href="game.php?id=<?=$p['id']?>"><img src="<?=e($p['cover_url'])?>" alt=""><span><?=e($p['title'])?></span></a><?php endforeach; ?><div class="right-box"><span class="eyebrow">GOOD TO KNOW</span><p>Download links on VOIDLOOT point to official publishers, authorised stores and legitimate free-game projects.</p></div></aside></div></main><footer>© <?=date('Y')?> VOIDLOOT <span>ENTER THE VOID. FIND YOUR NEXT GAME.</span></footer></body></html>
