<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
<?php
            echo form_open(base_url().'sales_order_new/sales_order/report'); ?>
	<header class="panel-heading font-bold"><i class="fa fa-info-circle"></i> Sales Order Report</header>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-client-general">
<!--                            <div class="form-group">
                                    <label>Sales Leader <span class="text-danger">*</span></label>
                                    <select name="so_created_by">
                                        <option value=""></option>
                                        <?php
                                        if(count($so_created_by)>0)
                                        {
                                            foreach($so_created_by as $key=>$value)
                                            {
                                                echo '<option value="'.$value->username.'">'.$value->username.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>
-->
                            <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status">
                                        <option value="99">All</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Rejected</option>
                                        <option value="3">Sent Quotation</option>
                                        <option value="4">Pending PO</option>
                                        <option value="5">PO Received</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                    <label>Date Start <span class="text-danger">*</span></label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="date_start" data-date-format="<?=config_item('date_picker_format');?>" required>
                            </div>
                            <div class="form-group">
                                    <label>Date End<span class="text-danger">*</span></label>
                                    <input class="input-sm input-s datepicker-input form-control" size="16" type="text" value="" name="date_end" data-date-format="<?=config_item('date_picker_format');?>" required>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>sales_order_new/sales_order" class="btn btn-default" >Cancel</a>
			<button type="submit" class="btn btn-<?=config_item('theme_color');?>">Submit</button>
                        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
                    </form>
                        <?php
                        if($report!=null)
                        {
                            ?>
                    <div id="container1" style="width:100%; height:400px;">
                    </div>
                    <div id="container2">
                            <?php
                            echo "<table width='100%'>";
                            echo "<thead><tr><th>Sales Order Number</th><th>Sales Order Date</th><th>Created By</th><th>Client</th></thead>";
                            echo "<tbody>";
                            if(count($report)>0)
                            {
                                foreach ($report as $key=>$value)
                                {
                                    echo "<tr><td>".$value->so_number."</td><td>".$value->so_date."</td><td>".$value->so_created_by."</td><td>".$value->company_name."</td></tr>";
                                }
                            }
                            echo "</tbody>";
                            echo "</table>";
                        }
                        ?>
                    </div>
<?php
    if($chart!=null)
    {
?>
<script type="text/javascript">
                                                
$(function () {
var chart = new Highcharts.Chart({
    chart: {
            type: 'column'
,renderTo: 'container1'        },
        title: {
            text: 'Monthly Average Sales Order : <?=$status?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                <?php
                if($chart!=null)
                {
                    if(count($chart)>0)
                    {
                        $i=0;
                        foreach($chart as $key=>$value)
                        {
                            if($i>0)
                                echo ",";
                            echo "'".$value->month_year."/".$value->year_year."'";
                            $i++;
                        }
                    }
                }
                ?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Sales Order Quantity'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        credits: {
              enabled: false
          },
                  series: [{
            name: 'Quantity',
            data: [
                <?php
                if($chart!=null)
                {
                    if(count($chart)>0)
                    {
                        $i=0;
                        foreach($chart as $key=>$value)
                        {
                            if($i>0)
                                echo ",";
                            echo $value->quantities;
                            $i++;
                        }
                    }
                }
                ?>
            ]
 
        }]
    });
});
                    </script>
                    <script src="<?=base_url()?>resource/js/highcharts.js"></script>
<script src="<?=base_url()?>resource/js/modules/exporting.js"></script>
    <?php } ?>
            </section>
        </section>
</section>
