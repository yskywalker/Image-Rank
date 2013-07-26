<?php

function authorized()
{
	if ($_SESSION['authorized'] == TRUE)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function can_vote($imageID)
{
	if (authorized())
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}