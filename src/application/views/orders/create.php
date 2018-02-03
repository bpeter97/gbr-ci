<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    cart_order_type = <?= '"'.$type.'"'; ?>;
    rentalArray = <?= json_encode($rental_array); ?>;
    pudArray = <?= json_encode($pud_array); ?>;
</script>
<script src="<?= base_url() . 'assets/js/shoppingCart.js'; ?>"></script>

<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <form>
                    <div class="card-body mb-3">
                        <h5 class="card-title text-center py-3">Create Order</h5>
                        <div class="container">
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="date">Order Date / Time</label>
                                </div>
                                <div class="col-4">
                                    <input id="date" name="date" class="form-control" placeholder="MM/DD/YYYY">
                                </div>
                                <div class="col-2">
                                    <input name="time" id="time" class="form-control"  placeholder="00:00">
                                </div>
                                <div class="col-2"></div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4"></div>
                                <div class="col-4"><small class="form-text text-muted">Select the date and time of the order.</small></div>
                                <div class="col-3"></div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="time">Select a Customer</label>
                                </div>
                                <div class="col-6">
                                    <select class="custom-select" id="customer">
                                        <option selected>Select a Customer</option>
                                        <?php foreach($customers as $customer): ?>
                                        <option value="<?= $customer->get_name(); ?>"><?= $customer->get_name(); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted pl-1">Select a customer or create a new one.</small>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success gbr-btn">New</button>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="ordered_by">Ordered By</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="ordered_by" id="ordered_by" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">This field is the name of the person who requested the order.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="type_display">Order Type</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select" name="type_display" id="type_display" disabled>
                                        <?php if($type == 'sales'): ?>
                                        <option selected>Sales</option>
                                        <?php else: ?>
                                        <option selected>Rental</option>
                                        <?php endif; ?>
                                    </select>
                                    <input type="hidden" name="type" id="type" value="<?= $type; ?>">
                                    <small class="form-text text-muted pl-1">This field is for the mod's label for lockbox, that would be LBOX.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_name">Job Name</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_name" id="job_name" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the job name if there is one.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_address">Job Address</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_address" id="job_address" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out just the <strong>STREET</strong> address.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_city">Job City</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_city" id="job_city" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the city of the job location.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_zipcode">Job Zipcode</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_zipcode" id="job_zipcode" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the zipcode of the job location.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="tax_rate">Tax Rate</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control"  placeholder="" onchange="cart.getTaxRate(this.value)">
                                    <small class="form-text text-muted pl-1">Fill out the tax rate of the order.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="onsite_contact">On-Site Contact</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="onsite_contact" id="onsite_contact" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the on-site contact's name.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="onsite_contact_phone">On-Site Contact Phone Number</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="onsite_contact_phone" id="onsite_contact_phone" class="form-control"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the on-site contact's phone number.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cart -->
                    <div class="d-flex justify-content-center">
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-center py-2">Current Cart</h5>
                                <div id="cart"></div>
                                <div class="d-flex justify-content-center">
                                    <button type="button" onclick="cart.postData();" class="btn btn-success mb-2 gbr-btn">Submit Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="insertCartData"></div>
                    
                </form>

                <!-- Products -->
                <div class="card align-self-center mt-2 mb-3" id="productsCard">
                    <div class="card-body">
                        <h5 class="card-title text-center py-2">Products</h5>

                        <!-- Product Tabs -->
                        <div class="d-flex justify-content-center">
                            <div class="col">
                                <ul class="nav nav-tabs" id="ProductsTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="shippingProducts-tab" data-toggle="tab" href="#shippingProducts" role="tab" aria-controls="home" aria-selected="true">Deliver/Pickup </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="products-tab" data-toggle="tab" href="#containerProducts" role="tab" aria-controls="profile" aria-selected="false">Containers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="modifications-tab" data-toggle="tab" href="#modificationProducts" role="tab" aria-controls="contact" aria-selected="false">Modifications</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="ProductsTabContent">
                                    <div class="tab-pane fade show active" id="shippingProducts" role="tabpanel" aria-labelledby="home-tab">
                                        
                                        <!-- ############## SHIPPING PRODUCTS ############## -->

                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" colspan="2">Item Name</th>
                                                    <th scope="col">Cost</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Add To Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $counter = 0; ?>

                                                <?php   foreach ($shipping_products as $sproduct):   ?>

                                                <tr>
                                                    <td colspan="2" class="text-center align-middle"><?= $sproduct->get_mod_name(); ?></td>
                                                    <td class="align-middle">

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text align-middle" id="basic-addon1">$</span>
                                                            </div>
                                                            <input type="text" class="form-control" id="shippingCost<?= $counter; ?>"  value="<?= $sproduct->get_mod_cost(); ?>" aria-label="Price" aria-describedby="basic-addon1">
                                                        </div>

                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="text" class="form-control" id="shippingQty<?= $counter ?>" name="quantity" value="1" size="2">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" onclick="cart.addItem(new Product(<?= $sproduct->get_id(); ?>, '<?= $sproduct->get_mod_name(); ?>', '<?= $sproduct->get_mod_short_name(); ?>', document.getElementById('shippingCost<?= $counter; ?>').value, '<?= $sproduct->get_rental_type(); ?>'), document.getElementById('shippingQty<?= $counter; ?>').value);" class="btn btn-success gbr-btn">Add To Order</button>
                                                    </td>
                                                </tr>

                                                <?php $counter++; ?>

                                                <?php endforeach; ?>

                                                <?php $counter = 0; ?>

                                            </tbody>
                                        </table>

                                        <!-- ############## END OF SHIPPING PRODUCTS ############## -->

                                    </div>
                                    <div class="tab-pane fade" id="containerProducts" role="tabpanel" aria-labelledby="profile-tab">
                                        
                                        <!-- ############## CONTAINER PRODUCTS ############## -->

                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" colspan="2">Item Name</th>
                                                    <th scope="col">Cost</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Add To Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php   foreach ($container_products as $cproduct):   ?>

                                                <tr>
                                                    <td colspan="2" class="text-center align-middle"><?= $cproduct->get_mod_name(); ?></td>
                                                    <td class="align-middle">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><strong>$</strong></span>
                                                            </div>
                                                            <?php if($type == 'sales'): ?>
                                                            <input type="text" class="form-control" id="containerCost<?= $counter; ?>"  value="<?= $cproduct->get_mod_cost(); ?>" aria-label="Price" aria-describedby="basic-addon1">
                                                            <?php else: ?>
                                                            <input type="text" class="form-control" id="containerCost<?= $counter; ?>"  value="<?= $cproduct->get_monthly(); ?>" aria-label="Price" aria-describedby="basic-addon1">
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="text" class="form-control" id="containerQty<?= $counter ?>" name="quantity" value="1" size="2">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" onclick="cart.addItem(new Product(<?= $cproduct->get_id(); ?>, '<?= $cproduct->get_mod_name(); ?>', '<?= $cproduct->get_mod_short_name(); ?>', document.getElementById('containerCost<?= $counter; ?>').value, '<?= $cproduct->get_rental_type(); ?>'), document.getElementById('containerQty<?= $counter; ?>').value);" class="btn btn-success gbr-btn">Add To Order</button>
                                                    </td>
                                                </tr>

                                                <?php $counter++; ?>

                                                <?php endforeach; ?>

                                                <?php $counter = 0; ?>
                                            </tbody>
                                        </table>

                                        <!-- ############## END OF CONTAINER PRODUCTS ############## -->

                                    </div>
                                    <div class="tab-pane fade" id="modificationProducts" role="tabpanel" aria-labelledby="contact-tab">
                                        
                                        <!-- ############## MODIFICATION PRODUCTS ############## -->
                                        
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th scope="col" colspan="2">Item Name</th>
                                                    <th scope="col">Cost</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Add To Order</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php   foreach ($modification_products as $mproduct):   ?>

                                                <tr>
                                                    <td colspan="2" class="text-center align-middle"><?= $mproduct->get_mod_name(); ?></td>
                                                    <td class="align-middle">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1"><strong>$</strong></span>
                                                            </div>
                                                            <?php if($type == 'sales'): ?>
                                                            <input type="text" class="form-control" id="modCost<?= $counter; ?>"  value="<?= $mproduct->get_mod_cost(); ?>" aria-label="Price" aria-describedby="basic-addon1">
                                                            <?php else: ?>
                                                            <input type="text" class="form-control" id="modCost<?= $counter; ?>"  value="<?= $mproduct->get_monthly(); ?>" aria-label="Price" aria-describedby="basic-addon1">
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="text" class="form-control" id="modQty<?= $counter ?>" name="quantity" value="1" size="2">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" onclick="cart.addItem(new Product(<?= $mproduct->get_id(); ?>, '<?= $mproduct->get_mod_name(); ?>', '<?= $mproduct->get_mod_short_name(); ?>', document.getElementById('modCost<?= $counter; ?>').value, '<?= $mproduct->get_rental_type(); ?>'), document.getElementById('modQty<?= $counter; ?>').value);" class="btn btn-success gbr-btn">Add To Order</button>
                                                    </td>
                                                </tr>

                                                <?php $counter++; ?>

                                                <?php endforeach; ?>

                                                <?php $counter = 0; ?>
                                            </tbody>
                                        </table>

                                        <!-- ############## END OF MODIFICATION PRODUCTS ############## -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of product tabs -->

                    </div>
                </div>
                <!-- End of Products -->

            </div>
        </div>
    </div>
</section>

<!-- This is the alert for when an item is added or removed from the cart. -->
<div id="insertAlert"></div>

<!-- This is teh alert modal if a customer is flagged. -->
<div class="modal fade" id="alertModal" role="dialog"></div>