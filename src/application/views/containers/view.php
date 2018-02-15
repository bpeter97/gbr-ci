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
                    <?= form_open('containers/view/'.$container->get_id()); ?>
                    <h5 class="card-title text-center py-3">View Container</h5>
                    <div class="container"> 
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('container_number') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('container_number'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="container_number" class="form-control" placeholder="Type container number" value="<?= $container->get_number(); ?>">
                                <small class="form-text text-muted pl-1">This field is the GBR number (##-####).</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('container_serial_number') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('container_serial_number'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="container_serial_number" class="form-control" placeholder="Type container serial number" value="<?= $container->get_serial_number(); ?>">
                                <small class="form-text text-muted pl-1">This field is the serial number of the container.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="container_shelves" name="container_shelves" <?= ($container->get_shelves() == "Yes") ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="container_shelves">Container has shelves?</label>
                                </div>
                                <small class="form-text text-muted pl-1">Check the box if container has shelves.</small>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="container_painted" name="container_painted" <?= ($container->get_paint() == "Yes") ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="container_painted">Container is painted?</label>
                                </div>
                                <small class="form-text text-muted pl-1">Check the box if container is painted.</small>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="container_onbox_numbers" name="container_onbox_numbers" <?= ($container->get_onbox_numbers() == "Yes") ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="container_onbox_numbers">Container has GBR numbers?</label>
                                </div>
                                <small class="form-text text-muted pl-1">Check the box if container has GBR numbers.</small>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="container_signs" name="container_signs" <?= ($container->get_signs() == "Yes") ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="container_signs">Container has signs?</label>
                                </div>
                                <small class="form-text text-muted pl-1">Check the box if container has signs.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('container_size') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('container_size'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="container_size" class="form-control" placeholder="Type container's size." value="<?= $container->get_size(); ?>">
                                <small class="form-text text-muted pl-1">Type the container's size using numbers only. (20 for 20 foot container)</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <input type="text" name="release_number" class="form-control" placeholder="Type the container's release number." value="<?= $container->get_release_number(); ?>">
                                <small class="form-text text-muted pl-1">Type the container's release number.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('rental_resale') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('rental_resale'); ?>
                                </div>
                                <?php endif; ?>
                                <select class="form-control" name="rental_resale" id="rental_resale">
                                    <option selected><?= $container->get_rental_resale(); ?></option>
                                    <option value="Rental">Rental</option>
                                    <option value="Resale">Resale</option>
                                </select>
                                <small class="form-text text-muted pl-1">Select whether or not the container is a rental or resale container.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('is_rented') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('is_rented'); ?>
                                </div>
                                <?php endif; ?>
                                <select class="form-control" name="is_rented" id="is_rented">
                                    <option selected><?= ($container->get_is_rented() == 'TRUE') ? 'Yes' : 'No'; ?></option>
                                    <option value="TRUE">Yes</option>
                                    <option value="FALSE">No</option>
                                </select>
                                <small class="form-text text-muted pl-1">Select whether or not the container is out on rent or not.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('address') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('address'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="address" class="form-control" placeholder="Type current address." value="<?= $container->get_address(); ?>">
                                <small class="form-text text-muted pl-1">This is where the container is currenlty located.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('flag') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('flag'); ?>
                                </div>
                                <?php endif; ?>
                                <select class="form-control" name="flag" id="flag">
                                    <option selected><?= $container->get_flag(); ?></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <small class="form-text text-muted pl-1">Select whether or not the container is flagged.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="flag_reason" id="flag_reason" rows="3" placeholder="Explain the reason for the flag."><?= $container->get_flag_reason(); ?></textarea>
                                <small class="form-text text-muted pl-1">Explain the flag through the flag notes.</small>
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

        <!-- Rental History Row -->
        <div class="d-flex flex-row justify-content-center pt-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-2">Rental History</h5>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-self-center">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Total Time</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Amount Earned</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                    
                                        if(!empty($order_history)) 
                                        {

                                            // set variables
                                            $purchase_count = 0;
                                            $total_amount = 0;

                                            // list out each order
                                            foreach($order_history as $order) 
                                            {
                                                $purchase_count += 1;

                                                if($order['end_date'] == '0000-00-00')
                                                {
                                                    $end_date = 'Still Renting';
                                                    $date_diff = date_difference($order['start_date'], date('Y-m-d'), '%m Month(s) %d Day(s)');
                                                    $time = $date_diff[0];
                                                    $total_amount += ($order['cost']*$date_diff[1]);
                                                } else {
                                                    $date_diff = date_difference($order['start_date'], $order['end_date'], '%m Month(s) %d Day(s)');
                                                    $time = $date_diff[0];
                                                    $total_amount += ($order['cost']*$date_diff[1]);
                                                }

                                                echo '

                                                <tr>
                                                    <td>' . $purchase_count . '</td>
                                                    <td>' . $order['start_date'] . '</td>
                                                    <td>' . $end_date . '</td>
                                                    <td>' . $time . '</td>
                                                    <td>' . $order['customer'] . '</td>
                                                    <td>' . $order['cost']*$date_diff[1] . '</td>
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
                                                <td><strong>' . $total_amount . '</strong></td>
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
</section>

<!-- Delete Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= form_open('containers/delete/' . $container->get_id()); ?>
            
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Delete Container</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    
                    <p>Are you sure you would like to <span class="text-danger"><strong>delete</strong></span> the container?</p>
                    
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
                
                <p>The container (<?= $container->get_number(); ?>) has a flag on it's account!</p>
                <p>Flag Reason: <?= $container->get_flag_reason(); ?></p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-gbr" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>