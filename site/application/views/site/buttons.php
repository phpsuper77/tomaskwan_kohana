<div id="other-sites_buttons">
    <div class="container">
        <form id="" action="<?=PATH;?>search/index" method="get">
            <div class="col-xs-1 no-padding find-class-text">
                <span class="green">FIND</span>
            </div>

            <div class="col-xs-3 no-padding content-search-box-cont" id="im-looking-for_other_select">
                <nav class="navbar navbar-default rounded" role="navigation">
                <div class="container-fluid no-padding">
                    <div data-toggle="dropdown" role="button" id="dropdown-my-select" class="icon-iam_looking_for"><?=__('I\'m looking for')?></div>
                    <ul id="profession" class="dropdown-menu" role="menu">
                        <? foreach($titleObjs as $titleObj):?>
                        <li><span rel="<?=$titleObj->getId();?>" class="<?=$titleObj->getAttr('class');?>"><?=$titleObj->getName();?></span></li>
                        <? endforeach;?>									
                    </ul>	
                </div>
                </nav>
            </div>

            <div class="col-xs-3 no-padding" id="location_other_select">
                <!-- LOCATION -->
                <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid no-padding">
                    <ul class="nav navbar-nav" style="float:none">
                        <li>
                        <div role="button">
                            <div class="icon-addon addon-lg">
                                <input type="text" id="location-city" name="city" class="" placeholder="<?=__('Type a City Name')?>" value="<?= $_GET['city']?>" />
                                <label for="city" class="glyphicon icon-position3" rel="tooltip" id="localization_input_label">
                                </label>
                            </div>			
                        </div>
                        </li>
                    </ul>
                </div>
                </nav>
            </div>

            <div class="col-xs-3 no-padding content-search-box-cont" id="services_select">
                <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid no-padding">
                    <ul class="nav navbar-nav">
                        <li>
                        <div data-toggle="dropdown" role="button" id="dropdown-services-my-select"><?=__('Amenities & Services')?></div>
                        <ul id="amenity" class="dropdown-menu" role="menu">
                            <? foreach($amenityObjs as $amenityObj):?>
                            <li><span rel="<?= $amenityObj->getId();?>"><?= $amenityObj->getName();?></span></li>
                            <? endforeach;?>
                        </ul>
                        </li>
                    </ul>
                </div>
                </nav>
            </div>

            <div class="col-xs-2 pl0">
                <input type="hidden" name="title" value="" />
                <input type="hidden" name="amenity" value="" />
                <input type="hidden" name="send" value="ok" />
                <button class="default-btn btn other-search-btn" role="submit">Search</button>
            </div>
        </form>
    </div>
</div>
<script>
$(function() {
        $("#im-looking-for_other_select .dropdown-menu li span").each(function(idx,li) {
            if ($(li).attr('rel') == '<?= $_GET['title']?>') {
                $( li ).trigger( "click" );
            }
        });
        $("#services_select .dropdown-menu li span").each(function(idx,li) {
            if ($(li).attr('rel') == '<?= $_GET['amenity']?>') {
                $( li ).trigger( "click" );
            }
        });
});
</script>
