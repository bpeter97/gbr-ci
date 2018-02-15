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
                    <h5 class="card-title text-center py-3">All Containers</h5> 
                    <div class="d-flex flex-row">
                        <span class="large-paginator d-none d-md-block"><?= $paginator; ?></span>
                        <span class="small-paginator d-block d-md-none"><?= $paginator; ?></span>
                    </div>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-self-center">
                                <thead>
                                    <tr>
                                        <th scope="col">GBR Number</th>
                                        <th scope="col">Serial Number</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Shelves?</th>
                                        <th scope="col">Paint?</th>
                                        <th scope="col">Numbers?</th>
                                        <th scope="col">Signs?</th>
                                        <th scope="col">Rental or Resale</th>
                                        <th scope="col">Is Rented?</th>
                                        <th scope="col">Release Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($containers as $container): ?>
                                        <?php if($container->get_flag() == "Yes"): ?>
                                            <tr class="danger clickable-row" data-href="<?= base_url() . 'containers/view/' . $container->get_id(); ?>">
                                        <?php else: ?>
                                            <tr class="clickable-row" data-href="<?= base_url() . 'containers/view/' . $container->get_id(); ?>">
                                        <?php endif; ?>
                                            <td><?= $container->get_number(); ?></td>
                                            <td><?= $container->get_serial_number(); ?></td>
                                            <td><?= $container->get_size(); ?></td>
                                            <td><?= $container->get_shelves(); ?></td>
                                            <td><?= $container->get_paint(); ?></td>
                                            <td><?= $container->get_onbox_numbers(); ?></td>
                                            <td><?= $container->get_signs(); ?></td>
                                            <td><?= $container->get_rental_resale(); ?></td>
                                            <td><?= $container->get_is_rented(); ?></td>
                                            <td><?= $container->get_release_number(); ?></td>
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



