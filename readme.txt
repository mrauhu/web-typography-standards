=== Web Typography Standards ===
Contributors: ram108, mrauhu
Tags: typo, typograph, typography, typogrify, ram108, russian, content, dash, format, hyphenation, prettify, style, text, quotes, typesetting
Requires at least: 3.3.3
Tested up to: 4.2.2
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Автоматическое применение правил типографики для WordPress. 
This plugin is designed only for the Russian language typography.

== Description ==

Плагин автоматически форматирует текст с использованием норм, правил и специфики русского языка и экранной типографики. Более подробно о возможностях плагина читайте описание [Типографа Муравьёва](http://mdash.ru/rules.html).

Рекомендуем использовать плагин совместно с любым плагином кэширования.

= Спасибо вам =

Если вам нравится плагин, ваш отзыв очень важен для нас. Оцените плагин (смотрите звездочки справа) в директории плагинов WordPress или напишите обзор в своем блоге.

= Разработка =

Репозиторий плагина:

* https://github.com/mrauhu/web-typography-standards

Если вы нашли ошибку, сообщите нам об этом создав [новую задачу](https://github.com/mrauhu/web-typography-standards/issues/new).

Если вы хотите исправить ошибку, вы можете сделать запрос на добавление кода.

= Introduction =

The plugin implements advanced rules of web typography into Worpdress site. For full features list see description of [Muravjev Typograph](http://translate.google.com/translate?hl=ru&sl=ru&tl=en&u=http%3A%2F%2Fmdash.ru%2Frules.html).

We recommend to use plugin in conjunction with any Cache plugin.

= Thank you =

If you are happy with plugin your feedback is very appreciated. Rate plugin (see stars at the right) in Wordpress plugin directory or write review on your blog.

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