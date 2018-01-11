<!-- Block mymodule -->
<div id="recommendationsplugin_block_home" class="block">
  {foreach from=$products item=product name=posTabCategory}
                     <div id="tabtitle_{$product.id}" class="tab_title">
                            <h2>
                                <span>{$product.name}</span>
                            </h2>
                    </div>
  {/foreach}
</div>
