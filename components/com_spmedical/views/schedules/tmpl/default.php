<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

?>

<div id="spmedical" class="spmedical view-spmedical-schedules spmedical-schedules-list">
    <!-- All Schedule -->
	<div class="spmedical-schedules spmedical-table-responsive">
		<table class="spmedical-table table-bordered">
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_MONDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_TUESDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_WEDNESDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_THURSDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_FRIDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_SATURDAY'); ?></th>
					<th scope="col"><?php echo JText::_('COM_SPMEDICAL_SUNDAY'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->schedule_items as $time_key => $specialists) { 
						
					?>
					<tr>
						<td><?php echo $time_key; ?></td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('monday', $specialist->days)){
								$day_key = array_search ('monday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title"><?php echo JText::_('COM_SPMEDICAL_AREA_OF_FOCUS') ?></h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
						<td>
							<?php 
							$j = 1;
							foreach ($specialists as $key => $specialist) {
								if(in_array('tuesday', $specialist->days) ){
								$day_key = array_search ('tuesday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){

								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php $j++; } } } ?>
						</td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('wednesday', $specialist->days)){
								$day_key = array_search ('wednesday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('thursday', $specialist->days)){
								$day_key = array_search ('thursday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('friday', $specialist->days)){
								$day_key = array_search ('friday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){	
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('saturday', $specialist->days)){
								$day_key = array_search ('saturday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
						<td>
							<?php foreach ($specialists as $key => $specialist) {
								if(in_array('sunday', $specialist->days)){
								$day_key = array_search ('sunday', $specialist->days);
								if( $time_key == $specialist->times[$day_key] ){
								$bgcolor = array_rand(array('bg-green' => 'green', 'bg-red' => 'red', '' => ''));
							?>
									<div class="content-wrapper <?php echo $bgcolor; ?>">
										<h3><?php echo $specialist->title; ?></h3>
										<?php if( $specialist->designation ){ ?>
											<h4><?php echo $specialist->designation; ?></h4>
										<?php } ?>
										<!-- Show in hover -->
										<?php if( $specialist->designation ){ ?>
										<div class="details-info">
											<h3 class="title">Area of Focus:</h3>
											<div class="special-in">
												<?php echo $specialist->specialitist_on; ?>
											</div>
										</div>
										<?php } ?>
									</div> <!-- //.content-wrapper -->
							<?php } } } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<!-- //.end All Schedule -->
</div> <!-- /#spmedical -->