<?php 
    // This function is solely for getting the # of months between two dates.
    function nb_mois($date1, $date2)
    {
        $begin = new DateTime( $date1 );
        $end = $date2;
        $end = $end->modify('-1 month');

        $interval = DateInterval::createFromDateString('1 month');

        $period = new DatePeriod($begin, $interval, $end);
        $counter = 0;
        foreach($period as $dt) {
            $counter++;
        }

        return $counter;
    }
?>

<!-- ALERT SECTION -->
<?php if( isset($_SESSION['error_msg']) || isset($_SESSION['success_msg']) ): ?>
    <section id="alert-section">
        <?php if( isset($_SESSION['success_msg']) ): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success_msg']; ?>
            <?php unset($_SESSION['success_msg']); ?>
        <?php else: ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error_msg']; ?>
            <?php unset($_SESSION['error_msg']); ?>
        <?php endif; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </div>
    </section>
<?php endif; ?>

<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">View Customer</h5>
                    <?= form_open('customers/view/'.$customer->get_id()); ?>
                    <div class="container">
                        <div class="form-row pt-3">
                            <div class="col-sm-12 text-center">
                                <button type="button" onclick="location.href='<?= base_url() . 'quotes/create/rental/' . $customer->get_id(); ?>'" class="btn btn-success gbr-btn my-1">Create Rental Quote</button>
                                <button type="button" onclick="location.href='<?= base_url() . 'quotes/create/sales/' . $customer->get_id(); ?>'" class="btn btn-success gbr-btn my-1">Create Sales Quote</button>
                                <button type="button" onclick="location.href='<?= base_url() . 'orders/create/rental/' . $customer->get_id(); ?>'" class="btn btn-success gbr-btn my-1">Create Rental Order</button>
                                <button type="button" onclick="location.href='<?= base_url() . 'orders/create/sales/' . $customer->get_id(); ?>'" class="btn btn-success gbr-btn my-1">Create Sales Order</button>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('name') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('name'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="name"  id="name" class="form-control" placeholder="Customer Name" value="<?= $customer->get_name(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's first and last name or company name.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('address1') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('address1'); ?>
                                </div>
                                <?php endif; ?>
                                <?php if( form_error('address2') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('address2'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="address1"  id="address1" class="form-control" placeholder="Address" value="<?= $customer->get_address1(); ?>">
                                <input type="text" name="address2"  id="address2" class="form-control" placeholder="Address Line 2" value="<?= $customer->get_address2(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's first and second lines of their address.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('phone') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" value="<?= $customer->get_phone(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's phone number.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('city') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('city'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?= $customer->get_city(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's city.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax Number" value="<?= $customer->get_fax(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's fax number.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <input type="text" name="ext" id="ext" class="form-control" placeholder="Extension" value="<?= $customer->get_ext(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's extension.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('email') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('email'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" value="<?= $customer->get_email(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's e-mail.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('state') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('state'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State" value="<?= $customer->get_state(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's state (ex: CA).</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <input type="text" name="rdp" id="rdp" class="form-control" placeholder="RDP" value="<?= $customer->get_rdp(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's RDP.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('zipcode') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('zipcode'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zipcode" value="<?= $customer->get_zipcode(); ?>">
                                <small class="form-text text-muted pl-1">This field is the customer's 5 number zipcode.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <select class="form-control" name="flag" id="flag">
                                    <option value="<?= $customer->get_flag(); ?>" selected><?= $customer->get_flag(); ?></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <small class="form-text text-muted pl-1">Place a flag on customers account.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <textarea class="form-control" name="flag_reason" id="flag_reason" rows="3" placeholder="Explain the reason for the flag."><?= $customer->get_flag_reason(); ?></textarea>
                                <small class="form-text text-muted pl-1">Explain the flag through the flag notes.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <textarea class="form-control" name="notes" id="notes" rows="4" placeholder="Notes that relate to the customer."><?= $customer->get_notes(); ?></textarea>
                                <small class="form-text text-muted pl-1">Notes that relate to the customer.</small>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-danger mr-auto" data-toggle="modal" data-target="#ModalDelete">Delete</button>
                        <button type="submit" class="btn btn-success gbr-btn">Save</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-success gbr-btn">Cancel</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="d-flex flex-row justify-content-center pt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-2">History</h5>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs" id="historyTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="quoteTab" data-toggle="tab" href="#Quotes" role="tab" aria-controls="Quotes" aria-selected="true">Quote History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Purchases-tab" data-toggle="tab" href="#Purchases" role="tab" aria-controls="Purchases" aria-selected="false">Purchase History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Rental-tab" data-toggle="tab" href="#Rental" role="tab" aria-controls="Rental" aria-selected="false">Rental History</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="historyTabContent">
                                <div class="tab-pane fade show active" id="Quotes" role="tabpanel" aria-labelledby="quoteTab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover align-self-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Quote #</th>
                                                    <th scope="col">Sales or Rental</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 
                                                
                                                    if(!empty($quote_history)) 
                                                    {

                                                        // set variables
                                                        $quote_count = 0;
                                                        $total_amount = 0;

                                                        // list out each quote
                                                        foreach($quote_history as $quote) 
                                                        {
                                                            $quote_count += 1;
                                                            $total_amount += $quote->get_total_cost();

                                                            echo '

                                                            <tr>
                                                                <td>' . $quote_count . '</td>
                                                                <td>' . $quote->get_date() . '</td>
                                                                <td>' . $quote->get_id() . '</td>
                                                                <td>' . $quote->get_type() . '</td>
                                                                <td>' . $quote->get_status() . '</td>
                                                                <td>$' . $quote->get_total_cost() . '</td>
                                                                <td><a class="gbr-link" href="'. base_url() . 'quotes/view/' . $quote->get_id() . '">View Details</a></td>
                                                            </tr>

                                                            ';

                                                        }

                                                        echo '

                                                        <tr>
                                                            <td><strong>Total:</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><strong>$' . $total_amount . '</strong></td>
                                                            <td></td>
                                                        </tr>

                                                        ';

                                                    } else {

                                                        echo '
                                                        
                                                        <tr>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        </tr>
                                                        
                                                        ';

                                                    }
                                                    
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Purchases" role="tabpanel" aria-labelledby="Purchases-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover align-self-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Order #</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 
                                                
                                                    if(!empty($purchase_history)) 
                                                    {

                                                        // set variables
                                                        $order_count = 0;
                                                        $total_amount = 0;

                                                        // list out each quote
                                                        foreach($purchase_history as $order) 
                                                        {
                                                            $order_count += 1;
                                                            $total_amount += $order->get_total_cost();

                                                            echo '

                                                            <tr>
                                                                <td>' . $order_count . '</td>
                                                                <td>' . $order->get_date() . '</td>
                                                                <td>' . $order->get_id() . '</td>
                                                                <td>$' . $order->get_total_cost() . '</td>
                                                                <td><a class="gbr-link" href="'. base_url() . 'orders/view/' . $order->get_id() . '">View Details</a></td>
                                                            </tr>

                                                            ';

                                                        }

                                                        echo '

                                                        <tr>
                                                            <td><strong>Total:</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><strong>$' . $total_amount . '</strong></td>
                                                            <td></td>
                                                        </tr>

                                                        ';

                                                    } else {

                                                        echo '
                                                        
                                                        <tr>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        </tr>
                                                        
                                                        ';

                                                    }
                                                    
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Rental" role="tabpanel" aria-labelledby="Rental-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover align-self-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Order #</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php 
                                                
                                                    if(!empty($rental_history)) 
                                                    {

                                                        // set variables
                                                        $rental_count = 0;
                                                        $total_amount = 0;
                                                        $total_rental_amount = 0;

                                                        // list out each quote
                                                        foreach($rental_history as $rental) 
                                                        {
                                                            
                                                            $start_date = $rental->get_date();
                                                            $now = new DateTime();
                                                            $now->format('Y-m-d H:i:s');
                                                            $now->setTimezone(new DateTimeZone('America/Los_Angeles'));
                                                            $now->getTimestamp();
                                                            $monthCount = nb_mois($start_date, $now);
                                                            $monthCounter = 1;
                                                            $rental_amount = $rental->get_total_cost();

                                                            while ($monthCounter <= $monthCount) {

                                                                $rental_amount += $rental->get_monthly_total();
                                                                $monthCounter++;

                                                            }

                                                            if($monthCount == 0) {

                                                                $rental_amount = $rental->get_total_cost();

                                                            }

                                                            $rental_count += 1;
                                                            $total_rental_amount += $rental_amount;

                                                            echo '

                                                            <tr>
                                                                <td>' . $rental_count . '</td>
                                                                <td>' . $rental->get_date() . '</td>
                                                                <td>' . $rental->get_id() . '</td>
                                                                <td>$' . $rental_amount . '</td>
                                                                <td><a class="gbr-link" href="'. base_url() . 'orders/view/' . $rental->get_id() . '">View Details</a></td>
                                                            </tr>

                                                            ';

                                                        }

                                                        echo '

                                                        <tr>
                                                            <td><strong>Total:</strong></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><strong>$' . $total_rental_amount . '</strong></td>
                                                            <td></td>
                                                        </tr>

                                                        ';

                                                    } else {

                                                        echo '
                                                        
                                                        <tr>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        </tr>
                                                        
                                                        ';

                                                    }
                                                    
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= form_open('customers/delete/' . $customer->get_id()); ?>
            
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Delete Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    
                    <p>Are you sure you would like to <span class="text-danger"><strong>delete</strong></span> the customer?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-success btn-gbr" data-dismiss="modal">No</button>
                </div>

            <?= form_close(); ?>
        </div>
    </div>
</div>

<!-- Alert Modal -->
<div class="modal fade" id="ModalAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-danger" id="myModalLabel">!!! ALERT !!!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                
                <p>The customer (<?= $customer->get_name(); ?>) has a flag on his/her account!</p>
                <p>Flag Reason: <?= $customer->get_flag_reason(); ?></p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-gbr" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>