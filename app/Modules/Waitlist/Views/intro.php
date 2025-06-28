<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myzuwa is Coming Soon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .intro-panel {
            background-color: #121212;
            color: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 1rem;
            max-width: 450px;
            text-align: left;
        }
        .intro-panel .brand {
            font-weight: 900;
            font-size: 1.75rem;
            letter-spacing: 1px;
        }
        .intro-panel .headline {
            font-weight: 900;
            font-size: 3rem;
            line-height: 1.1;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
        .intro-panel p {
            font-size: 1.1rem;
            color: #e0e0e0;
            margin-bottom: 2rem;
        }
        .intro-panel .btn-action {
            background-color: #D9530D;
            color: #ffffff;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: background-color 0.2s;
        }
        .intro-panel .btn-action:hover {
            background-color: #b8460b;
        }
        .intro-panel ul {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }
        .intro-panel ul li {
            padding-left: 1.5rem;
            position: relative;
            margin-bottom: 0.75rem;
        }
        .intro-panel ul li::before {
            content: '•';
            color: #D9530D;
            font-weight: bold;
            display: inline-block;
            position: absolute;
            left: 0;
            font-size: 1.25rem;
        }
        .email-capture-form {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="intro-panel">
            <div class="brand">MYZUWA</div>
            <h1 class="headline">Myzuwa is coming.</h1>
            <p>E-commerce meets music. Be first to experience the future.</p>
            <!-- Email Capture Form -->
            <form class="email-capture-form" method="post" action="<?= site_url('waitlist/preSignup') ?>">
                <?= csrf_field() ?>
                <div class="input-group mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    <button class="btn btn-action" type="submit">Join the Waitlist</button>
                </div>
            </form>
            <ul>
                <li>Stream exclusive music</li>
                <li>Shop curated drops</li>
                <li>Unlock early bird perks</li>
            </ul>
        </div>
    </div>
</body>
</html>
