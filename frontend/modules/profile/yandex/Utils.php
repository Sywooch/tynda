<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 30.01.2016
 * Time: 22:31
 */

namespace app\modules\profile\yandex;


class Utils {

	public static function formatDate(\DateTime $date) {
		$performedDatetime = $date->format("Y-m-d") . "T" . $date->format("H:i:s") . ".000" . $date->format("P");
		return $performedDatetime;
	}

	public static function formatDateForMWS(\DateTime $date) {
		$performedDatetime = $date->format("Y-m-d") . "T" . $date->format("H:i:s") . ".000Z";
		return $performedDatetime;
	}
}