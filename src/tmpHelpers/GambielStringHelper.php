<?php
	
	namespace GambiEl\Helpers;
	
	use GambiEl\Enums\StringTransformEnum;
	
	class GambielStringHelper {
		private static string $Data;
		private static array $Format;
		
		public static function toPascalCase(string $value): string {
			return ucwords(strtolower(self::name($value)));
		}
		
		public static function name(string $value, $separator = null, int $transform = StringTransformEnum::UPPERCASE): string {
			if (!empty($value)):
				self::$Format = [];
				self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
				self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
				
				self::$Data = strtr(utf8_decode($value), utf8_decode(self::$Format['a']), self::$Format['b']);
				self::$Data = strip_tags(trim(self::$Data));
				if ($separator != null):
					self::$Data = str_replace(' ', "$separator", self::$Data);
				endif;
				
				if ($transform == StringTransformEnum::UPPERCASE):
					$name = strtoupper(utf8_encode(self::$Data));
				elseif ($transform == StringTransformEnum::LOWERCASE):
					$name = strtolower(utf8_encode(self::$Data));
				elseif ($transform == StringTransformEnum::FIRST_LETTER_UPPERCASE):
					$name = ucfirst(strtolower(utf8_encode(self::$Data)));
				elseif ($transform == StringTransformEnum::PASCALCASE):
					$name = ucwords(strtolower(utf8_encode(self::$Data)));
				else:
					$name = utf8_encode(self::$Data);
				endif;
				
				return preg_replace('/( )+/', ' ', $name);
			else:
				return $value;
			endif;
		}
		
		public static function UpperCase(string $value): string {
			if (!empty($value)):
				self::$Format = [];
				self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
				self::$Format['b'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÝýþÿRR';
				
				self::$Data = strtoupper(strtr($value, self::$Format['a'], self::$Format['b']));
				
				return self::$Data;
			else:
				return $value;
			endif;
		}
		
		public static function ElementName(string $value, $delimiter = "-"): string {
			self::$Format = [];
			self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()-+={[}]/?;:,\\\'<>°ºª';
			self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                               ';
			
			self::$Data = strtr(utf8_decode($value), utf8_decode(self::$Format['a']), self::$Format['b']);
			self::$Data = strip_tags(trim(self::$Data));
			
			self::$Data = strtolower(str_replace(' ', $delimiter, self::$Data));
			
			return utf8_encode(self::$Data);
		}
		
		public static function clear(string $value, $remoteAllSpaces = true): string {
			if ($remoteAllSpaces)
				$value = trim($value);
			
			$search = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr';
			$replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
			$value = strtr(utf8_decode($value), utf8_decode($search), $replace);
			
			$value = preg_replace('/\s(?=\s)/', '', $value);
			$value = preg_replace('/[\n\r\t]/', ' ', $value);
			$value = preg_replace("/[^0-9a-zA-Z\(@\.\-\!\#\\$\%\&\*\(\)\_\+\=\{\[\}\]\/\?\;\:\.\|)\.]+/", ' ', $value);
			$value = utf8_decode(rtrim(ltrim($value)));
			
			return $value;
		}
		
		public static function fileName($String): string {
			self::$Format = [];
			self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()-+={[}]/?;:,\\\'<>°ºª';
			self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                               ';
			
			self::$Data = strtr(utf8_decode($String), utf8_decode(self::$Format['a']), self::$Format['b']);
			self::$Data = strip_tags(trim(self::$Data));
			
			self::$Data = str_replace(' ', "_", self::$Data);
			
			return utf8_encode(self::$Data);
		}
		
		public static function unmaskCoin(string $coin): float {
			if ($coin != ''):
				$coin = trim(str_replace("R$", "", $coin));
				$coin = trim(str_replace("%", "", $coin));
				$coin = preg_replace('/\s(?=\s)/', '', $coin);
				$coin = preg_replace('/[\n\r\t]/', ' ', $coin);
				$coin = preg_replace("/[^0-9a-zA-Z\(,\@\-\!\#\\$\%\&\*\(\)\_\+\=\{\[\}\]\/\?\;\:\.\|)\.]+/", '', $coin);
				if ((strpos(substr($coin, -2), ",") !== false) || (strpos(substr($coin, -2), ".") !== false)):
					$coin .= "0";
				endif;
				
				if ((strpos($coin, ",") !== false) || (strpos($coin, ".") !== false)):
					$coin = str_replace(",", "", str_replace(".", "", $coin));
					if (strlen($coin) >= 1):
						$legth_milhar = strlen($coin) - 2;
						$coin_milhar = substr($coin, 0, $legth_milhar);
						$coin_moeda = substr($coin, -2);
						
						$coin = $coin_milhar . "." . $coin_moeda;
					endif;
				else:
					$coin .= ".00";
				endif;
			else:
				$coin = 0;
			endif;
			
			return (float)$coin;
		}
		
		public static function maskCoin(string $coin): string {
			if ($coin == ''):
				$coin = 0;
			endif;
			$coin = number_format((float)$coin, 2, ",", ".");
			
			return $coin;
		}
		
		public static function split(string $string) {
			return preg_split('/\r\n|\r|\n/', $string);
		}
		
		public static function maskTelNumber(string $tel, bool $cincoDigitosAposTraco = true): ?string {
			switch (strlen($tel)) {
				case 13:
					$ddd = substr($tel, 2, 2);
					$numberPart1 = substr($tel, 4, 5);
					$numberPart2 = substr($tel, 9, 4);
					if ($cincoDigitosAposTraco) {
						$numberPart1 = substr($tel, 4, 4);
						$numberPart2 = substr($tel, 8, 5);
					}
					break;
				case 12:
					$ddd = substr($tel, 2, 2);
					$numberPart1 = substr($tel, 4, 4);
					$numberPart2 = substr($tel, 8, 4);
					if ($cincoDigitosAposTraco) {
						$numberPart1 = substr($tel, 4, 5);
						$numberPart2 = substr($tel, 9, 3);
					}
					break;
				case 11:
					$ddd = substr($tel, 0, 2);
					$numberPart1 = substr($tel, 2, 5);
					$numberPart2 = substr($tel, 7, 4);
					if ($cincoDigitosAposTraco) {
						$numberPart1 = substr($tel, 2, 4);
						$numberPart2 = substr($tel, 6, 5);
					}
					break;
				case 10:
					$ddd = substr($tel, 0, 2);
					$numberPart1 = substr($tel, 2, 4);
					$numberPart2 = substr($tel, 6, 4);
					if ($cincoDigitosAposTraco) {
						$numberPart1 = substr($tel, 2, 5);
						$numberPart2 = substr($tel, 7, 3);
					}
					break;
				default:
					$ddd = "";
					$numberPart1 = "";
					$numberPart2 = "";
					break;
			}
			
			return (!empty($ddd) && !empty($numberPart1) && !empty($numberPart2)) ? "($ddd)$numberPart1-$numberPart2" : null;
		}
	}
