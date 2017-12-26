<{if ($block.obituaries_today_users|@count)}>
    <table cellspacing="1" class="outer">
        <{foreach item=user from=$block.obituaries_today_users}>
            <tr class="<{cycle values="even,odd"}>" valign="middle">
                <td align="center">
                    <{if $block.obituaries_display_picture == 1 && $user.obituaries_picture_url != ''}>
                        <a href="<{$smarty.const.OBITUARIES_URL}>user.php?obituaries_id=<{$user.obituaries_id}>"
                           title="<{$user.obituaries_href_title}>">
                            <img src="<{$user.obituaries_picture_url}>" alt="<{$user.obituaries_href_title}>"
                                 width="<{$block.obituaries_picture_width}>">
                        </a>
                        <br>
                    <{else}>
                        <a href="<{$smarty.const.OBITUARIES_URL}>user.php?obituaries_id=<{$user.obituaries_id}>"
                           title="<{$user.obituaries_href_title}>">
                            <img src="<{$xoops_url}>/modules/obituaries/assets/images/nophoto.jpg"
                                 alt="<{$user.obituaries_href_title}>" width="<{$block.obituaries_picture_width}>">
                        </a>
                        <br>
                    <{/if}>
                    <a href="<{$smarty.const.OBITUARIES_URL}>user.php?obituaries_id=<{$user.obituaries_id}>"
                       title="<{$user.obituaries_href_title}>"><{$user.obituaries_fullname}></a>
                </td>
            </tr>
        <{/foreach}>
    </table>
    <{if $block.obituaries_today_more }>
        <div align="center"><a
                    href="<{$smarty.const.OBITUARIES_URL}>index.php?op=today"><{$smarty.const._MB_OBITUARIES_SHOW_MORE}></a>
        </div>
    <{/if}>
<{else}>
    <{$smarty.const._MB_BD_NOOBITUARIES}>
<{/if}>
