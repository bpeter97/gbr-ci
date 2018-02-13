<section id="list">
    <div class="container-fluid">
        <div class="d-flex flex-row justify-content-center pb-4">
            <div class="card mr-3">
                <div class="card-body">
                    <h5 class="card-title text-center py-2">Container Map</h5>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="container">
                            <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                            <div id="map" style="width:100%;height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card ml-2 w-75">
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
        <div class="d-flex flex-row justify-content-center">
            <div class="card mr-3 w-75">
                <div class="card-body">
                    <h5 class="card-title text-center py-2">Orders / Quotes in 2018</h5>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card ml-2">
                <div class="card-body">
                    <h5 class="card-title text-center py-2">Containers In Stock</h5>  
                    <div class="d-flex flex-row justify-content-center">
                        <div class="table-responsive">
                            
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<?php $this->load->view('home/modals'); ?>

<?php create_map_xml(); ?>