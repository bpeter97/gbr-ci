<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">Create Customer</h5>
                    <?= form_open('customers/create'); ?>
                    <div class="container">
                        <div class="form-row pt-3">
                            <div class="col">
                                <?php if( form_error('name') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('name'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="name"  id="name" class="form-control" placeholder="Customer Name">
                                <small class="form-text text-muted pl-1">This field is the customer's first and last name or company name.</small>
                            </div>
                            <div class="col">
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
                                <input type="text" name="address1"  id="address1" class="form-control" placeholder="Address">
                                <input type="text" name="address2"  id="address2" class="form-control" placeholder="Address Line 2">
                                <small class="form-text text-muted pl-1">This field is the customer's first and second lines of their address.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <?php if( form_error('phone') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                <small class="form-text text-muted pl-1">This field is the customer's phone number.</small>
                            </div>
                            <div class="col">
                                <?php if( form_error('city') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('city'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="city" id="city" class="form-control" placeholder="City">
                                <small class="form-text text-muted pl-1">This field is the customer's city.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <input type="text" name="fax" id="fax" class="form-control" placeholder="Fax Number">
                                <small class="form-text text-muted pl-1">This field is the customer's fax number.</small>
                            </div>
                            <div class="col">
                                <input type="text" name="ext" id="ext" class="form-control" placeholder="Extension">
                                <small class="form-text text-muted pl-1">This field is the customer's extension.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <?php if( form_error('email') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('email'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="email" id="email" class="form-control" placeholder="E-mail">
                                <small class="form-text text-muted pl-1">This field is the customer's e-mail.</small>
                            </div>
                            <div class="col">
                                <?php if( form_error('state') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('state'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="state" id="state" class="form-control" placeholder="State">
                                <small class="form-text text-muted pl-1">This field is the customer's state (ex: CA).</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <input type="text" name="rdp" id="rdp" class="form-control" placeholder="RDP">
                                <small class="form-text text-muted pl-1">This field is the customer's RDP.</small>
                            </div>
                            <div class="col">
                                <?php if( form_error('zipcode') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('zipcode'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zipcode">
                                <small class="form-text text-muted pl-1">This field is the customer's 5 number zipcode.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <select class="form-control" name="flag" id="flag">
                                    <option value="No" selected>Choose One</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                <small class="form-text text-muted pl-1">Place a flag on customers account.</small>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <textarea class="form-control" name="flag_reason" id="flag_reason" rows="3" placeholder="Explain the reason for the flag."></textarea>
                                <small class="form-text text-muted pl-1">Explain the flag through the flag notes.</small>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col">
                                <textarea class="form-control" name="notes" id="notes" rows="4" placeholder="Notes that relate to the customer."></textarea>
                                <small class="form-text text-muted pl-1">Notes that relate to the customer.</small>
                            </div>
                        </div>  
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-success gbr-btn">Create</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-success gbr-btn">Cancel</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>