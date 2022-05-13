<?php

/*
 * rah_knots - XML sitemap plugin for Textpattern CMS
 * https://github.com/gocom/rah_knots
 *
 * Copyright (C) 2013 Jukka Svahn
 *
 * This file is part of rah_knots.
 *
 * rah_knots is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2.
 *
 * rah_knots is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with rah_knots. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Plugin class.
 */
final class Rah_Knots
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        register_callback(array($this, 'styles'), 'admin_side', 'head_end');
        register_callback(array($this, 'javascript'), 'admin_side', 'head_end');
    }

    /**
     * Styles.
     */
    public function styles()
    {
        echo <<<EOF
            <style type="text/css">
                .rah_knots_tip
                {
                    visibility: hidden;
                }
            </style>
EOF;
    }

    /**
     * Initializes the JavaScript.
     */
    public function javascript()
    {
        $js = <<<EOF
            (function ($) {
                $(document).ready(function () {
                    var tipText = 'CTRL+S';

                    if (navigator.userAgent.indexOf('Mac OS X') !== -1) {
                        tipText = '&#8984;+S';
                    }

                    $('form .publish').eq(0)
                        .after(' <small class="rah_knots_tip information">'+tipText+'</small> ')
                        .hover(
                            function () {
                                $(this).siblings('.rah_knots_tip')
                                    .css('opacity', 0)
                                    .css('visibility', 'visible')
                                    .fadeTo(600, 1);
                            },
                            function () {
                                $(this).siblings('.rah_knots_tip')
                                    .fadeTo(300, 0, function() {
                                        $(this).css('visibility', 'hidden');
                                    });
                            }
                        )
                        .click(function () {
                            $(this).siblings('.rah_knots_tip')
                                .css('opacity', 0)
                                .css('visibility', 'hidden');
                        });
                });

                $(window).keydown(function (e) {
                    if (e.which === 19
                        || (String.fromCharCode(e.which).toLowerCase() === 's'
                        && (e.metaKey || e.ctrlKey))
                    ) {
                        var obj = $('form .publish');

                        if (obj.length) {
                            e.preventDefault();
                            obj.eq(0).click();
                        }
                    }
                });
            })(jQuery);
EOF;

        echo script_js($js);
    }
}
