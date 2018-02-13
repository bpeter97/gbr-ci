<!DOCTYPE html>
<html class="full" lang="en">
 
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="GBR Management System">
    <meta name="author" content="Brian L. Peter Jr.">

    <title>GBR Management System - Login</title>

    <!-- CSS -->
    <link type="text/css" href="<?= base_url() . 'assets/css/bootstrap.css'; ?>" rel="stylesheet">
    <link type="text/css" href="<?= base_url() . 'assets/css/style.css'; ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() . 'assets/css/font-awesome.min.css'; ?>" />

</head>

<body id="login_page">
    <div class="container">
        <div class="d-flex flex-row mb-5 mt-5 justify-content-center">
            <div class="col-sm-6 text-center">
                <img class="img-responsive mb-5" src="<?= base_url() .'assets/img/logo.png'; ?>">
                <div class="card">
                    <div class="card-header text-center">
                        SYSTEM LOCKED
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center pb-1">
                            This session has been locked by either timing out and not doing anything for 
                            5 minutes or the user decided to lock the system for security purposes. Please 
                            type your login password to get back into the system.
                        </p>
                        <!-- ALERT SECTION -->
                        <?php if($this->session->flashdata('error_msg') || $this->session->flashdata('success_msg')): ?>
                        <section id="alert-section">
                            <?php if($this->session->flashdata('success_msg')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('success_msg'); ?>
                            <?php else: ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                    foreach($this->session->flashdata('error_msg') as $error)
                                    {
                                        echo $error;
                                        break;
                                    }
                                ?>
                                <?php endif; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </div>
                        </section>
                        <?php endif; ?>
                        <?= form_open('home/login'); ?>
                        <div class="input-group pb-3">
                            <span class="input-group-addon"><i class="fa fa-lock px-3 align-middle mt-2" aria-hidden="true"></i></span>
                            <input id="username" type="username" class="form-control" name="username" placeholder="username">
                        </div>
                        <div class="input-group pb-3">
                            <span class="input-group-addon"><i class="fa fa-lock px-3 align-middle mt-2" aria-hidden="true"></i></span>
                            <input id="password" type="password" class="form-control" name="password" placeholder="password">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-default pull-right" name="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> Log in</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <!-- COPYRIGHT -->
            <?php 
                $this->load->view('footer/copyright');
            ?>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="<?= base_url() . 'assets/js/jquery.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/popper.min.js'; ?>"></script>

</body>

</html>
