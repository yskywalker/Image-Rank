<?php
require_once('smarty.include.php');

//mysql settings
$settings['mysql_host'] = 'localhost';
$settings['mysql_user'] = 'root';
$settings['mysql_pass'] = 'root';

//app settings
$settings['images_per_page'] = 10;
$settings['image_width'] = '1000px';

//--end of settings--//

//connect to mySQL
mysql_connect($settings['mysql_host'], $settings['mysql_user'], $settings['mysql_pass']);
mysql_select_db("image_rank");

//process up/down vote (if any)
$action = gp('action');
$imageID = gp('imageID');

if (($action == 'voteUp' || 'voteDown') && isset($imageID))
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
		$newImageRank = $image['imageRank'] + 1;
	}
	$result = mysql_query("UPDATE images SET imageRank='$newImageRank' WHERE imageID='$imageID'")
		or merr("Can't update image rank!");
	redir('index.php');
}


//query db for image datax
$result = mysql_query("SELECT * FROM images ORDER BY images.imageRank DESC")
	or merr("Can't load images!");
$images = mysqlBigArray($result);

//Send data to Smarty
$smarty->assign('images', $images);
$smarty->assign('imageWidth', $settings['image_width']);

//Tell Smarty to display the page
$smarty->display('images.tpl');

//--end main code--//



//--begin function code--//
function mysqlBigArray($result) {
    
    $rows = mysql_num_rows($result);
    
    if ($rows == 0) {return NULL;}
    
    for ($x=1 ; $x<=$rows ; $x++) {
        
        $array[] = mysql_fetch_array($result, MYSQL_ASSOC);
    }
    
    return $array;
}

function merr($message)
{
    die($message . ' mySQL said: ' . mysql_error());
}

function gp($key) {
    
    if (isset($_POST[$key])) {
        
        return $_POST[$key];
    }
    elseif (isset($_GET[$key])){
        
        return $_GET[$key];
    }
    
    return NULL;
}

function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
{
    $do_dump_indent = "<span style='color:#666666;'>|</span> &nbsp;&nbsp; ";
    $reference = $reference.$var_name;
    $keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';
    
    // So this is always visible and always left justified and readable
    echo "<div style='text-align:left; background-color:white; font: 100% monospace; color:black;'>";

    if (is_array($var) && isset($var[$keyvar]))
    {
        $real_var = &$var[$keyvar];
        $real_name = &$var[$keyname];
        $type = ucfirst(gettype($real_var));
        echo "$indent$var_name <span style='color:#666666'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
    }
    else
    {
        $var = array($keyvar => $var, $keyname => $reference);
        $avar = &$var[$keyvar];

        $type = ucfirst(gettype($avar));
        if($type == "String") $type_color = "<span style='color:green'>";
        elseif($type == "Integer") $type_color = "<span style='color:red'>";
        elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
        elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
        elseif($type == "NULL") $type_color = "<span style='color:black'>";

        if(is_array($avar))
        {
            $count = count($avar);
            echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#666666'>$type ($count)</span><br>$indent(<br>";
            $keys = array_keys($avar);
            foreach($keys as $name)
            {
                $value = &$avar[$name];
                do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
            }
            echo "$indent)<br>";
        }
        elseif(is_object($avar))
        {
            echo "$indent$var_name <span style='color:#666666'>$type</span><br>$indent(<br>";
            foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
            echo "$indent)<br>";
        }
        elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color\"".htmlentities($avar)."\"</span><br>";
        elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".htmlentities($avar)."</span><br>";
        elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
        elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
        else echo "$indent$var_name = <span style='color:#666666'>$type(".strlen($avar).")</span> ".htmlentities($avar)."<br>";

        $var = $var[$keyvar];
    }
    
    echo "</div>";
}

function redir($url) {
    
    die("Updating...<script>document.location.href = '$url'</script>");
}