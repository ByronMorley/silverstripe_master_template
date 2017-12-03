<!-- HEADER -->
<header>


    <!-- DESKTOP MENU -->

    <div class="container desktop sm-hide xs-hide xxs-hide">
        <div class="inner-container left">
            <a href="#" class="icon home">
                <img src="$ThemeDir/assets/images/logos/tsswp_eng.png"/>
            </a>
        </div>
        <div class="inner-container middle">
            <a href="#" class="inner-icon left icon red">
                <img src="$ThemeDir/assets/images/logos/module_icon.jpg"/>
            </a>
            <div class="title-section">
                <h1>$Title</h1>
            </div>
            <a href="$absoluteBaseURL\main-menu" class="inner-icon icon red right">
                <div class="icon-label">
                    <p>Main menu</p>
                </div>
                <img class="image" src="$ThemeDir/assets/images/logos/menu_icon.jpg"/>
            </a>
        </div>
        <div class="inner-container right">
            <a href="$absoluteBaseURL/home" class="icon image red">
                <div class="icon-label">
                    <p>Account</p>
                </div>
                <img class="image" src="$ThemeDir/assets/images/logos/key_icon.jpg"/>
            </a>


            <% control $Translations %>
                <a href="$Link" hreflang="$Locale.RFC1766" title="$Title" class="icon red $Locale.RFC1766" >
                <div class="icon-label">
                    <p>Change language</p>
                </div>
                <img class="image" src="$ThemeDir/assets/images/logos/change_language_icon.jpg"/>
                </a>
            <% end_control %>
        </div>
    </div>

    <!-- MOBILE MENU -->

    <div class="mobile md-hide lg-hide xl-hide">
        <a href="#" class="icon home">
            <img src="$ThemeDir/assets/images/logos/tsswp_eng.png"/>
        </a>
        <div class="title-section">
            <h1>$Title</h1>
        </div>
        <span id="hamburger-menu" class="inner-icon icon red right">
            <img class="menu-icon" src="$ThemeDir/assets/images/logos/condensed_menu_icon.jpg"/>
            <img class="close-icon" src="$ThemeDir/assets/images/logos/up_arrow_icon.jpg"/>
        </span>
    </div>
    <ul class="condensed-menu md-hide lg-hide xl-hide">
        <li><a href="">Back</a></li>
        <li><a href="$absoluteBaseURL\main-menu">Main menu</a></li>
        <li><a href="$absoluteBaseURL\home">Account</a></li>
        <li><a href="">Change language</a></li>
    </ul>


</header>
<!-- END HEADER -->