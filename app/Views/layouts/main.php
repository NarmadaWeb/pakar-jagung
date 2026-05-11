<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#56995c",
                        "primary-light": "#7cb87f",
                        "primary-dark": "#3d6b42",
                        "background-light": "#f6f7f6",
                        "background-dark": "#161c17",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
    <?= $this->renderSection('meta') ?>
    <title><?= $title ?? 'CornAI' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100">
    <?= $this->renderSection('content') ?>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) menu.classList.toggle('hidden');
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>