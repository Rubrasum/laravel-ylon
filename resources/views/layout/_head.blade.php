<title>laravel Ylon</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
    // hide the page body_container id element until its loaded
    window.onload = function() {
        document.getElementById('body_container').style.visibility = 'visible';
    }
</script>

<style>
    html {
        scroll-behavior: smooth
    }
    #body_container {
        visibility: hidden;
    }
</style>
