<?php
	
	namespace GambiEl\Helpers;
	
	class GambielArrayHelper {
		public static function arrayIndexExist(?array $arr, string $indexName): bool {
			return !empty($arr) ? array_key_exists($indexName, $arr) : true;
		}
		
		public static function multidimensionalSearch($parents, $searched) {
			if (empty($searched) || empty($parents)) {
				return false;
			}
			
			foreach ($parents as $key => $value) {
				$exists = true;
				foreach ($searched as $skey => $svalue) {
					$exists = ($exists && isset($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
				}
				if ($exists) {
					return $key;
				}
			}
			
			return false;
		}
		
		public static function clear(array $arr): array {
			if (!empty($arr)):
				foreach ($arr as $key_value => $arr_value):
					if (is_array($arr_value)):
						$qtd_indices_empty = 0;
						foreach ($arr_value as $value):
							if ($value != '') {
								$qtd_indices_empty++;
							}
						endforeach;
						if ($qtd_indices_empty == 0):
							unset($arr[$key_value]);
						endif;
					else:
						$arr = array_filter($arr);
					endif;
				endforeach;
			endif;
			
			return $arr;
		}
		
		public static function removeNumericKey(array $arr): array {
			if (!empty($arr)):
				foreach ($arr as $key => $value):
					if (is_int($key)):
						unset($arr[$key]);
					endif;
				endforeach;
			endif;
			
			return $arr;
		}
		
		public static function arrayPutToPosition(&$array, $object, $position, $name = null): array {
			$count = 0;
			$return = [];
			$inserted = false;
			foreach ($array as $k => $v) {
				// insert new object
				if ($count == $position) {
					if (!$name) $name = $count;
					$return[$name] = $object;
					$inserted = true;
				}
				// insert old object
				$return[$k] = $v;
				$count++;
			}
			if (!$name) $name = $count;
			if (!$inserted) $return[$name];
			$array = $return;
			
			return $array;
		}
		
		public static function arrayAreEquals(array $a, array $b) {
			return (
				is_array($a)
				&& is_array($b)
				&& count($a) == count($b)
				&& strcasecmp(json_encode($a), json_encode($b)) === 0
			);
		}
		
	}
