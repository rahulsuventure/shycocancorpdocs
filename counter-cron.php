<?php

function Once_30_custom_cron_schedule( $schedules ) {
    $schedules['once_every_thirty_minutes'] = array(
        'interval' => 30*60,
		'display' => __('Once every 30 minutes')
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'Once_30_custom_cron_schedule' );
if ( ! wp_next_scheduled( 'once_thirty_minutes_cron_hook' ) ) {
    wp_schedule_event( time(), 'once_every_thirty_minutes', 'once_thirty_minutes_cron_hook' );
}
add_action( 'once_thirty_minutes_cron_hook', 'once_thirty_minutes_cron_function' );
function once_thirty_minutes_cron_function() {
    $counter_value = get_option('counter_value');
	if(empty($counter_value)){
		$counter_value=25000000;
	}
	update_option('counter_value',$counter_value+1000);
} 

add_shortcode('counter_cron','counter_cron');
function counter_cron(){
	$counter_value = get_option('counter_value');
	if(empty($counter_value)){
		update_option('counter_value',25000000);
		$counter_value=25000000;
	}
	$max_value = $counter_value + 1000;
	$array = str_split($counter_value);
	ob_start();
	?>
	<div class="counter_value">
		<ul class="counter_value_ul" id="counter_value_ul" >
		<?php foreach($array as $k){ ?>
			<li><?php echo $k;?></li>
		<?php } ?></ul>
	</div>
	<style>
		.rh-post-wrapper { 		float: left; 		width: 100%; 	}
		.counter_value { 		float: left; 		width: 100%; 	}
		.counter_value ul { 		float: left; 		width: 100%; 		list-style-type: none; 		display: flex; 	}
		.counter_value ul li { 		float: left; 		list-style: none; 		border: 1px solid #e05b2a; 		border-radius: 5px; 		color: #e05b2a; 		font-weight: bold; 		font-size: 24px; 		margin: 0; 		padding: 0; 		margin-right: 7px; 		padding: 10px; 	}
	</style>
	<?php
	echo ob_get_clean();
	return;
}



?>