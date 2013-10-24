<!-- START page-2-col -->
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
            <form id="newsletter_signup" action="/salons/newletter/signup/" method="POST">
                <input type="email" name="email" placeholder="Email Address" />
                <button type="submit" name="newsletter_signup" value="true">Sign Up</button>
            </form>
        </div>

        <!-- START promotions -->
        <div class="sidebar-widget promo" id="{{promotion_id}}">
            <a href="{{promotion_link}}"><img src="assets/images/content/blog-promo.png" /></a>
        </div>
        <!-- END promotions -->
    </aside>
    <div class="content">
        <!-- START hero -->
        <div class="hero-container">
            {{hero_images}}
        </div>
        <!-- END hero -->

        <ul class="homepage-grid">
            <!-- START homepage_grid -->
            <li><div><a href="{{grid_link}}">{{grid_image}}</a></div></li>
            <!-- END homepage_grid -->
        </ul>
    </div>
</div>
<!-- END page-2-col -->