<div id="content-search-box">
    <form id="" action="<?=PATH;?>search/index" method="get">
        <div class="pull-left content-search-box-cont" id="im-looking-for_select">
            <nav class="navbar navbar-default rounded" role="navigation">
            <div class="container-fluid no-padding">
                <div data-toggle="dropdown" role="button" id="dropdown-my-select" class="icon-iam_looking_for">I'm looking for</div>
                <ul id="profession" class="dropdown-menu" role="menu">
                    <? foreach($titleObjs as $titleObj):?>
                    <li><span rel="<?=$titleObj->getAttr('name');?>" class="<?=$titleObj->getAttr('class');?>"><?=$titleObj->getAttr('name');?></span></li>
                    <? endforeach;?>									
                </ul>	
            </div>
            </nav>
        </div>
        <div class="pull-left content-search-box-cont" id="location_select">
            <nav class="navbar navbar-default rounded" role="navigation">
            <div class="container-fluid no-padding">
                <ul class="nav navbar-nav" style="float:none">
                    <li>
                    <div role="button">
                        <div class="icon-addon addon-lg">
                            <input id="location-city" type="text" name="city" class="" placeholder="Location" value="" autocomplete="off" />
                            <label for="city" class="glyphicon icon-position3" rel="tooltip" id="localization_input_label">
                            </label>
                        </div>			
                    </div>
                    </li>
                </ul>
            </div>
            </nav>
        </div>
        <div class="pull-left">
            <input type="hidden" name="title" value="" />
            <input type="hidden" name="send" value="ok" />
            <button class="default-btn btn main-search-btn" role="submit">Search</button>
        </div>
    </form>
</div>

<!-- back video -->
<div id="main-background">

    <div class="slide-pattern">
        <div>
            <h1 class="main-h1">A modern way for users to locate and connect</h1>
            <h2 class="main-h2">with health clubs and wellness professionals</h1>
        </div>
    </div>

    <video autoplay loop muted class="my-img2" style="opacity: 1; width: 100%;">
    <source type="video/mp4" src="http://www.masterslider.com/features/templates/ms/fullscreen/video/video.mp4"></source>
    <source type="video/webm" src="http://www.masterslider.com/features/templates/ms/fullscreen/video/video.webm"></source>
    <source type="video/ogg" src="http://www.masterslider.com/features/templates/ms/fullscreen/video/video.ogv"></source>
    </video>

</div>	
<?=$boxes;?>
