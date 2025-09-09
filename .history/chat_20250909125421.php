<?php
/****************************************************
 * chat.php — présence + liste des utilisateurs en ligne
 * - Session obligatoire (issue de signup_process.php)
 * - Stockage présence : BDD si config.php sinon JSON fichier
 * - Nettoyage inactifs (> 120 s)
 * - Endpoint JSON: ?list=1 (liste) / ?ping=1 (keepalive)
 ****************************************************/
declare(strict_types=1);
mb_internal_encoding('UTF-8');
session_start();

// ---- 1) Auth minimale
if (empty($_SESSION['user']) || empty($_SESSION['user']['username'])) {
    header('Location: index.html'); exit;
}
$me = $_SESSION['user']; // ['username','age','zip','ville','gender','gender_label','avatar',...]

// ---- 2) Détection BDD (optionnelle)
$useDb = false; $pdo = null;
if (file_exists(__DIR__.'/config.php')) {
    require __DIR__.'/config.php'; // doit définir DB_DSN (+ DB_USER, DB_PASS si besoin)
    try {
        $pdo = new PDO(DB_DSN, DB_USER ?? null, DB_PASS ?? null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $useDb = true;
        // Table "presence" (simple)
        if (stripos(DB_DSN, 'sqlite:') === 0) {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS presence(
                    username TEXT PRIMARY KEY,
                    gender   TEXT NOT NULL,
                    age      INTEGER NOT NULL,
                    zip_code TEXT NOT NULL,
                    ville    TEXT NOT NULL,
                    avatar   TEXT NOT NULL,
                    last_seen INTEGER NOT NULL
                );
            ");
        } else {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS presence(
                    username VARCHAR(32) PRIMARY KEY,
                    gender   ENUM('male','female') NOT NULL,
                    age      TINYINT UNSIGNED NOT NULL,
                    zip_code CHAR(5) NOT NULL,
                    ville    VARCHAR(100) NOT NULL,
                    avatar   VARCHAR(255) NOT NULL,
                    last_seen INT UNSIGNED NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    } catch (Throwable $e) {
        // Si la BDD échoue, on bascule en fichier
        $useDb = false; $pdo = null;
    }
}

// ---- 3) Fonctions présence
function presence_upsert(array $u, $useDb, $pdo): void {
    $now = time();
    if ($useDb && $pdo) {
        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
            $stmt = $pdo->prepare("
                INSERT INTO presence(username,gender,age,zip_code,ville,avatar,last_seen)
                VALUES(:u,:g,:a,:z,:v,:p,:t)
                ON CONFLICT(username) DO UPDATE SET
                  gender=excluded.gender, age=excluded.age, zip_code=excluded.zip_code,
                  ville=excluded.ville, avatar=excluded.avatar, last_seen=excluded.last_seen
            ");
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO presence(username,gender,age,zip_code,ville,avatar,last_seen)
                VALUES(:u,:g,:a,:z,:v,:p,:t)
                ON DUPLICATE KEY UPDATE
                  gender=VALUES(gender), age=VALUES(age), zip_code=VALUES(zip_code),
                  ville=VALUES(ville), avatar=VALUES(avatar), last_seen=VALUES(last_seen)
            ");
        }
        $stmt->execute([
            ':u'=>$u['username'], ':g'=>$u['gender'], ':a'=>$u['age'],
            ':z'=>$u['zip'], ':v'=>$u['ville'], ':p'=>$u['avatar'], ':t'=>$now
        ]);
    } else {
        $dir = __DIR__.'/storage';
        if (!is_dir($dir)) { @mkdir($dir, 0755, true); }
        $file = $dir.'/online_users.json';
        $list = is_file($file) ? json_decode((string)file_get_contents($file), true) : [];
        if (!is_array($list)) $list = [];
        $list[$u['username']] = [
            'username'=>$u['username'],
            'gender'  =>$u['gender'],
            'age'     =>$u['age'],
            'zip_code'=>$u['zip'],
            'ville'   =>$u['ville'],
            'avatar'  =>$u['avatar'],
            'last_seen'=>$now
        ];
        file_put_contents($file, json_encode($list, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }
}

function presence_cleanup($useDb, $pdo, int $ttl=120): void {
    $threshold = time() - $ttl;
    if ($useDb && $pdo) {
        $stmt = $pdo->prepare("DELETE FROM presence WHERE last_seen < :t");
        $stmt->execute([':t'=>$threshold]);
    } else {
        $file = __DIR__.'/storage/online_users.json';
        if (is_file($file)) {
            $list = json_decode((string)file_get_contents($file), true);
            if (!is_array($list)) $list = [];
            foreach ($list as $k=>$v) {
                if (empty($v['last_seen']) || $v['last_seen'] < $threshold) unset($list[$k]);
            }
            file_put_contents($file, json_encode($list, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        }
    }
}

function presence_list($useDb, $pdo): array {
    $now = time(); $threshold = $now - 120;
    if ($useDb && $pdo) {
        $stmt = $pdo->prepare("SELECT username,gender,age,zip_code,ville,avatar,last_seen
                               FROM presence WHERE last_seen >= :t ORDER BY username ASC");
        $stmt->execute([':t'=>$threshold]);
        return $stmt->fetchAll() ?: [];
    } else {
        $file = __DIR__.'/storage/online_users.json';
        if (!is_file($file)) return [];
        $list = json_decode((string)file_get_contents($file), true);
        if (!is_array($list)) return [];
        $out = [];
        foreach ($list as $row) {
            if (!empty($row['last_seen']) && $row['last_seen'] >= $threshold) $out[] = $row;
        }
        usort($out, fn($a,$b)=>strcmp($a['username'],$b['username']));
        return $out;
    }
}

// ---- 4) Endpoints AJAX ?ping=1 / ?list=1
if (isset($_GET['ping'])) {
    presence_upsert($me, $useDb, $pdo);
    presence_cleanup($useDb, $pdo);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok'=>true, 'ts'=>time()]);
    exit;
}
if (isset($_GET['list'])) {
    presence_upsert($me, $useDb, $pdo);
    presence_cleanup($useDb, $pdo);
    $list = presence_list($useDb, $pdo);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['users'=>$list, 'me'=>$me['username']]);
    exit;
}

// ---- 5) Chargement initial : upsert + cleanup
presence_upsert($me, $useDb, $pdo);
presence_cleanup($useDb, $pdo);
$initial = presence_list($useDb, $pdo);

// ---- 6) Vue HTML
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tchat — utilisateurs en ligne</title>
<link rel="stylesheet" href="style/index.css">
<style>
/* Mini styles pour la liste */
.online-wrap{max-width:980px;margin:20px auto;padding:0 12px}
.badge{display:inline-block;padding:2px 8px;border-radius:999px;font-size:12px;background:#0ea5e933;color:#0ea5e9;border:1px solid #0ea5e966}
.user-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;margin-top:14px}
.user-card{display:flex;gap:10px;align-items:center;background:#111827cc;border:1px solid #2b3443;border-radius:12px;padding:10px 12px}
.user-card img{width:44px;height:44px;border-radius:10px;object-fit:cover;border:1px solid #2b3443}
.user-card .meta{line-height:1.2}
.user-card .name{font-weight:800}
.user-card .sub{color:#9aa3b2;font-size:13px}
.empty{margin-top:20px;color:#9aa3b2}
.toolbar{display:flex;justify-content:space-between;align-items:center;margin:12px 0}
</style>
</head>
<body>
<div class="online-wrap">
  <div class="toolbar">
    <h2>Utilisateurs en ligne</h2>
    <span class="badge">Connecté·e : <?= htmlspecialchars($me['username']) ?></span>
  </div>

  <div id="users" class="user-grid">
    <?php if (!$initial): ?>
      <p class="empty">Personne en ligne pour l’instant (à part vous). Ouvrez un deuxième onglet pour tester.</p>
    <?php else: foreach ($initial as $u): ?>
      <div class="user-card" data-user="<?= htmlspecialchars($u['username']) ?>">
        <img src="<?= htmlspecialchars($u['avatar'] ?: 'uploads/avatar_default.jpg') ?>" alt="">
        <div class="meta">
          <div class="name"><?= htmlspecialchars($u['username']) ?> <?= $u['username']===$me['username']? '· <span class="badge">vous</span>':'' ?></div>
          <div class="sub">
            <?= ($u['gender']==='male'?'Homme':'Femme') ?> · <?= (int)$u['age'] ?> ans ·
            <?= htmlspecialchars($u['ville']) ?> (<?= htmlspecialchars($u['zip_code']) ?>)
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>
</div>

<script>
// Ping + refresh liste
function renderList(list, me){
  const wrap = document.getElementById('users');
  if (!wrap) return;
  wrap.innerHTML = '';
  if (!Array.isArray(list) || !list.length){
    wrap.innerHTML = '<p class="empty">Personne en ligne pour l’instant.</p>';
    return;
  }
  list.forEach(u=>{
    const card = document.createElement('div');
    card.className='user-card';
    card.dataset.user = u.username;
    const img = document.createElement('img');
    img.src = u.avatar || 'uploads/avatar_default.jpg';
    const meta = document.createElement('div'); meta.className='meta';
    const name = document.createElement('div'); name.className='name';
    name.innerHTML = u.username + (u.username===me ? ' · <span class="badge">vous</span>' : '');
    const sub = document.createElement('div'); sub.className='sub';
    sub.textContent = (u.gender==='male'?'Homme':'Femme')+' · '+(u.age||'')+' ans · '+u.ville+' ('+u.zip_code+')';
    meta.appendChild(name); meta.appendChild(sub);
    card.appendChild(img); card.appendChild(meta);
    wrap.appendChild(card);
  });
}

async function tick(){
  try { await fetch('chat.php?ping=1', {credentials:'same-origin'}); } catch(e){}
  try {
    const r = await fetch('chat.php?list=1', {credentials:'same-origin'});
    const j = await r.json();
    renderList(j.users, j.me);
  } catch(e){}
}
tick();
setInterval(tick, 20000); // toutes les 20s
</script>
</body>
</html>
