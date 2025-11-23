<!DOCTYPE html>
<html>
  <head>
    <title>NoteSquare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap"
    />
    <style type="text/css">
      :root {
        --xh-red: #ff2442;
        --xh-dark: #1a1a1a;
        --xh-subtle: #6f6f73;
        --xh-bg: #f9f9fb;
        --xh-card: #ffffff;
        --xh-border: #ebebef;
      }

      * { box-sizing: border-box; }

      body {
        font-family: "DM Sans", "Helvetica Neue", Arial, sans-serif;
        background: var(--xh-bg);
        color: var(--xh-dark);
        min-height: 100vh;
        margin: 0;
      }

      a { color: var(--xh-dark); text-decoration: none; }
      a:hover { color: var(--xh-red); }

      .ig-nav {
        position: sticky;
        top: 0;
        z-index: 20;
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--xh-border);
      }

      .ig-nav .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--xh-dark);
        text-decoration: none;
      }

      .ig-logo {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--xh-red);
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 1.1rem;
        box-shadow: 0 8px 20px rgba(255,36,66,0.25);
      }

      .ig-nav-links {
        gap: 18px;
      }
      .ig-nav-links a {
        margin-left: 0;
        color: var(--xh-dark);
        font-weight: 700;
        font-size: 1rem;
      }

      .ig-nav-links a.ig-cta {
        padding: 8px 14px;
        border-radius: 999px;
        background: var(--xh-red);
        color: #fff;
        border: 1px solid var(--xh-red);
      }

      .ig-nav-links a.ig-cta:hover { color: #fff; transform: translateY(-1px); }

      .ig-card {
        background: var(--xh-card);
        border: 1px solid var(--xh-border);
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(0, 0, 0, 0.04);
      }

      .card {
        border-radius: 14px;
        border: 1px solid var(--xh-border);
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
      }

      .btn-primary {
        border: none;
        border-radius: 12px;
        background: var(--xh-red);
        color: #fff;
        font-weight: 700;
        transition: transform 0.12s ease, box-shadow 0.12s ease;
      }
      .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(255,36,66,0.24);
        color: #fff;
      }

      .btn-link {
        color: var(--xh-dark);
        font-weight: 600;
      }

      .form-control, .form-select, .form-control:focus, .form-select:focus {
        border-radius: 10px;
        border: 1px solid var(--xh-border);
        box-shadow: none;
      }
      .form-control:focus, .form-select:focus {
        border-color: var(--xh-red);
        box-shadow: 0 0 0 3px rgba(255,36,66,0.12);
      }

      .table > :not(caption) > * > * { padding: 0.85rem 0.75rem; vertical-align: middle; }
      .table th {
        color: var(--xh-subtle);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.01em;
        font-size: 0.75rem;
      }

      .alert { border-radius: 12px; border: none; box-shadow: 0 8px 18px rgba(0,0,0,0.05); font-weight: 600; }
      .alert-success { background: #e8fff2; color: #0f5132; }
      .alert-danger { background: #ffe9ed; color: #58151c; }

      .badge { border-radius: 10px; padding: 0.35rem 0.6rem; }

      .feed-card img {
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        width: 100%;
        height: 220px;
        object-fit: cover;
      }
      .feed-placeholder {
        width: 100%;
        height: 220px;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        background: linear-gradient(135deg, #f5f5f7, #e8e8ec);
        display: grid;
        place-items: center;
        color: #9a9aa0;
        font-weight: 700;
      }
      .feed-card {
        min-height: 420px;
      }
      .feed-card .card-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-height: 220px;
      }
      .text-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }

      .auth-shell { display: grid; place-items: center; min-height: calc(100vh - 120px); }
      .auth-card { width: 100%; max-width: 520px; }

      @media (max-width: 768px) {
        .ig-nav-links { flex-wrap: wrap; justify-content: flex-end; gap: 6px; }
        .ig-nav-links a { margin-left: 0; }
      }
    </style>
  </head>
 <body>
  <header class="ig-nav py-3 mb-4">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="brand" href="<?= BASE_PATH ?>/">
        <div class="ig-logo"><i class="bi bi-camera-fill"></i></div>
        <span>NoteSquare</span>
      </a>
      <div class="ig-nav-links d-flex align-items-center">
        <a href="<?= BASE_PATH ?>/" class="px-2">Home</a>
        <?php if ( isset($_SESSION['user']) ) : ?>
          <a href="<?= BASE_PATH ?>/dashboard" class="px-2">Dashboard</a>
          <a href="<?= BASE_PATH ?>/manage-posts" class="px-2">My Posts</a>
          <a href="<?= BASE_PATH ?>/favorites" class="px-2">Favorites</a>
           <a href="<?= BASE_PATH ?>/contact" class="px-2">Contact</a>
        <?php endif; ?>
        <?php if ( isset($_SESSION['user']) ) : ?>
          <a href="<?= BASE_PATH ?>/logout" class="ig-cta ms-4">Logout</a>
        <?php else : ?>
          <a href="<?= BASE_PATH ?>/login" class="ig-cta ms-4">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </header>
