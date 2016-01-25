<?php

namespace common\models\service;

use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use creocoder\taggable\TaggableBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\base\Exception;
use yii\base\ErrorException;
use common\models\tags\Tags;
use common\models\tags\TagsService;
/**
 * This is the model class for table "Service_buy".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_user
 * @property string $name
 * @property string $cost
 * @property string $description
 * @property integer $status
 * @property string $vip_date
 * @property string $top_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $m_keyword
 * @property string $m_description
 */
class Service extends ActiveRecord
{
    public $image;
    public $crop_info;
    public $verifyCode;
    public $readonly;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                   // ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cat','name'], 'required'],
            ['id_cat', 'validateReadonly'],
            [['id_cat', 'id_user', 'buy', 'status'], 'integer'],
            [['cost'], 'number'],
            [['description'], 'string', 'max' => 1000],
            [['vip_date', 'top_date', 'created_at', 'updated_at', 'crop_info'], 'safe'],
            [['name', 'main_img'], 'string', 'max' => 50],
            [['m_keyword', 'm_description'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [
                ['image'],
                'image',
                'extensions' => ['jpg', 'jpeg', 'png', 'gif'],
                'mimeTypes' => ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'],
            ],
            [['description','name','main_img'],'filter', 'filter'=>'strip_tags'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'on' => 'create'],
        ];
    }

    public function validateReadonly()
    {
        $cat = ServiceCat::findOne(['id'=>$this->id_cat]);
        if($cat->readonly){
            $readonly = true;
        }else{
            $readonly = false;
        }
        if ($readonly) {
            Yii::$app->session->setFlash('danger', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
            $this->addError('id_cat', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Id Cat',
            'id_user' => 'Id User',
            'id_tag' => 'Теги',
            'buy' => 'Запрос на услугу',
            'name' => 'Товар',
            'cost' => 'Цена',
            'description' => 'Описание',
            'status' => 'Статус',
            'vip_date' => 'Дата VIP ',
            'top_date' => 'Дата поднятия',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'verifyCode' => 'Введите проверочный код, докажите что Вы не робот.',
        ];
    }

    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }

    public function getCat()
    {
        return $this->hasOne(ServiceCat::className(), ['id' => 'id_cat']);
    }

    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_service',['id_service'=>'id']);
    }
    public function getTagsService()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_service',['id_service'=>'id']);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if ($this->image->tempName != '') {

            // open image
            $image = Image::getImagine()->open($this->image->tempName);

            $variants = [
                [
                    'width' => 250,
                    'height' => 250,
                ],
            ];

            // rendering information about crop of ONE option
            $cropInfo = Json::decode($this->crop_info)[0];
            $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
            $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
            $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
            $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y

            //delete old images
            $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/service/'), [
                'only' => [
                    $this->id . '.*',
                    'thumb_' . $this->id . '.*',
                ],
            ]);
            for ($i = 0; $i != count($oldImages); $i++) {
                @unlink($oldImages[$i]);
            }
            //avatar image name
            $imgName = $this->id . '.' . $this->image->getExtension();

            //saving thumbnail
            $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
            $cropSizeThumb = new Box(250, 250); //frame size of crop
            $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
            $pathThumbImage = Yii::getAlias('@frt_dir/img/service/') . $imgName;

            $image->resize($newSizeThumb)
                ->crop($cropPointThumb, $cropSizeThumb)
                ->save($pathThumbImage, ['quality' => 100]);

            //save in database
            $model = Service::findOne($this->id);
            $model->main_img = $imgName;

            if($model->save()){
                Yii::$app->session->setFlash('success', 'Новая картинка успешно установлена.');
            }else{
                Yii::$app->session->setFlash('danger', 'Картинка не изменена.');
            }
        }
    }
}
