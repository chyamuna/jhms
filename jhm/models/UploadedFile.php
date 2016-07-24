<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uploaded_file".
 *
 * @property integer $id
 * @property integer $added_by
 * @property string $candidate_first_name
 * @property string $candidate_last_name
 * @property string $file_name
 * @property string $path
 */
class UploadedFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uploaded_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['added_by', 'candidate_first_name'], 'required'],
            [['added_by'], 'integer'],
            [['candidate_first_name', 'candidate_last_name'], 'string', 'max' => 100],
            [['file_name', 'path'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'added_by' => 'Added By',
            'candidate_first_name' => 'Candidate First Name',
            'candidate_last_name' => 'Candidate Last Name',
            'file_name' => 'File Name',
            'path' => 'Path',
        ];
    }
}
