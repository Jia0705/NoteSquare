<?php
    // 1. connect to database
    $database = connectToDB();

    // simple search + optional "mine" filter
    $search = trim($_GET['q'] ?? '');
    $showMine = isset($_GET['mine']) && isset($_SESSION['user']);

    // 2. load the "publish" posts data
    $sql = "SELECT 
                posts.id, posts.title, posts.content, posts.status, posts.user_id, posts.image, posts.created_at,
                users.name,
                COALESCE(SUM(CASE WHEN likes.type = 1 THEN 1 ELSE 0 END), 0) AS likes_count,
                COALESCE(SUM(CASE WHEN likes.type = 0 THEN 1 ELSE 0 END), 0) AS dislikes_count
            FROM posts 
            JOIN users ON posts.user_id = users.id
            LEFT JOIN likes ON likes.post_id = posts.id
            WHERE posts.status = 'publish'";

    $params = [];

    if ($search !== '') {
        $sql .= " AND (posts.title LIKE :search OR posts.content LIKE :search)";
        $params['search'] = '%' . $search . '%';
    }

    if ($showMine) {
        $sql .= " AND posts.user_id = :user_id";
        $params['user_id'] = $_SESSION['user']['id'];
    }

    $sql .= " GROUP BY posts.id ORDER BY posts.created_at DESC";

    $query = $database->prepare($sql);
    $query->execute($params);
    $posts = $query->fetchAll();

require "parts/header.php"; ?>
<div class="container my-5">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255, 36, 66, 0.12); color: #ff2442; font-weight: 700; letter-spacing: 0.02em;">
            <i class="bi bi-stars"></i> Discover posts
        </div>
        <h1 class="display-5 fw-bold mt-3" style="color: #1d1d1f;">Fresh notes and stories</h1>
        <p class="text-muted mb-0 fs-5">Search, skim, and open any post.</p>
    </div>

    <form class="card ig-card p-4 mb-4" method="GET" action="<?= BASE_PATH ?>/">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" class="form-control form-control-lg" name="q" value="<?= e($search); ?>" placeholder="Search by title or content">
            </div>
            <div class="col-md-3">
                <?php if (isset($_SESSION['user'])) : ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="mine" name="mine" <?= $showMine ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="mine">
                            Show only my posts
                        </label>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Apply</button>
                <?php if ($search !== '' || $showMine) : ?>
                    <a href="<?= BASE_PATH ?>/" class="btn btn-outline-secondary w-100">Reset</a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <div class="row g-4">
        <?php if (empty($posts)) : ?>
            <div class="col-12">
                <div class="card ig-card p-4 text-center text-muted">
                    <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">No posts yet. Try adjusting your search or create one.</p>
                </div>
            </div>
        <?php endif; ?>

        <!--  foreach all the posts -->
        <?php foreach ($posts as $post) : ?> 
            <?php 
                $initial = strtoupper(substr($post['name'], 0, 1));
                $excerpt = strip_tags($post['content']);
                if (strlen($excerpt) > 140) {
                    $excerpt = substr($excerpt, 0, 140) . '...';
                }
                $likes = $post['likes_count'];
                $dislikes = $post['dislikes_count'];
            ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card feed-card h-100">
                    <?php if (!empty($post['image'])) : ?>
                        <img src="<?= e($post['image']); ?>" class="card-img-top" alt="Post Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="feed-meta mb-3">
                            <div>
                                <div class="fw-bold"><?= e($post['name']); ?></div>
                                <small class="text-muted">Shared a post</small>
                            </div>
                        </div>
                        <h5 class="card-title mb-0 fw-bold"><?= e($post['title']); ?></h5>
                        <p class="card-text text-muted mb-3"><?= e($excerpt); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-3 text-muted small">
                                <span><i class="bi bi-heart"></i> <?= e($likes); ?></span>
                                <span><i class="bi bi-heartbreak"></i> <?= e($dislikes); ?></span>
                            </div>
                            <a href="<?= BASE_PATH ?>/post?id=<?= e($post['id']); ?>" class="btn btn-primary btn-sm px-3">Read</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-5 d-flex flex-column flex-md-row justify-content-center gap-3">
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="<?= BASE_PATH ?>/logout" class="btn btn-primary btn-lg px-4 fw-bold">Logout</a>
    <?php else : ?>
        <a href="<?= BASE_PATH ?>/login" class="btn btn-primary btn-lg px-4 fw-bold">Login</a>
        <a href="<?= BASE_PATH ?>/signup" class="btn btn-outline-secondary btn-lg px-4 fw-bold">Sign Up</a>
    <?php endif; ?>
    </div>
</div>
<?php require 'parts/footer.php'; ?>
