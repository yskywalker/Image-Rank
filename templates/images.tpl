{if $authorized == FALSE}
	
	<form action="?action=authorize" method="post">
		Are you human?  {$captchaMath1} + {$captchaMath2} = <input type="text" name="captchaAnswer"/>
	</form>
	
{/if}

{foreach $images as $image}

	<img src="{$image.imagePath}" width="{$imageWidth}"/>
	<br/>
	
	Sum of all votes on this image: {$image.imageRank} <br/>
	{if $authorized == TRUE}
		<a href="?action=voteUp&amp;imageID={$image.imageID}">Vote Up</a> | <a href="?action=voteDown&amp;imageID={$image.imageID}">Vote Down</a>
	{/if}
	<br/>

{/foreach}