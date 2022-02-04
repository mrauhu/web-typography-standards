=== Web Typography Standards ===
Contributors: ram108, mrauhu
Tags: typo, typograph, typography, typogrify, ram108, russian, content, dash, format, hyphenation, prettify, style, text, quotes, typesetting
Requires at least: 3.3.3
Tested up to: 5.9
Stable tag: 0.6.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Автоматическое применение правил типографики для WordPress.
Оnly for the Russian language typography

== Description ==

Плагин автоматически форматирует текст с использованием норм, правил и специфики русского языка и экранной типографики. Более подробно о возможностях плагина читайте описание [Типографа Муравьёва](http://mdash.ru/rules.html).

> *Web Typography Standards* совместим с [шорткодами](https://codex.wordpress.org/ru:Shortcode_API) и фильтрами функции [wptexturize](https://codex.wordpress.org/Function_Reference/wptexturize).

Рекомендуем использовать плагин совместно с любым плагином кэширования.

= Спасибо вам =

Если вам нравится плагин, ваш отзыв очень важен для нас. [Оцените плагин](https://wordpress.org/support/view/plugin-reviews/ram108-typo#postform) в директории плагинов WordPress или напишите обзор в своем блоге.

= Разработка =

Репозиторий плагина:

* https://github.com/mrauhu/web-typography-standards

Если вы нашли ошибку, сообщите нам об этом создав [новую задачу](https://github.com/mrauhu/web-typography-standards/issues/new).

Если вы хотите исправить ошибку, вы можете сделать запрос на добавление кода.

= Introduction =

The plugin implements advanced rules of web typography into Worpdress site. For full features list see description of [Muravjev Typograph](http://translate.google.com/translate?hl=ru&sl=ru&tl=en&u=http%3A%2F%2Fmdash.ru%2Frules.html).

> *Web Typography Standards* comportable with [shortcodes](https://codex.wordpress.org/Shortcode_API) and filters of [wptexturize](https://codex.wordpress.org/Function_Reference/wptexturize) function.

We recommend to use plugin in conjunction with any Cache plugin.

= Thank you =

If you are happy with plugin your feedback is very appreciated. [Rate plugin](https://wordpress.org/support/view/plugin-reviews/ram108-typo#postform) (see stars at the right) in Wordpress plugin directory or write review on your blog.

= Development =

Plugin repository:

* https://github.com/mrauhu/web-typography-standards

If you find a bug, let us know by creating a [new issue](https://github.com/mrauhu/web-typography-standards/issues/new).
If you'd like to fix a bug, you can submit a Pull Request.


== Installation ==

Установите и активируйте плагин как обычно. У плагина нет настроек, он начинает работу сразу после активации.

Install and activate the plugin as usual. There is no settings page. The plugin will start work immediately after activation.

== Screenshots ==

1. Visual demonstration of plugin work

== Changelog ==

= 0.6.2 =

Added ram108 fix for the `$safeType` in the `safe_blocks()` function.

= 0.6.1 =

Fixed bug: removed second `$way` parameter

= 0.6.0 =

Fixed: `create_function()` is removed from PHP 8.

= 0.5.4 =

Fixed bug: wrong breaking string into pieces in function `EMT_wptexturize()`.

= 0.5.3 =

Fixed bug: Russian abbreviations gone wrong, example: `Госдума РФ` -> `Госдума Р. Ф.`

= 0.5.2 =

Fixed bug: broken RSS feed. Now use `wptexturize()` filter if is feed.

= 0.5.1 =

Fixed bug: no space between `|` symbol and Blog name.

= 0.5.0 =

Update Evgeny Muravjev Typograph to version *3.5.0 Gold Master*.

= 0.4.2 =

Added `deploy.sh` script comparable with Windows Git Bash.

= 0.4.1 =

Remove unused function `EMT_safe_tags()`.

= 0.4.0 =

Fixed: plugin hooks registration, now working with WordPress 4.7

= 0.3.2 =

Added information about shortcodes and Wordpress filters comportability.

= 0.3.1 =

Fixed version for autoupdate and short description length.

= 0.3 =

Fixed incomportability with shortcodes.

Added comportability with WordPress filters:

* `run_wptexturize`
* `no_texturize_shortcodes`
* `no_texturize_tags`

Added support for WordPress global variables:

* `$wp_cockneyreplace`
* `$shortcode_tags`

= 0.2.2 =
* OptAlign.all tuned off to avoid excess 'span' and hanging punctuation marks

= 0.2 =
* Updated original mdash script to v3.4 Golden Master

= 0.1 =
* Initial release
