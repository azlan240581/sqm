<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_associate_broker_details".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $company_name
 * @property string $brand_name
 * @property string $akta_perusahaan
 * @property string $nib
 * @property string $sk_menkeh
 * @property string $npwp
 * @property string $ktp_direktur
 * @property string $bank_account
 * @property string $credits
 * @property integer $createdby
 * @property string $createdat
 * @property integer $updatedby
 * @property string $updatedat
 */
class UserAssociateBrokerDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_associate_broker_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'company_name', 'brand_name', 'akta_perusahaan', 'nib', 'sk_menkeh', 'npwp', 'ktp_direktur', 'bank_account', 'createdby', 'createdat'], 'required', 'on'=>'create'],
            [['user_id', 'createdby', 'updatedby'], 'integer'],
            [['credits'], 'number'],
            [['createdat', 'updatedat'], 'safe'],
            [['company_name', 'brand_name'], 'string', 'max' => 100],
            [['akta_perusahaan', 'nib', 'sk_menkeh', 'npwp', 'ktp_direktur', 'bank_account'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'company_name' => 'Company Name',
            'brand_name' => 'Brand Name',
            'akta_perusahaan' => 'Akta Perusahaan',
            'nib' => 'Nombor Induk Berusaha (NIB)',
            'sk_menkeh' => 'Surat Keputusan Menteri Kehakiman',
            'npwp' => 'Nomor Pokok Wajib Pajak (NPWP)',
            'ktp_direktur' => 'Kartu Tanda Penduduk Direktur',
            'bank_account' => 'Bank Account',
            'credits' => 'Credits',
            'createdby' => 'Createdby',
            'createdat' => 'Createdat',
            'updatedby' => 'Updatedby',
            'updatedat' => 'Updatedat',
        ];
    }
}
