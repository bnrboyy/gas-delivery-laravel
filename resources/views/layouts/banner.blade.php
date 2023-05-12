<div class="orderdetail-item-header" style="--background: url(/{{ isset($category) ? $category->banner : '' }})">
    <figure class="orderdetail-item-header-icon">
        <img src="/{{ isset($category) ? $category->icon : '' }}"
            alt="{{ isset($category) ? $category->banner_alt : '' }}" />
    </figure>
    <div class="orderdetail-item-header-title">
        <p>{{ isset($category) ? $category->title : '' }}</p>
    </div>
</div>
