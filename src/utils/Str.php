<?php namespace js13kgames\utils;

	/**
	 * String Utilities
	 *
	 * @package     Js13kgames\Utils
	 * @version     0.0.1
	 * @author      Michal Chojnacki <m.chojnacki@muyo.pl>
	 * @copyright   2012-2014 js13kGames Team
	 * @link        http://js13kgames.com
	 */

	class Str extends \nyx\utils\Str
	{
		/**
		 *
		 *
		 * Derp, borrowed rom Wordpress.
		 */

		public static function p($p, $tabs = 4, $br = 1)
		{
			$tabString = null;

			if(trim($p) === '') return '';

			$p = $p . "\n"; // just to make things a little easier, pad the end
			$p = preg_replace('|<br />\s*<br />|', "\n\n", $p);
			// Space things out a little
			$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
			$p = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $p);
			$p = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $p);
			$p = str_replace(array("\r\n", "\r"), "\n", $p); // cross-platform newlines
			if ( strpos($p, '<object') !== false ) {
				$p = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $p); // no pee inside object/embed
				$p = preg_replace('|\s*</embed>\s*|', '</embed>', $p);
			}
			$p = preg_replace("/\n\n+/", "\n\n", $p); // take care of duplicates
			// make paragraphs, including one at the end
			$pees = preg_split('/\n\s*\n/', $p, -1, PREG_SPLIT_NO_EMPTY);
			$p = '';
			foreach ( $pees as $tinkle )
				$p .= '<p>' . trim($tinkle, "\n") . "</p>\n";
			$p = preg_replace('|<p>\s*</p>|', '', $p); // under certain strange conditions it could create a P of entirely whitespace
			$p = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $p);
			$p = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $p); // don't pee all over a tag
			$p = preg_replace("|<p>(<li.+?)</p>|", "$1", $p); // problem with nested lists
			$p = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $p);
			$p = str_replace('</blockquote></p>', '</p></blockquote>', $p);
			$p = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $p);
			$p = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $p);
			if ($br) {
				$p = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<j13kPreserveNl />", $matches[0]);'), $p);
				$p = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $p); // optionally make line breaks
				$p = str_replace('<j13kPreserveNl />', "\n", $p);
			}
			$p = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $p);
			$p = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $p);
			if (strpos($p, '<pre') !== false)
				$p = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'cleanPre', $p );
			$p = preg_replace( "|\n</p>$|", '</p>', $p );

			for ($i = 0; $i <= $tabs; $i++) {
				$tabString .= "\t";
			}

			return (str_replace("\n","\n".$tabString, $p));
		}
	}