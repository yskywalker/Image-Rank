{foreach $images as $image}
<img src="{$image.imagePath}" width="{$imageWidth}"/>
<br/>

Sum of all votes on this image: {$image.imageRank}
<a href="?action=voteUp&amp;imageID={$image.imageID}">Vote Up</a> | <a href="?action=voteDown&amp;imageID={$image.imageID}">Vote Down</a>
<br/>
{/foreach}