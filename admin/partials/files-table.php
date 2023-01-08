<?php

require_once plugin_dir_path(dirname(__FILE__)) . '/includes/class-qi-gateway-admin-table.php';


//Create an instance of our package class...
$qiAdminTable = new QI_GATEWAY_ADMIN_TABLE();
//Fetch, prepare, sort, and filter our data...
$qiAdminTable->prepare_items();
?>
<div class="wrap">
    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="qi-logs-form" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $qiAdminTable->search_box('Search', 'order_id') ?>
        <?php $qiAdminTable->display() ?>
    </form>

</div>
