<?php
 $url = $_SERVER['PHP_SELF'];
 $uri = $_SERVER['HTTP_HOST'];
 $arr = explode("/",$url);
 $length = count($arr);
$str = explode('.',$arr[$length - 1]);
$title = $str[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
  <script>
  const BASE_URL = "<?= BASE_URL ?>";
  const CSRF_TOKEN = "<?= $_SESSION['csrf_token'] ?>";
  </script>
  <script src="<?= BASE_URL ?>assets/js/script.js" defer></script>
  <title><?= $title ?></title>
</head>

<body>