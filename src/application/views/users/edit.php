<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">Edit User</h5>
                    <?= form_open('users/edit/'.$user->get_id()); ?>
                    <div class="container">
                        <div class="form-row pt-3">
                            <div class="col-sm-12 text-center">
                                <button type="button" onclick="history.go(-1);" class="btn btn-primary">Change User Password</button>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12">
                                <?php if( form_error('username') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('username'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="username" class="form-control" placeholder="Type the username for the new user." value="<?= $user->get_username(); ?>">
                                <small class="form-text text-muted pl-1">This field is the username the user will use to log in with.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('password') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('password'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="password" name="password" id="password" class="form-control is-invalid" placeholder="Type the password for the new user." value="<?= $user->get_password(); ?>" disabled>
                                <small class="form-text text-muted pl-1">This field is the password the user will be using to log in with (minimum 3 characters).</small>
                                <small id="password_verify_req" class="form-text text-muted pl-1"></small>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('password_verify') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('password_verify'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="password" name="password_verify" id="password_verify" class="form-control is-invalid" placeholder="Type the password again." value="<?= $user->get_password(); ?>" disabled>
                                <small class="form-text text-muted pl-1">This field is the password the user will be using to log in with (minimum 3 characters).</small>
                                <small id="password_req" class="form-text text-muted pl-1"></small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('firstname') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('firstname'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="firstname" class="form-control" placeholder="Type the first name of the user." value="<?= $user->get_first_name(); ?>">
                                <small class="form-text text-muted pl-1">Type the first name of the user.</small>
                            </div>
                            <div class="col-sm-12 col-md-6 xs-pt-10 md-pt-0">
                                <?php if( form_error('lastname') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('lastname'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="lastname" class="form-control" placeholder="Type the last name of the user." value="<?= $user->get_last_name(); ?>">
                                <small class="form-text text-muted pl-1">Type the last name of the user.</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('phone') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('phone'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="phone" class="form-control" placeholder="Type the user's phone number." value="<?= $user->get_phone(); ?>">
                                <small class="form-text text-muted pl-1">Type the user's phone number.</small>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('title') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('title'); ?>
                                </div>
                                <?php endif; ?>
                                <input type="text" name="title" class="form-control" placeholder="Type the user's title (Manager, Driver, etc)." value="<?= $user->get_title(); ?>">
                                <small class="form-text text-muted pl-1">Type the user's title (Manager, Driver, etc).</small>
                            </div>
                        </div>
                        <div class="form-row pt-3">
                            <div class="col-sm-12 col-md-6">
                                <?php if( form_error('type') ): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo form_error('type'); ?>
                                </div>
                                <?php endif; ?>
                                <select class="form-control" name="type" id="type">
                                    <option value="<?= $user->get_type(); ?>"><?= $user->get_type(); ?></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Employee">Employee</option>
                                </select>
                                <small class="form-text text-muted pl-1">Select the user type for the user's account.</small>
                                <small id="test_req" class="form-text text-muted pl-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-danger mr-auto" data-toggle="modal" data-target="#ModalDelete">Delete</button>
                        <button type="submit" class="btn btn-success gbr-btn">Update</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-success gbr-btn">Cancel</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= form_open('users/delete/' . $user->get_id()); ?>
            
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    
                    <p>Are you sure you would like to <span class="text-danger"><strong>delete</strong></span> the user?</p>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <button type="button" class="btn btn-success btn-gbr" data-dismiss="modal">No</button>
                </div>

            <?= form_close(); ?>
        </div>
    </div>
</div>