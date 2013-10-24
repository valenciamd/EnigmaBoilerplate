<!-- START site-search -->
<div class="search-container">
    <a class="info-link">{{page_notice}}</a>
    <form id="product_search" action="shop/search/" method="POST">
        <div class="input-col">
            <input type="text" name="product" placeholder="Search by code or product name" />
            <button type="submit" id="product_search_btn" name="search_type" value="product"><i class="icon-search"></i></button>
        </div>
        <div class="input-col">
            <select name="brand" onchange="/* {{Do Page Redirect}} */ return false;">
                <option disabled selected>Search Brands</option>
                <option value="{{brand id}}">{{brand name}}</option>
            </select>
            <input type="hidden" name="brand_search" value="false" />
        </div>
    </form>
</div>
<!-- END site-search -->