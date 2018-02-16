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
                    <h5 class="card-title text-center py-3">All Orders</h5> 
                    <div class="d-flex flex-row">
                        <span class="large-paginator d-none d-md-block"><?= $paginator; ?></span>
                        <span class="small-paginator d-block d-md-none"><?= $paginator; ?></span>
                    </div>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-self-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Stage</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Rental or Resale</th>
                                        <th scope="col">Ordered By</th>
                                        <th scope="col">On-Site Contact</th>
                                        <th scope="col">On-Site Contact #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $order): ?>
                                        <tr>
                                            <td><?= $order->get_id(); ?></td>
                                            <td><?= $order->get_stage(); ?></td>
                                            <td><?= $order->get_customer(); ?></td>
                                            <td><?= $order->get_date(); ?></td>
                                            <td><?= $order->get_time(); ?></td>
                                            <td><?= $order->get_type(); ?></td>
                                            <td><?= $order->get_ordered_by(); ?></td>
                                            <td><?= $order->get_onsite_contact(); ?></td>
                                            <td><?= $order->get_onsite_contact_phone(); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <span class="large-paginator d-none d-md-block"><?= $paginator; ?></span>
                        <span class="small-paginator d-block d-md-none" style="margin-top:10px;"><?= $paginator; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>



