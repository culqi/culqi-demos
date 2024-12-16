<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Demo Culqi'; ?></title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="https://culqi.com/assets/images/brand/brand.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 h-screen">
  <div class="container mx-auto h-full flex flex-col">
    <?php require base_path('resources/views/partials/nav.simple.php') ?>

    <main class="w-full flex-grow flex justify-center items-center">
      <?php echo $content; ?>
    </main>
  </div>
</body>

</html>