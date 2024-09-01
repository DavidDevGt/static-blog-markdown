<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/styles/github.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.10.0/highlight.min.js" integrity="sha512-6yoqbrcLAHDWAdQmiRlHG4+m0g/CT/V9AGyxabG8j7Jk8j3r3K6due7oqpiRMZqcYe9WM2gPcaNNxnl2ux+3tA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        hljs.highlightAll();
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Static Blog</title>
</head>

<body>
    <header class="navbar is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <a href="/" class="navbar-item title is-4 has-text-black">DavidDevGt</a>
            </div>

        </div>
    </header>
    <section class="section">
        <div class="container">
            <main>
                <?= $content ?>
            </main>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <p class="has-text-centered">&copy; <?= date('Y') ?> DavidDevGt</p>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const postDates = document.querySelectorAll('.post-date');
            postDates.forEach(date => {
                const formattedDate = moment(date.textContent, 'DD/MM/YYYY').format('MMMM Do YYYY');
                date.textContent = formattedDate;
            });
        });
    </script>
</body>

</html>