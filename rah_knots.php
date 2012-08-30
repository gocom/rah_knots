<?php

/**
 * rah_knots plugin for Textpattern CMS.
 *
 * @author Jukka Svahn
 * @date 2012-
 * @license GNU GPLv2
 * @link https://github.com/gocom/rah_knots
 * 
 * Copyright (C) 2012 Jukka Svahn <http://rahforum.biz>
 * Licensed under GNU Genral Public License version 2
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

	new rah_knots();

class rah_knots {

	/**
	 * Constructor
	 */

	public function __construct() {
		register_callback(array($this, 'styles'), 'admin_side', 'head_end');
		register_callback(array($this, 'javascript'), 'admin_side', 'head_end');
	}

	/**
	 * Styles
	 */

	public function styles() {
		echo <<<EOF
			<style type="text/css">
				.rah_knots_tip {
					position: absolute;
					margin: 1em 0 0 0.5em;
					display: none;
					vertical-align: baseline;
				}
			</style>
EOF;
	}

	/**
	 * Initializes the JavaScript
	 */

	public function javascript() {

		$js = <<<EOF
			(function() {
				$(document).ready(function() {
					var tipText = 'CTRL+S';

					if(navigator.userAgent.indexOf('Mac OS X') !== -1) {
						tipText = '&#8984;+S';
					}

					$('form .publish').eq(0)
						.after('<small class="rah_knots_tip information">'+tipText+'</small>')
						.hover(function() {
							$(this).next('.rah_knots_tip').fadeToggle();
						});
				});

				$(window).on('keypress keydown', function(e) {
					if(e.which === 19 || (String.fromCharCode(e.which).toLowerCase() === 's' && (e.metaKey || e.ctrlKey))) {
						var obj = $('form .publish');
						if(obj.length) {
							e.preventDefault();
							obj.eq(0).click();
						}
					}
				});
			})();
EOF;

		echo script_js($js);
	}
}

?>