<div class="gadgets-gadget-chrome" style="width:<?php echo $width ?>px;">
<div id="gadgets-gadget-title-bar-<?php echo $mid ?>" class ="gadgets-gadget-title-bar partsHeading">
<div class="gadgets-gadget-title-button-bar"><?php 
if ($isViewer)
{
  if ($hasSettings)
  {
    echo link_to("Settings","application/setting?mid=".$mid);
  }
}
else
{
  echo "add this application";
}
?></div>
<span id="remote_iframe_<?php echo $mid ?>_title" class="gadgets-gadget-title"><?php echo $title ?></span>
</div>
<div class="gadget-gadget-content">
<iframe width="<?php echo ($width) ?>" scrolling="on" height="<?php echo ($height) ?>" frameborder="no" src="<? echo $iframe_url ?>" class="gadgets-gadget" name="remote_iframe_<?php echo $mid ?>" id="remote_iframe_<?php echo $mid ?>"></iframe>
</div>
</div>
