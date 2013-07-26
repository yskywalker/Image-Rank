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

function authorized_return_text()
{
	if ($_SESSION['authorized'] == TRUE)
	{
		return 'yes';
	}
	else
	{
		return 'no';
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