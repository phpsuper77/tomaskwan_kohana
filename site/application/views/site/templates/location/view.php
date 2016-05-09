<div class="page-container">
    <?= $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head">
                <div class="page-title">
                    <h1><?= __('MENU_LOCATIONS') ?></h1>
                </div>
            </div>
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                <a href="<?= PATH;?>dashboard"><?= __('MENU_DASHBOARD') ?></a>
                <i class="fa fa-circle"></i>
                </li>
                <li><?= __('MENU_BUSINESS') ?><i class="fa fa-circle"></i></li>
                <li>
                <a href="<?= PATH;?>location/list"><?= __('MENU_LOCATIONS') ?></a>
                </li>
            </ul>
            <div class="clearfix"></div>

            <div class="tabbable-line">
<!--
                <ul class="nav nav-tabs">
                    <li class="active">
                    <a href="#main" data-toggle="tab">
                        Class </a>
                    </li>
                </ul>
                -->
            </div>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="main">

                    <div class="row margin-top-10">
                        <div class="col-md-6">
                                <?= Partial::portlet_location($loginUserObj, __('LOCATION'), $locationObj); ?>
                        </div>
                        <div class="col-md-6">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function initialize() {
    var mapCanvas = document.getElementById('map');
    var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var address = "<?=$locationObj->getAddress()?>, <?=$locationObj->getCity()?>";
    var map = new google.maps.Map(mapCanvas, mapOptions)
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
            map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 

          }
        } 
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
