<link href="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">Create Order</h5>
                    <div class="container">
                        <form>
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
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <small class="form-text text-muted pl-1">Select a customer or create a new one.</small>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success">New</button>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="ordered_by">Ordered By</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="ordered_by" id="ordered_by" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">This field is the name of the person who requested the order.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="type">Order Type</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select" name="type" id="type" disabled>
                                        <option selected>Order Type</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                    <small class="form-text text-muted pl-1">This field is for the mod's label for lockbox, that would be LBOX.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_name">Job Name</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_name" id="job_name" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the job name if there is one.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_address">Job Address</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_address" id="job_address" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out just the <strong>STREET</strong> address.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_city">Job City</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_city" id="job_city" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the city of the job location.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="job_zipcode">Job Zipcode</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="job_zipcode" id="job_zipcode" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the zipcode of the job location.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="tax_rate">Tax Rate</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="tax_rate" id="tax_rate" class="form-control datepicker"  placeholder="" value="0.08">
                                    <small class="form-text text-muted pl-1">Fill out the tax rate of the order.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="onsite_contact">On-Site Contact</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="onsite_contact" id="onsite_contact" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the on-site contact's name.</small>
                                </div>
                            </div>
                            <div class="form-row pt-3">
                                <div class="col-4 align-self-center">
                                    <label class="font-weight-bold" for="onsite_contact_phone">On-Site Contact Phone Number</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="onsite_contact_phone" id="onsite_contact_phone" class="form-control datepicker"  placeholder="">
                                    <small class="form-text text-muted pl-1">Fill out the on-site contact's phone number.</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  

<!-- Date Picker / Time Picker -->
<script src="https://cdn.jsdelivr.net/gh/atatanasov/gijgo@1.8.0/dist/combined/js/gijgo.min.js" type="text/javascript"></script>

<script>
    $('#date').datepicker({
        showOtherMonths: true
    });
</script>

<script>
    $('#time').timepicker({
        showOtherMonths: true
    });
</script>