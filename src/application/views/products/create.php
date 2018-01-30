<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">Create Product</h5>
                    <div class="container">
                        <?= form_open('products/create'); ?>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <input type="text" name="mod_name" class="form-control" placeholder="Type the name of the product.">
                                    <small class="form-text text-muted pl-1">This field is for the name of the product.</small>
                                </div>
                                <div class="col">
                                    <input type="text" name="mod_short_name" class="form-control" placeholder="Type the short name of the product (example: LBOX).">
                                    <small class="form-text text-muted pl-1">This field is for the mod's label for lockbox, that would be LBOX.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <input type="text" name="mod_cost" class="form-control" placeholder="Type the price of the product.">
                                    <small class="form-text text-muted pl-1">Type the price of the product.</small>
                                </div>
                                <div class="col">
                                    <input type="text" name="monthly" class="form-control" placeholder="Type the monthly cost of the product if it's a rental.">
                                    <small class="form-text text-muted pl-1">Type the monthly cost of the product if it's a rental.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col">
                                    <select class="form-control" name="item_type" id="item_type">
                                        <option>Select an item type.</option>
                                        <option value="rent_mod">Rental Modification</option>
                                        <option value="modification">Modification</option>
                                        <option value="delivery">Delivery</option>
                                        <option value="pickup">Pickup</option>
                                        <option value="container">Container</option>
                                    </select>
                                    <small class="form-text text-muted pl-1">Select what category this item belongs to.</small>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="rental_type" id="rental_type">
                                        <option selected>Rental Status</option>
                                        <option value="Rental">Rental</option>
                                        <option value="Nonrental">Nonrental</option>
                                    </select>
                                    <small class="form-text text-muted pl-1">Select whether or not the product is a rental product or not.</small>
                                </div>
                            </div>
                            <?= form_close(); ?>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-default form-button">Create</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default form-button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>