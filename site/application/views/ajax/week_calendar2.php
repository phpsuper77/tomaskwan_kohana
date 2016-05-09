<!-- CALENDAR -->
<div id="week_calendar" class="carousel slide schedule-carousel" data-wrap="false" data-interval="false">
	<a class="timetable-control go-left green" href="#week_calendar" role="button" data-slide="prev"><i class="icon-arrow_left"></i></a>
   	<a class="timetable-control go-right green" href="#week_calendar" role="button" data-slide="next"><i class="icon-arrow_right"></i></a>
                
   	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
       	<? for($i=0;$i<=60;$i=$i+7):?>
          	<!-- WEEK -->
           	<div class="item<?=$i==0 ? ' active' : '';?>" style="">
				<div class="weekname text-center fs18 font-medium mb10"><?= date('F, Y',strtotime('+'.($i+2).'days'));?></div>
                <table class="table table-light calendar">
                <thead>
                   	<tr>
                   	<? for($j=0;$j<=6;$j++):?>
	           			<? $daystr = ' +'.$i+$j.' days';?>
						<th align="center" style="text-align:center;">
                        	<?=date('D',strtotime($daystr));?><br />
							<?=date('d/m',strtotime($daystr));?>
                        </th>
                        <? $days[$j] = date('N',strtotime($daystr));?>
                        <? $date[$j] = date('m/d/Y',strtotime($daystr));?>
                	<? endfor;?>
                   	</tr>
               	</thead>
                <tbody style="max-height:300px;">
                <? for($h=strtotime($modelSettings->getMinTime($trainerObj->getId()));$h<strtotime($modelSettings->getMaxTime($trainerObj->getId()));$h=$h+900):?>
					<tr>
					<? $x=0;?>
					<? foreach($days as $day):?>	
                    	<? if($cweek[$day]>0):?>
                        	<? $cweek[$day]--;?>
                        <? elseif($bweek[$day]>0):?>
                          	<? $bweek[$day]--;?>
                        <? else:?>
							<? $booking = $modelOrder->checkBooking($date[$x].' '.date('H:i:s',$h),$trainerObj->getId());?>										
                            <? $class = $modelClass->checkClass(date('H:i:s',$h),$date[$x],$day,$trainerObj->getId());?>														
							<? if($booking==FALSE && $class==FALSE):?>
                               	<td align="center"><?=date('h:i',$h);?> - <?=date('h:i a',$h+900);?></td>                   
							<? else:?>
                            	<? if($class!=FALSE):?>
                                    <? $cweek[$day]=(strtotime($class['time_to'])-strtotime($class['time_from']))/900;?>
                                    <td class="cal-check" rowspan="<?=$cweek[$day];?>" align="center" style="padding:0;">
										<p><?=date('h:i',$h);?> - <?=date('h:i a',$h+$cweek[$day]*900);?></p>
                                    	<p>CLASS</p>
                                        <p><?=$class['name'];?></p>
                                    </td>
                                    <? $cweek[$day]--;?>
								<? else:?>
                                    <? $bweek[$day]=$trainerObj->getAttr('session')/900;?>
                                    <td rowspan="<?=$bweek[$day];?>" align="center" style="padding:0;">
										<button class="btn green" style="padding:<?=$bweek[$day]*14;?>px 25px;"><?=date('h:i a',$h);?>-<?=date('h:i a',$h+$bweek[$day]*900);?><br />Booking</button>
                                    </td>
                                    <? $bweek[$day]--;?>
								<? endif;?>                                                      
							<? endif;?>
						<? endif;?>
					<? $x++;?>
					<? endforeach;?>
                    </tr>
				<? endfor;?>
                </tbody>           
                </table>  
            </div>
    	<? endfor;?>
	</div>
</div>
<!-- END CALENDAR -->
