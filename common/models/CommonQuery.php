<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 03.02.2016
 * Time: 6:35
 */

namespace common\models;


use yii\db\ActiveRecord;
use Yii;
use yii\helpers\FileHelper;

class CommonQuery extends ActiveRecord
{
	/**
	 * Delete item from catalog.
	 * @param string $item Item model
	 * @param string $img_path
	 * @return mixed
	 */
	public static function deleteItem($item, $img_path = null)
	{
		if($img_path != null){
			$dir = Yii::getAlias($img_path);
			if(is_dir($dir)){
				$images = FileHelper::findFiles($dir, [
					'only' => [
						$item->main_img,
					],
				]);
				for ($n = 0; $n != count($images); $n++) {
					@unlink($images[$n]);
				}
			}
		}
		//delete row from database
		if ($item->delete()) {
			Yii::$app->session->setFlash('success', 'Объявление успешно удалено.');
		}
	}
}