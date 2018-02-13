<!-- ########## Below is the Calendar ########## -->
<script>

$(document).ready(function() {


$('#calendar').fullCalendar({
    header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
    },
    height: 450,
    editable: true,
    eventLimit: true, // allow "more" link when too many events
    selectable: true,
    selectHelper: true,
    businessHours: true,
    navLinks: true,
    select: function(start, end) {
    
    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
    $('#ModalAdd').modal('show');
    },
    eventRender: function(event, element) {
    element.bind('dblclick', function() {

        $('#ModalEdit #id').val(event.id);
        $('#ModalEdit #title').val(event.title);
        $('#ModalEdit #color').val(event.color);
        if(event.custom == false)
        {
                var getRidOfDiv = document.getElementById('orderDetailsDiv');
                getRidOfDiv.style.display = 'block';
                var prodTable = createProdTable(event);
                $('#ModalEdit #prodInsert').html(prodTable);
        } else {
            var getRidOfDiv = document.getElementById('orderDetailsDiv');
            getRidOfDiv.style.display = 'none';
        }
        $('#ModalEdit').modal('show');
    });
    },
    eventDrop: function(event, delta, revertFunc) { // si changement de position

    edit(event);

    },
    eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

    edit(event);

    },

    events: [
    <?php if($events != null): ?>
    <?php foreach($events as $event): 
    
    $start = explode(" ", $event->get_start());
    $end = explode(" ", $event->get_end());
    if($start[1] == '00:00:00'){
        $start = $start[0];
    }else{
        $start = $event->get_start();
    }
    if($end[1] == '00:00:00'){
        $end = $end[0];
    }else{
        $end = $event->get_end();
    }
    ?>
    {
        id: '<?php echo $event->get_id(); ?>',
        title: '<?php echo $event->get_title(); ?>',
        start: '<?php echo $start; ?>',
        end: '<?php echo $end; ?>',
        <?php echo 'color: "'.$event->get_color().'",'.PHP_EOL; ?>
        order_id: <?= $event->get_order_id(); ?>,
        <?php

        if($event->get_order_id() == 0 || $event->get_order_id() == ''){
            echo 'custom: true,'.PHP_EOL;
        } else {
            echo 'custom: false,'.PHP_EOL;
            $prodCount = 0;
            foreach($event->order->get_products() as $prod)
            {
                echo 'prod'.$prodCount.': "'.$prod->get_mod_name().'",'.PHP_EOL;
                echo 'productQty'.$prodCount.': '.$prod->get_product_quantity().','.PHP_EOL;
                $prodCount++;
            }
            echo 'prodCount: '.$prodCount.','.PHP_EOL;
            echo 'order_customer: "'.$event->order->get_customer().'"'.PHP_EOL;
        }
        ?>
    },
    <?php endforeach; ?>
    <?php endif; ?>
    ]
});

function edit(event){
    start = event.start.format('YYYY-MM-DD HH:mm:ss');
    if(event.end){
    end = event.end.format('YYYY-MM-DD HH:mm:ss');
    }else{
    end = start;
    }
    
    id =  event.id;
    
    Event = [];
    Event[0] = id;
    Event[1] = start;
    Event[2] = end;

    $.ajax({
    type: "POST",
    data: {Event:Event},
    url: "<?php echo base_url() . '/home/modifyEvent'; ?>",
    success: function() {
        alert('Date has been updated.');
    }
    });
}

function createProdTable(event)
{
    // Check to see if the event has an order or products to create the table, if not, return empty variable.
    <?php if($events != null): ?>
    <?php if($event->order !== null && $event->order->get_products() !== null): ?>
    var prodTable = '<table class="table table-striped table-hover">';
    prodTable += '<tr><th>Product</th><th>Quantity</th></tr>';
    <?php $i=1; ?>
    var l = 1;
    <?php foreach($events as $event): ?>
        <?php if($event->get_order_id() !== null): ?>
        eventOrderId = <?php echo $event->get_order_id(); ?>;
        console.log(event.order_id);
        if(eventOrderId != ''){
            if(eventOrderId == event.order_id)
            {
                <?php foreach($event->order->get_products() as $prod): ?>
                    <?php
                    if($prod->get_item_type() != 'pickup' && $prod->get_item_type() != 'delivery'){
                        echo "prodTable += '<tr><td>".$prod->get_mod_name()."</td><td>".$prod->get_product_quantity()."</td></tr>';";
                    } 
                    ?>
                <?php endforeach; ?>
            }
        }
        <?php endif; ?>
        
    <?php endforeach; ?>
    prodTable += '</table>';
    <?php endif; ?>
    return prodTable;
    <?php endif; ?>
}

function postData(order_id){
    $.post("<?php echo base_url() . '/home/getOrderInfo'; ?>", { order_id: order_id }, function(response) {
        // Inserts your chosen response into the page in 'response-content' DIV
        $('#response-content').html(response); // Can also use .text(), .append(), etc
    });
}

});

</script>