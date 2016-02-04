<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 03.02.2016
 * Time: 6:35
 */

namespace common\models;

use common\models\users\User;
use common\models\users\UserAccount;
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
	/**
	 * Insert Pay in account user.
	 * @param array $request
	 * @param integer $user_id
	 * @return boolean
	 */
	public static function accountPayIn($request)
	{
		if(!empty($request)){
			$user_id = $request['customerNumber'];
			$model = new UserAccount();
			$model->id_user = $user_id;
			$model->date = date('Y-m-d');
			$model->description = 'Пополнение баланса';
			$model->invoice = $request['orderNumber'];
			$model->pay_in = $request['orderSumAmount'];
			$model->pay_in_with_percent = $request['shopSumAmount'];
			$model->invoiceId = $request['invoiceId'];
			$model->yandexPaymentId = $request['yandexPaymentId'];
			if($model->save() && self::userAccontUpdateSum($request['orderSumAmount'],$user_id)){
				return true;
			}else return false;
		}
	}

	private static function userAccontUpdateSum($sum, $user_id)
	{
		$user = User::findOne(['id'=>$user_id]);
		$user->account = $user->account + $sum;
		if($user->save()){
			return true;
		}else return false;
	}

}