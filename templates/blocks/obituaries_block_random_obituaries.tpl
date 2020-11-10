<{if $block.obituaries_random_users|is_array && count($block.obituaries_random_users) > 0 }>
    <table cellspacing="1" class="outer">
        <{foreach item=user from=$block.obituaries_random_users}>
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
<{else}>
    <{$smarty.const._MB_BD_NOOBITUARIES}>
<{/if}>
