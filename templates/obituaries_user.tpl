<{if isset($obituaries_user)}>

    <{$breadcrumb}>

    <{if $xoops_isadmin}>
        [
        <a href="<{$xoops_url}>/modules/obituaries/admin/main.php?op=edit&id=<{$obituaries_user.obituaries_id}>"><{$smarty.const._EDIT}></a>
        ]
    <{/if}>
    <br>
    <br>
    <p align="center">
        <a href="<{$xoops_url}>/modules/obituaries/index.php"><img
                    src="<{$xoops_url}>/modules/obituaries/assets/images/logo.png" alt=""></a>
    </p>
    <br>
    <br>
    <br>
    <div style="margin-left: 10px; text-align: justify;">

        <{if trim($obituaries_user.obituaries_full_imgurl) != ''}>
            <div style="margin-left:10px; margin-top: 5px; margin-bottom: 5px; margin-right: 10px; float: left;">

                <img src="<{$obituaries_user.obituaries_full_imgurl}>"
                     alt="<{$obituaries_user.obituaries_href_title}>">

            </div>
        <{elseif trim($obituaries_user.obituaries_user_user_avatar) != ''}>
            <div style="margin-left:10px; margin-top: 5px; margin-bottom: 5px; margin-right: 10px; float: left;">

                <img src="<{$xoops_url}>/uploads/<{$obituaries_user.obituaries_user_user_avatar}>"
                     alt="<{$obituaries_user.obituaries_href_title}>">

            </div>
        <{else}>
            <div style="margin-left:10px; margin-top: 5px; margin-bottom: 5px; margin-right: 10px; float: left;">

                <img src="<{$xoops_url}>/modules/obituaries/assets/images/nophoto.jpg"
                     alt="<{$obituaries_user.obituaries_href_title}>" width="130">

            </div>
        <{/if}>

        <h3><{$obituaries_user.obituaries_fullname}></h3>

        <b><{$smarty.const._AM_OBITUARIES_DATE}></b> : <{$obituaries_user.obituaries_formated_date}>

        <br>

        <b><{$smarty.const._AM_OBITUARIES_FIRSTNAME}></b> : <{$obituaries_user.obituaries_firstname}>

        <br>

        <b><{$smarty.const._AM_OBITUARIES_LASTNAME}></b> : <{$obituaries_user.obituaries_lastname}>

        <br><br>

        <{*<b><{$smarty.const._AM_OBITUARIES_DESCRIPTION}></b> : <{$obituaries_user.obituaries_description}>*}>
        <b><{$title1}></b> : <{$obituaries_user.obituaries_description}>



        <br><br>

        <{*<b><{$smarty.const._AM_OBITUARIES_SURVIVORS}></b> : <{$obituaries_user.obituaries_survivors}>*}>
        <b><{$title2}></b> : <{$obituaries_user.obituaries_survivors}>

        <br><br>

        <{*<b><{$smarty.const._AM_OBITUARIES_SERVICE}></b> : <{$obituaries_user.obituaries_service}>*}>
        <b><{$title3}></b> : <{$obituaries_user.obituaries_survivors}>

        <{if $obituaries_user.obituaries_memorial != ""}><br><br>
            <{*<b><{$smarty.const._AM_OBITUARIES_MEMORIAL}></b>: <{$obituaries_user.obituaries_memorial}>*}>
            <b><{$title4}></b> : <{$obituaries_user.obituaries_survivors}>
        <{/if}>
    </div>
    <{if $obituaries_user.obituaries_uid > 0}>
        <br>
        <br>
        <div align="center"><b><a
                        href="<{$xoops_url}>/userinfo.php?uid=<{$obituaries_user.obituaries_uid}>"><{$smarty.const._AM_OBITUARIES_XOOPS_PROFILE}></a></b>
        </div>
        <br>
    <{/if}>

<{/if}>

<div style="text-align: center; padding: 3px; margin:3px;">

    <{$commentsnav}>

    <{$lang_notice}>

</div>


<div style="margin:3px; padding: 3px;">

    <{if $comment_mode == "flat"}>

        <{include file="db:system_comments_flat.tpl"}>

    <{elseif $comment_mode == "thread"}>

        <{include file="db:system_comments_thread.tpl"}>

    <{elseif $comment_mode == "nest"}>

        <{include file="db:system_comments_nest.tpl"}>

    <{/if}>

</div>
