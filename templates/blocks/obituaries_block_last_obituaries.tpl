<{php}>
    global $xoTheme;
    $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
<{/php}>

<script type="text/javascript">
    /*
     * vertical news ticker
     * Tadas Juozapaitis ( kasp3rito@gmail.com )
     * http://plugins.jquery.com/project/vTicker
     */
    (function (a) {
        a.fn.vTicker = function (b) {
            var c = {
                speed: 700,
                pause: 4000,
                showItems: 3,
                animation: "",
                mousePause: true,
                isPaused: false,
                direction: "up",
                height: 0
            };
            var b = a.extend(c, b);
            moveUp = function (g, d, e) {
                if (e.isPaused) {
                    return
                }
                var f = g.children("ul");
                var h = f.children("li:first").clone(true);
                if (e.height > 0) {
                    d = f.children("li:first").height()
                }
                f.animate({top: "-=" + d + "px"}, e.speed, function () {
                    a(this).children("li:first").remove();
                    a(this).css("top", "0px")
                });
                if (e.animation == "fade") {
                    f.children("li:first").fadeOut(e.speed);
                    if (e.height == 0) {
                        f.children("li:eq(" + e.showItems + ")").hide().fadeIn(e.speed)
                    }
                }
                h.appendTo(f)
            };
            moveDown = function (g, d, e) {
                if (e.isPaused) {
                    return
                }
                var f = g.children("ul");
                var h = f.children("li:last").clone(true);
                if (e.height > 0) {
                    d = f.children("li:first").height()
                }
                f.css("top", "-" + d + "px").prepend(h);
                f.animate({top: 0}, e.speed, function () {
                    a(this).children("li:last").remove()
                });
                if (e.animation == "fade") {
                    if (e.height == 0) {
                        f.children("li:eq(" + e.showItems + ")").fadeOut(e.speed)
                    }
                    f.children("li:first").hide().fadeIn(e.speed)
                }
            };
            return this.each(function () {
                var f = a(this);
                var e = 0;
                f.css({overflow: "hidden", position: "relative"}).children("ul").css({
                    position: "absolute",
                    margin: 0,
                    padding: 0
                }).children("li").css({margin: 0, padding: 0});
                if (b.height == 0) {
                    f.children("ul").children("li").each(function () {
                        if (a(this).height() > e) {
                            e = a(this).height()
                        }
                    });
                    f.children("ul").children("li").each(function () {
                        a(this).height(e)
                    });
                    f.height(e * b.showItems)
                } else {
                    f.height(b.height)
                }
                var d = setInterval(function () {
                    if (b.direction == "up") {
                        moveUp(f, e, b)
                    } else {
                        moveDown(f, e, b)
                    }
                }, b.pause);
                if (b.mousePause) {
                    f.bind("mouseenter", function () {
                        b.isPaused = true
                    }).bind("mouseleave", function () {
                        b.isPaused = false
                    })
                }
            })
        }
    })(jQuery);

    jQuery(function () {
        jQuery('.obituaries_last').vTicker({
            speed: 500,
            pause: 6000,
            animation: 'fade',
            mousePause: false,
            showItems: 1
        });
    });

</script>

<{if count($block.obituaries_last_users) >0 }>
    <div style="width:<{$block.obituaries_picture_width}>px;margin:0 auto;" class="obituaries_last">
        <ul>
            <{foreach item=user from=$block.obituaries_last_users}>
                <li style="list-style:none !important;">
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
                    <a style="text-align:center;display:block;"
                       href="<{$smarty.const.OBITUARIES_URL}>user.php?obituaries_id=<{$user.obituaries_id}>"
                       title="<{$user.obituaries_href_title}>"><{$user.obituaries_fullname}></a>
                </li>
            <{/foreach}>
        </ul>
    </div>
<{else}>
    <{$smarty.const._MB_BD_NOOBITUARIES}>
<{/if}>
