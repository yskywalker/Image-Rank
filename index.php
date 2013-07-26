<?php
//--preliminaries--//

//include needed files
require_once('smarty.include.php');
require_once('authentication.php');
require_once('functions.php');

//setup the session
session_start();
if (!isset($_SESSION['authorized']))
{
	$_SESSION['authorized'] = FALSE;
	echo "you aren't authorized";
}

//--end preliminaries--//


//--settings--//

//mysql settings
$settings['mysql_host'] = 'localhost';
$settings['mysql_user'] = 'root';
$settings['mysql_pass'] = 'root';

//app settings
$settings['images_per_page'] = 10;
$settings['image_width'] = '1000px';

//--end of settings--//


//--setup core variables--//

$errors = array();

//--end setup core variables--//


//--begin main code--//

//connect to mySQL
mysql_connect($settings['mysql_host'], $settings['mysql_user'], $settings['mysql_pass']);
mysql_select_db("image_rank");

//process '?action='
$action = gp('action');
$imageID = gp('imageID');
$captchaAnswer = gp('captchaAnswer');

if (($action == 'voteUp' || 'voteDown') && isset($imageID))
{
	if (authorized($imageID))
	{
		$result = mysql_query("SELECT imageRank FROM images WHERE imageID='$imageID'")
				or merr("Can't load image rank to update it!");
		$image = mysql_fetch_array($result);
		
		if ($action == 'voteUp')
		{	
			$newImageRank = $image['imageRank'] + 1;
			echo 'new image rank =' . $newImageRank;
		}
		elseif ($action == 'voteDown')
		{
			$newImageRank = $image['imageRank'] - 1;
		}
		$result = mysql_query("UPDATE images SET imageRank='$newImageRank' WHERE imageID='$imageID'")
			or merr("Can't update image rank!");
		redir('index.php');
	}
	else
	{
		die("You haven't filled out the CAPTCHA. You can't vote!");
	}
}

if ($action == 'authorize' && isset($captchaAnswer))
{
	if ($captchaAnswer == $_SESSION['captcha_answer'])
	{
		$_SESSION['authorized'] = TRUE;
	}
	redir('index.php');
}

//seed captcha
if (!authorized())
{
	$captchaMath1  = rand(1,10);
	$captchaMath2  = rand(1,10);
	
	//store data in proper locations
	$_SESSION['captcha_answer'] = $captchaMath1 + $captchaMath2;
	
	$smarty->assign('captchaMath1', $captchaMath1);
	$smarty->assign('captchaMath2', $captchaMath2);
}

//query db for image data
$result = mysql_query("SELECT * FROM images ORDER BY images.imageRank DESC")
	or merr("Can't load images!");
$images = mysqlBigArray($result);

//Send data to Smarty
$smarty->assign('images', $images);
$smarty->assign('imageWidth', $settings['image_width']);
$smarty->assign('authorized', authorized_return_text());

//Tell Smarty to display the page
$smarty->display('images.tpl');

//--end main code--//

//goodbye :-)