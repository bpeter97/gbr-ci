<?php date_default_timezone_set('America/Los_Angeles'); ?>

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
    <link type="text/css" href="<?= base_url() . 'assets/css/font-awesome.min.css'; ?>" rel="stylesheet">
    <link type="text/css" href="<?= base_url() . 'assets/css/fullcalendar.css'; ?>" rel="stylesheet">
    <link type="text/css" href="<?= base_url() . 'assets/css/less-space.css'; ?>" rel="stylesheet">

    <!-- Required for the charts to work -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="<?= base_url() . 'assets/js/modules/data.js'; ?>"></script>
    <!-- End of chart js requirements. -->

</head>

<body>
    
    <!-- navbar -->
    <?php $this->load->view('navbar/navbar'); ?>

    <div id="layout-spacer"></div>

    <!-- main_view -->
    <?php $this->load->view($main_view); ?>

    <div class="mt-5"></div>

    <!-- copyright -->
    <?php $this->load->view('footer/copyright'); ?>

    <!-- Javascript -->
    <script src="<?= base_url() . 'assets/js/jquery.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/popper.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/moment.min.js'; ?>"></script>
    <script src="<?= base_url() . 'assets/js/fullcalendar.js'; ?>"></script>

    <!-- Load the bottom JS for the page. -->
    <?php 
        if(isset($externaljs))
        {
            foreach($externaljs as $js)
            {
                echo '<script src="' . $js . '" type="text/javascript"></script>';
            }
        }

    ?>

    <?php
        if(isset($botjs))
        {
            foreach($botjs as $js)
            {
                $this->load->view($js);
            }
        }

    ?>

    <!-- Date Picker / Time Picker -->
    <script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        $('#date').datepicker({
            showOtherMonths: true
        });
    </script>

    <script>
        $('#time').timepicker({
            showOtherMonths: true
        });
    </script>

    <!-- Clickable rows on tables. -->
    <script type="text/javascript">
        $(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.document.location = $(this).data("href");
            });
        });
    </script>

    <script>
        $('#calendar2').fullCalendar({
            weekends: false // will hide Saturdays and Sundays
        });
    </script>

</body>
