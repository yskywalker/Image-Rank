<?php

function smarty_block_page_wrapper($parems, $content, $template, &$repeat)
{
    if ($repeat == TRUE) //Beginning of page
    {
        $template->assign('pageTitle', $parems['pageTitle']);
        $template->display('PageWrapperBegin.tpl');
    }
    else //End of page
    {
        echo $content;
        $template->display('PageWrapperEnd.tpl');
    }
}