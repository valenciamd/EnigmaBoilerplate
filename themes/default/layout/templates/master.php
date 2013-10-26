<!-- START content -->
<div class="page two-col">
    <aside class="sidebar-left">
        <div class="sidebar-widget customer-services">
            <h5>Customer Services</h5>
            <p class="tel">
                <i class="icon-phone"></i>
                <span>{{customer_services_number}}</span>
            </p>
        </div>

        <div class="sidebar-widget newsletter-signup">
            <h5>Newsletter Signup</h5>
            <form id="newsletter_signup" action="{{site_root}}newletter/signup/" method="POST">
                <input type="email" name="email" placeholder="Email Address" />
                <button type="submit" name="newsletter_signup" value="true">Sign Up</button>
            </form>
        </div>

        <!-- START sidebar_promotions -->
        <div class="sidebar-widget promo" id="{{promo_id}}">
            <a href="{{promo_link}}"><img src="{{promo_image}}" /></a>
        </div>
        <!-- END sidebar_promotions -->
    </aside>
    <div class="content">
        <!-- START hero -->
        <div class="hero-container">
            {{hero_images}}
        </div>
        <!-- END hero -->

        <ul class="homepage-grid">
            <!-- START homepage_promotions -->
            <li id="{{promo_id}}}"><div><a href="{{promo_link}}"><img src="{{promo_image}}" /></a></div></li>
            <!-- END homepage_promotions -->
        </ul>
    </div>
</div>
<!-- END content -->