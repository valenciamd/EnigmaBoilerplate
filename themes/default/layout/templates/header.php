<header>
    <!-- START header -->
    <div class="logo-container">
        <a href="{{site_root}}" class="logo">
            <img src="{{site_logo}}" alt="{{site_title}}" id="logo" />
            <h1>{{site_subtitle}}</h1>
        </a>
        <img src="{{site_root}}themes/{{site_theme}}/assets/images/structure/trade.png" class="trade" />
    </div>
    <div class="login-container">
        <!-- START basket -->
        <div class="my-basket">
            <div class="basket">
                <a href="{{site_root}}basket/">
                    <span>My Basket</span>
                    <i class="icon-basket"></i>
                </a>
            </div>
            <div class="item-count">
                <a href="basket/">{{basket_count}} items £{{basket_price}}</a> 
            </div>
        </div>
        <!-- END basket -->

        <!-- START login -->
        <div class="login">
            <h2>Log In:</h2>
            <form id="login_user" action="{{site_root}}customer/authenticate/" method="POST">
                <div class="input-col">
                    <input type="email" name="user_email" placeholder="Email Address" />
                    <small><a href="{{site_root}}customer/register/">Register</a></small>
                </div>
                <div class="input-col">
                    <input type="password" name="user_pass" placeholder="Password" />
                    <small><a href="{{site_root}}customer/reset-password/">Forgot Password?</a></small>
                </div>
                <div class="input-col submit-col">
                    <input type="hidden" name="url_redirect" value="{{page_url}}" />
                    <button type="submit" name="login_user">Go</button>
                    <small><a href="{{site_root}}help/">Help</a> | <a href="{{site_root}}contact/">Contact Us</a></small>
                </div>
            </form>
            <img class="payment-methods" src="{{site_root}}themes/{{site_theme}}/assets/images/structure/payment-methods.jpg" />
        </div>
        <!-- END login -->
    </div><!-- /login container -->
    <!-- END header -->
</header>