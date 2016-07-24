<?php

namespace app\controllers;

use Yii;
use app\models\UploadedFile;
use app\models\UploadedFileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\components\pdf2text;

/**
 * UploadedFileController implements the CRUD actions for UploadedFile model.
 */
class UploadedFileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UploadedFile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UploadedFileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UploadedFile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UploadedFile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UploadedFile();
        if(empty($_FILES) || $_FILES['UploadedFile']['name']['file'] =='') {
                $model->addError('file','File SHould be Uploaded');
                return $this->render('create', [
                'model' => $model,
                ]);
                
            }
             $model->added_by = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                $s3 = Yii::$app->get('s3');
                $result = $s3->upload($model->id . '-'.$_FILES['UploadedFile']['name']['file'],$_FILES['UploadedFile']['tmp_name']['file'] );
               
                $model->file_name = $model->id . '-'.$_FILES['UploadedFile']['name']['file'];
                $model->path=$result->get('ObjectURL');
           /*     
 exit;  */


$ext = pathinfo($_FILES['UploadedFile']['name']['file'], PATHINFO_EXTENSION);
if($ext == 'doc'){
$fileHandle = fopen($_FILES['UploadedFile']['tmp_name']['file'], "r");
    $line = @fread($fileHandle, filesize($_FILES['UploadedFile']['tmp_name']['file']));   
    $lines = explode(chr(0x0D),$line);
    $outtext = "";
    foreach($lines as $thisline)
      {
        $pos = strpos($thisline, chr(0x00));
        if (($pos !== FALSE)||(strlen($thisline)==0))
          {
          } else {
            $outtext .= $thisline." ";
          }
      }
     $model->file_content = strtolower(preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext));
   
}
else if($ext == 'docx'){
    $striped_content = '';
        $content = '';

        $zip = zip_open($_FILES['UploadedFile']['tmp_name']['file']);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $model->file_content = strtolower(strip_tags($content));

}
else if($ext == 'pdf'){
    $a = new PDF2Text();
$a->setFilename($_FILES['UploadedFile']['tmp_name']['file']); //grab the test file at http://www.newyorklivearts.org/Videographer_RFP.pdf
$a->decodePDF();
$model->file_content = strtolower($a->output());
}
else {
     $model->addError('file','File  SHould be pdf or doc or docx');
                return $this->render('create', [
                'model' => $model,
                ]);
}





              
                $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

/*
public function docx2text($filename) {
   return $this->readZippedXML($filename, "word/document.xml");
 }

 public function readZippedXML($archiveFile, $dataFile) {
// Create new ZIP archive
$zip = new ZipArchive;

// Open received archive file
if (true === $zip->open($archiveFile)) {
    // If done, search for the data file in the archive
    if (($index = $zip->locateName($dataFile)) !== false) {
        // If found, read it to the string
        $data = $zip->getFromIndex($index);
        // Close archive file
        $zip->close();
        // Load XML from a string
        // Skip errors and warnings
        $xml = new DOMDocument();
    $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
        // Return data without XML formatting tags
        return strip_tags($xml->saveXML());
    }
    $zip->close();
}

// In case of failure return empty string
return "";
} */
    /**
     * Updates an existing UploadedFile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UploadedFile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
         
            header('Location: '.$model->path);  
    }

    public function actionDownload($id){

    }

    /**
     * Finds the UploadedFile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UploadedFile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UploadedFile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
