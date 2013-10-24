            <!-- START footer -->
            <footer>
                <!-- START social-links -->
                <ul class="social-links">
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                    <li><a href="{{social_link}}">{{social_link}}</a></li>
                </ul>
                <!-- END social-links -->
                
                <!-- START footer-links -->
                <div class="footer-links">
                    <ul>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                    </ul>
                    <ul>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                        <li><a href="{{footer_link}}">{{footer_link}}</a></li>
                    </ul>
                </div>
                <!-- END footer-links -->
                
                <!-- START footer-info -->
                <div class="footer-info">
                    <span class="payment-methods"><img src="assets/images/structure/payment-methods.jpg" /></span>
                    <address>{{address}}</address>
                    <div class="secure">{{trust_logo}}</div>
                </div>
                <!-- END footer-info -->
            </footer>
            <!-- END footer -->
        </div> <!-- /container -->
        
        <script type="text/javascript">
            $(document).ready(function(){
                $(".subnav").each(function(){
                    $children = $(this).find('ul').length;
                    $width = 170;
                    $(this).css({'width': $children * $width + 'px'});
                });
            });
        </script>
    </body>
</html>
