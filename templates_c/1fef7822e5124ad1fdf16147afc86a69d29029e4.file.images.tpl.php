<?php /* Smarty version Smarty-3.1.12, created on 2013-07-26 04:40:48
         compiled from "./templates/images.tpl" */ ?>
<?php /*%%SmartyHeaderCode:110715880851f1cc5d344330-08543855%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fef7822e5124ad1fdf16147afc86a69d29029e4' => 
    array (
      0 => './templates/images.tpl',
      1 => 1374806433,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '110715880851f1cc5d344330-08543855',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_51f1cc5d6d4f91_09929117',
  'variables' => 
  array (
    'authorized' => 0,
    'captchaMath1' => 0,
    'captchaMath2' => 0,
    'images' => 0,
    'image' => 0,
    'imageWidth' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51f1cc5d6d4f91_09929117')) {function content_51f1cc5d6d4f91_09929117($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['authorized']->value=='no'){?>
	
	<form action="?action=authorize" method="post">
		Are you human?  <?php echo $_smarty_tpl->tpl_vars['captchaMath1']->value;?>
 + <?php echo $_smarty_tpl->tpl_vars['captchaMath2']->value;?>
 = <input type="text" name="captchaAnswer"/>
	</form>
	
<?php }?>

<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
?>

	<img src="<?php echo $_smarty_tpl->tpl_vars['image']->value['imagePath'];?>
" width="<?php echo $_smarty_tpl->tpl_vars['imageWidth']->value;?>
"/>
	<br/>
	
	Sum of all votes on this image: <?php echo $_smarty_tpl->tpl_vars['image']->value['imageRank'];?>

	<a href="?action=voteUp&amp;imageID=<?php echo $_smarty_tpl->tpl_vars['image']->value['imageID'];?>
">Vote Up</a> | <a href="?action=voteDown&amp;imageID=<?php echo $_smarty_tpl->tpl_vars['image']->value['imageID'];?>
">Vote Down</a>
	<br/>

<?php } ?><?php }} ?>