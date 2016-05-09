<!-- boxes -->
<div class="home-boxes">			
    <div class="text-center">
        <h3 class="main-h3">Discover Highest Rated in Our Network</h3>
        <h4 class="main-h4">Simplify Your Search With Our Picks of Highest Rated</h4>
    </div>
    <div class="container">
        <div class="col-xs-3">
            <div class="bg-cover main-image" style="background-image: url('<?=IMG;?>temp/main_site_img1.jpg');">
                <div class="my-overlay">
                    <a href="<?=PATH;?>directory/index?title=Health+Club&sort=rating&send=ok"><span class="overlay-seemore">SEE THE LIST</span></a>
                </div>
                <span class="overlay-top">Highest Rated</span>
                <span class="overlay-bottom">HEALTH CLUBS</span>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="bg-cover main-image" style="background-image: url('<?=IMG;?>temp/main_site_img2.jpg');">
                <div class="my-overlay">
                    <a href="<?=PATH;?>directory/index?title=Studio&sort=rating&send=ok"><span class="overlay-seemore">SEE THE LIST</span></a>
                </div>
                <span class="overlay-top">Highest Rated</span>
                <span class="overlay-bottom">STUDIOS</span>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="bg-cover main-image" style="background-image: url('<?=IMG;?>temp/main_site_img3.jpg');">
                <div class="my-overlay">
                    <a href="<?=PATH;?>directory/index?role=2&sort=rating&send=ok"><span class="overlay-seemore">SEE THE LIST</span></a>
                </div>
                <span class="overlay-top">Highest Rated</span>
                <span class="overlay-bottom">PERSONAL TRAINERS</span>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="bg-cover main-image" style="background-image: url('<?=IMG;?>temp/main_site_img4.jpg');">
                <div class="my-overlay">
                    <a href="<?=PATH;?>directory/index?title=<?=$search[0]['speciality'];?>&city=<?=$search[0]['city'];?>&sort=rating&send=ok">
                        <span class="overlay-seemore">SEE THE LIST</span></a>
                </div>
                <span class="overlay-top">Most</span>
                <span class="overlay-bottom">SEARCHED</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<? if (!Auth::instance()->logged_in_user()): ?>
<!-- signup now -->
<div class="sign-up-box text-center">
    <span class="sign-up-head">Sign Up Now</span><br />
    <button class="btn btn-default my-footer-signup" data-toggle="modal" data-target="#registerModal">SIGN UP</button>
</div>
<? endif;?>
