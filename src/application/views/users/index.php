<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center py-3">All Users</h5> 
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Account Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                        <tr class="clickable-row" data-href="<?= base_url() . 'users/edit/' . $user->get_id(); ?>">
                                            <td><?= $user->get_first_name() . ' ' . $user->get_last_name(); ?></td>
                                            <td><?= $user->get_title(); ?></td>
                                            <td><?= $user->get_username(); ?></td>
                                            <td><?= $user->get_phone(); ?></td>
                                            <td><?= $user->get_type(); ?></td>
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



