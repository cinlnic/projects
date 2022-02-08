<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>

    <h1>Welcome to PHP Motors!</h1>
    <article class="del-desc">
        <h2>DMC Delorean</h2>
            <ul>    
                <li>3 Cup holders</li>
                <li>Superman doors</li>
                <li>Fuzzy Dice!</li>
            </ul>     
        <img id="del-image" src="images/vehicles/delorean.jpg" alt="clipart of the delorean">
        <button class="own-button">Own Today</button> 
    </article>
    <div class="del-content">
        <article class="del-reviews">
            <h2>DMC Delorean Reviews</h2>
            <ul>
                <li>"So fast its almost like traveling in time." (4/5)</li>
                <li>"Coolest ride on the road." (4/5)</li>
                <li>"I'm feeling Marty McFly!" (5/5)</li>
                <li>"The most futuristic ride of our day." (4.5/5)</li>
                <li>"80's living and I love it!" (5/5)</li>
            </ul>
        </article>
        <article class="del-upgrades">
            <h2>Delorean Upgrades</h2>
                <section>
                    <a href="#" title="link to flux-capacitor">
                        <figure class="background">
                            <img src="images/upgrades/flux-cap.png" alt="clipart a flux-capitor">
                        </figure>
                        <h3>Flux Capacitor</h3>
                    </a>
                </section>
                <section>
                    <a href="#" title="link to flames">
                        <figure class="background">
                            <img src="images/upgrades/flame.jpg" alt="clipart of a flame">
                        </figure>
                        <h3>Flame Decals</h3>
                    </a>
                </section>
                <section>
                    <a href="#" title="link to bumper stickers">    
                        <figure class="background">
                            <img src="images/upgrades/bumper_sticker.jpg" alt="clipart of a bumper sticker">
                        </figure>
                        <h3>Bumper Stickers</h3>
                    </a>
                </section>
                <section>
                    <a href="#" title="link to hub caps">
                        <figure class="background">
                            <img src="images/upgrades/hub-cap.jpg" alt="clipart of a hub cap">
                        </figure>
                        <h3>Hub Caps</h3>
                    </a>
                </section>
        </article>
    </div>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
