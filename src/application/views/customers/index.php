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
                    <h5 class="card-title text-center py-3">All Customers</h5> 
                    <div class="d-flex flex-row">
                        <span class="large-paginator d-none d-md-block"><?= $paginator; ?></span>
                        <span class="small-paginator d-block d-md-none"><?= $paginator; ?></span>
                    </div>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-self-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Ext</th>
                                        <th scope="col">Fax</th>
                                        <th scope="col">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($customers as $customer): ?>
                                        <?php if($customer->get_flag() == "Yes"): ?>
                                            <tr class="danger clickable-row" data-href="<?= base_url() . 'customers/view/' . $customer->get_id(); ?>" >
                                        <?php else: ?>
                                            <tr class="clickable-row" data-href="<?= base_url() . 'customers/view/' . $customer->get_id(); ?>" >
                                        <?php endif; ?>
                                            <td><?= $customer->get_name(); ?></td>
                                            <td><?= $customer->get_phone(); ?></td>
                                            <td><?= $customer->get_ext(); ?></td>
                                            <td><?= $customer->get_fax(); ?></td>
                                            <td><?= $customer->get_email(); ?></td>
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



