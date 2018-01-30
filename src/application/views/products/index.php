<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">All Products</h5> 
                    <div class="d-flex flex-row">
                        <span class="large-paginator d-none d-md-block"><?= $paginator; ?></span>
                        <span class="small-paginator d-block d-md-none"><?= $paginator; ?></span>
                    </div>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-self-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Mod ID</th>
                                        <th scope="col">Mod Name</th>
                                        <th scope="col">Mod Label</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Monthly Cost</th>
                                        <th scope="col">Item Types</th>
                                        <th scope="col">Rental Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                        <tr>
                                            <td><?= $product->get_id(); ?></td>
                                            <td><?= $product->get_mod_name(); ?></td>
                                            <td><?= $product->get_mod_short_name(); ?></td>
                                            <td><?= $product->get_mod_cost(); ?></td>
                                            <td><?= $product->get_monthly(); ?></td>
                                            <td><?= $product->get_item_type(); ?></td>
                                            <td><?= $product->get_rental_type(); ?></td>
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



