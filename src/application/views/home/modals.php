<!-- Add New Modal -->
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <!-- TODO: Add an action. -->
            <form class="form-horizontal" method="POST" action="">
            
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add Event</h4>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-sm-2 control-label">Color</label>
                        <div class="col-sm-10">
                            <select name="color" class="form-control" id="color">
                                <option value="">Choose</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                <option style="color:#008000;" value="#008000">&#9724; Green</option>             
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                <option style="color:#000;" value="#000">&#9724; Black</option>
                                <option style="color:#FF1493;" value="#FF1493">&#9724; Pink (Delivery)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-sm-2 control-label">Start date</label>
                        <div class="col-sm-10">
                            <input type="text" name="start" class="form-control" id="start">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-sm-2 control-label">End date</label>
                        <div class="col-sm-10">
                            <input type="text" name="end" class="form-control" id="end">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-gbr" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-gbr">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
                
<!-- Edit Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <!-- TODO: Add an action. -->
            <form class="form-horizontal" method="POST" action="">
                <div class="modal-header gbr-header" style="text-align: center;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-sm-2 control-label">Color</label>
                        <div class="col-sm-10">
                            <select name="color" class="form-control" id="color">
                                <option value="">Choose</option>
                                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                <option style="color:#008000;" value="#008000">&#9724; Green</option>             
                                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                <option style="color:#000;" value="#000">&#9724; Black</option>
                                <option style="color:#FF1493;" value="#FF1493">&#9724; Pink (Delivery)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
                            </div>
                        </div>
                    </div>
                    <div id='response-content' style="margin-top: 50px;">
                        

                    <div id="orderDetailsDiv" class="panel panel-default">
                        <div class="panel-heading text-center">
                            <b>Order Details</b>
                        </div>
                        <div class="panel-body" id="prodInsert">

                        </div>
                    </div>

                    </div>
                    
                    <input type="hidden" name="id" class="form-control" id="id">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-gbr" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-gbr">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>