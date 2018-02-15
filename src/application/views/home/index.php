<section id="list">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8 pb-4 lg-pr-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">Container Map</h5>  
                        <div class="d-flex flex-row justify-content-center">
                            <div class="container-fluid">
                                <input id="pac-input" class="form-control mt-2 w-25" type="text" placeholder="Search Box">
                                <div id="map" class="mb-3" style="min-height:450px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 pb-4 lg-pl-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">Calendar</h5>  
                        <div class="d-flex flex-row justify-content-center">
                            <div class="container">
                                <div id="calendar" class="pb-3"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
            
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-4 lg-pr-5 xs-pb-20 lg-pb-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">Orders / Quotes in 2018</h5>  
                        <div class="d-flex flex-row justify-content-center">
                            <div class="container">
                                <div id="total_orders" style="min-width: 250px; height: 300px; margin: 0 auto"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8 lg-pl-5">
                <div class="card" style="width:99%;">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">Containers In Stock</h5>  
                        <div class="d-flex flex-row justify-content-center">
                            <div class="container">
                                <div id="stock_container" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<table id="ordertable" style="display:none;">
    <thead>
        <tr>
            <th></th>
            <th>Quotes</th>
            <th>Orders</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0;$i<12;$i++): ?>
        <tr>
            <th><?= $months[$i]; ?></th>
            <td><?= $quotes[$i]; ?></td>
            <td><?= $orders[$i]; ?></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>

<table id="datatable" style="display:none;">
    <thead>
        <tr>
            <th></th>
            <th>Rentals</th>
            <th>Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php for($i=0;$i<16;$i++): ?>
        <tr>
            <th><?= $con_list[$i]; ?></th>
            <td><?= $rentals[$i]; ?></td>
            <td><?= $resales[$i]; ?></td>
        </tr>
        <?php endfor; ?>
    </tbody>
</table>

<!-- Modals -->
<?php $this->load->view('home/modals'); ?>

<?php create_map_xml(); ?>