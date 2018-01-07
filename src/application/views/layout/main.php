<!DOCTYPE html>
<html class="full" lang="en">
    
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="GBR Management System">
    <meta name="author" content="Brian L. Peter Jr.">

    <title>GBR Management System</title>

    <!-- CSS -->
    <link type="text/css" href="<?= base_url() . 'assets/css/bootstrap.css'; ?>" rel="stylesheet">
    <link type="text/css" href="<?= base_url() . 'assets/css/style.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() . 'assets/css/font-awesome.min.css'; ?>" />

</head>

<body>
    
    <!-- navbar -->
    <?php $this->load->view('navbar/navbar'); ?>

    <!-- main_view -->
    <?php $this->load->view($main_view); ?>

    <!-- copyright -->
    <?php $this->load->view('footer/copyright'); ?>

    <!-- Javascript -->
    <script src="<?= base_url() . 'assets/js/jquery.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/popper.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>

</body>
