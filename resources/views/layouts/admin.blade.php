<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .admin-container {
            min-height: 100vh;
            display: block;
        }

        .admin-sidebar {
            width: 220px;
            background: linear-gradient(to bottom, #5A1E8F, #3A0F5C);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-content {
            margin-right: 220px;
            padding: 40px;
            min-height: 100vh;
        }
    </style>

</head>
<body>

    <div class="admin-container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
