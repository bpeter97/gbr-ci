<div class="container-fluid" style="width:90%;">

    <!-- 1st Row. [Confidentiality Portion] -->
    <div class="row">
        <div class="col-lg-12 text-center">
            <span>
                CONFIDENTIAL QUOTE <br/>
                For Individual Use Only
            </span>
        </div>
    </div>
    <!-- End of 1st Row. -->

    <!-- 2nd Row. [Page Logo] -->
    <div class="row" style="padding-top:20px;">
        <div class="col-lg-12 text-center">
            <img src="../img/logo.png" alt="Green Box Rentals Logo"></br>
            <span style="font-weight: bold;padding-top:5px;">
                6988 AVENUE 304, VISALIA, CA 93291 &nbsp; &nbsp; &nbsp; PH (559) 733-5345 &nbsp; &nbsp; &nbsp; FX (559) 651-4288
            </span>
        </div>
    </div>
    <!-- End of 2nd Row. -->

    <!-- 3rd Row. [Page Title] -->
    <div class="row" style="padding-top:20px;">
        <div class="col-lg-12 text-center">
            <h3 style="font-weight: bold;">
                <?= $type ?>
            </h3>
        </div>
    </div>
    <!-- End of 3rd Row. -->

    <!-- 4th Row. [Customers Information] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <table class="table table-bordered">
                <tbody>
                    <tr align="left">
                        <td class="cust_data_td_left"><strong>TO:</strong></td>
                        <td class="cust_data_td_middle"><?= $customer->get_name(); ?></td>
                        <td class="cust_data_td_left"><strong>ATTN:</strong></td>
                        <td class="cust_data_td_middle"><?= $quote->get_attn(); ?></td>
                    </tr>
                    <tr align="left">
                        <td class="cust_data_td_left"><strong>PH:</strong></td>
                        <td class="cust_data_td_middle"><?= $customer->get_phone(); ?></td>
                        <td class="cust_data_td_left"><strong>FAX:</strong></td>
                        <td class="cust_data_td_middle"><?= $customer->get_fax(); ?></td>
                    </tr>
                    <tr align="left">
                        <td class="cust_data_td_left"><strong>EMAIL:</strong></td>
                        <td class="cust_data_td_middle"><?= $customer->get_email(); ?></td>
                        <td class="cust_data_td_left"><strong>JOB:</strong></td>
                        <td class="cust_data_td_middle"><?= $quote->get_job_name(); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End of 4th Row. -->

    <!-- 5th Row. [Products Ordered] -->
    <div class="row" style="padding-top:30px;">
        <div class="col-lg-12">
            
            <?php if($type == "Sales" || $type == "Resale"): ?>

                <table class="table table-bordered">
                    <thead>
                        <tr align="center" style="font-weight: bold;">
                            <td>Item Name</td>
                            <td>Quantity</td>
                            <td>Cost</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($products as $item): ?>

                        <tr>
                            <!-- Sales Quote -->
                            <td><?= $item->get_mod_name(); ?></td>
                            <td class="text-center"><?= $item->get_product_quantity(); ?></td>
                            <td class="text-center">$ <?= $item->get_product_cost(); ?></td>
                        </tr>

                        <?php endforeach; ?>

                        <tr>
                            <td>Sales Tax</td>
                            <td class="text-center">1</td>
                            <td class="text-center">$ <?= $quote->get_sales_tax(); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="sum_row">
                            <td>Total:</td>
                            <td class="text-center"></td>
                            <td class="text-center">$ <?= $quote->get_total(); ?></td>
                        </tr>
                    </tfoot>
                </table>

            <?php elseif ($type == "Rental"): ?>

                <table class="table table-bordered">
                    <thead>
                        <tr align="center" style="font-weight: bold;">
                            <td>Item Name</td>
                            <td>Quantity</td>
                            <td>Monthly Cost</td>
                            <td>Cost</td>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Will obviously need to do a foreach here and then have the total row at the end after the foreach to display the proper total, easy enough. -->
                        <?php foreach ($products as $item): ?>
                        <tr>
                            <!-- Sales Quote -->
                            <?php if(in_array($item->get_mod_short_name(), $rental_products)): ?>
                                <td><?= $item->get_mod_name(); ?></td>
                                <td class="text-center"><?= $item->get_product_quantity(); ?></td>
                                <td class="text-center">$ <?= $item->get_product_cost(); ?></td>
                                <td class="text-center">$ <?= $item->get_product_cost(); ?></td>
                            <?php else: ?>
                                <td><?= $item->get_mod_name(); ?></td>
                                <td class="text-center"><?= $item->get_product_quantity(); ?></td>
                                <td class="text-center"></td>
                                <td class="text-center">$ <?= $item->get_product_cost(); ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Sales Tax</td>
                            <td class="text-center"></td>
                            <td></td>
                            <td class="text-center">$ <?= $quote->get_sales_tax(); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="sum_row">
                            <td>Total:</td>
                            <td class="text-center"></td>
                            <td class="text-center">$ <?= $quote->get_monthly_total(); ?></td>
                            <td class="text-center">$ <?= $quote->get_total_cost(); ?></td>
                        </tr>
                    </tfoot>
                </table>

            <?php endif; ?>

        </div>
    </div>
    <!-- End of 5th Row. -->

    <!-- 6th Row. [Charge Explination] -->
    <div class="row" style="padding-top:20px;">
        <div class="col-lg-12 text-center">
            <span style="font-weight: bold;">
                No sales tax on delivery charges.
            </span>
        </div>
    </div>
    <!-- End of 6th Row. -->

    <!-- 7th Row. [Thanks!] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <div style="border:1px solid black; border-top:1px solid black; background-color:darkgreen;">
                <span style="color:white;font-weight:bold;">
                    THANK YOU FOR CHOOSING GREEN BOX RENTALS, INC.
                </span>
            </div>
        </div>
    </div>
    <!-- End of 7th Row. -->

    <!-- 8th Row. [Visit Us!] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <span style="font-weight: bold;">
                Visit www.greenboxrentals.com for more information on our services!
            </span>
        </div>
    </div>
    <!-- End of 8th Row. -->

    <!-- 9th Row. [Comments Box] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <div style="border:1px solid black;">
                <div class="col-lg-12 text-left" style="padding-left:5px;">
                    <span>
                        COMMENTS:
                    </span>
                </div>
                <div class="col-lg-12 text-center pt-5">
                    <span>
                        Add sales tax on monthly rentals only.
                    </span>
                </div>
                <div class="col-lg-12 text-center">
                    <span>
                        One month minimum rental.
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- End of 9th Row. -->

    <!-- 10th Row. [Manager Signature] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12">
            <span style="text-align:left;">
                <?= $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].' - '.$_SESSION['user_title']; ?>
            </span>
        </div>
    </div>
    <!-- End of 10th Row. -->

    <!-- 11th Row. [Customer Signature] -->
    <div class="row" style="padding-top:50px;">
        <div class="col-lg-12">
            <table class="table" style="border-top: 2px solid black;">
                <tbody>
                    <tr style="font-weight: bold;">
                        <td align="left">SIGNATURE</td>
                        <td align="center">DATE</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End of 11th Row. -->

    <!-- 12th Row. [Visit Us!] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <span>
                Quote good for thirty days from issue date!
            </span>
        </div>
    </div>
    <!-- End of 12th Row. -->
    <!-- 13th Row. [Go Back Buttons] -->
    <div class="row" style="padding-top:10px;">
        <div class="col-lg-12 text-center">
            <ul class="nav navbar-nav navbar-right">
                <li><a class="containerlink" href="javascript:history.back()"><button type="button" class="btn btn-gbr no-print" style="">Go Back</button></a></li>
            </ul>
        </div>
    </div>
        <!-- End of 13th Row. -->
</div>