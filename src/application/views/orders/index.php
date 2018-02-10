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



