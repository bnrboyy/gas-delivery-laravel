<div class="wad-item-header" style="--background: url(/{{isset($category)?$category->banner:""}})">
  <figure class="wad-item-header-icon">
      <img src="{{isset($category)?$category->icon:""}}" alt="{{isset($category)?$category->banner_alt:""}}" />
  </figure>
  <div class="wad-item-header-title">
      <p>{{isset($category)?$category->title:""}}</p>
      <figure onclick="location.href = '/profile';" style="cursor: pointer;">
          <img src="/img/wash&dry/headerusericon.png" alt="userIcon" />
      </figure>
  </div>
</div>