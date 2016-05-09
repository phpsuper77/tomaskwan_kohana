<!-- CALENDAR -->
<div id="schedule" class="carousel slide schedule-carousel" data-wrap="false" data-interval="false">
	<a class="timetable-control go-left green" href="#schedule" role="button" data-slide="prev"><i class="icon-arrow_left"></i></a>
   	<a class="timetable-control go-right green" href="#schedule" role="button" data-slide="next"><i class="icon-arrow_right"></i></a>
                
   	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<? for($i=1;$i<=60;$i=$i+7):?>
          	<!-- WEEK -->
           	<div class="item<?=$i==1 ? ' active' : '';?>" style="">
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
                <tbody>
                <? for($h=strtotime($modelSettings->getMinTime($trainerObj->getId()));$h<=strtotime($modelSettings->getMaxTime($trainerObj->getId()));$h=$h+$trainerObj->getId('session')):?>
					<? $x=0;?>
					<? foreach($days as $day):?>	
                    	<td align="center" style="padding:0;">
						<button type="button" <?=$modelOrder->checkBooking($date[$x].' '.date('H:i:s',$h),$trainerObj->getId())==FALSE && $modelClass->checkClass(date('H:i:s',$h),$date[$x],$day,$trainerObj->getId(),TRUE)==FALSE && $modelSettings->checkTime($trainerObj->getId(),date('H:i:s',$h),$day)==TRUE ? 'class="mbook hour hour-active"' : 'class="hour hour-no-active" disabled="disabled"';?> data-date="<?=$date[$x].' '.date('H:i',$h);?>"><?=date('h:i a',$h);?></button></td> 
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
