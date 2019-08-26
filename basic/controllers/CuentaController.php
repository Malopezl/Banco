<?php

namespace app\controllers;

use Yii;
use yii\base\Model;
use app\models\Cuenta;
use app\models\CuentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Connection;
/**
 * CuentaController implements the CRUD actions for Cuenta model.
 */
class CuentaController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Cuenta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuentaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cuenta model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cuenta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cuenta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cuenta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        

        return $this->redirect(['index']);
    }
    public function actionDeposito($id){
        $model = $this->findModel($id);
        $hola = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['efectuardeposito', 'id' => $model->id]);
        }
        return $this->render('deposito', [
            'hola' => $hola,
            'model' => $this->findModel($id),
        ]);
    }
    public function actionRetiro($id){
        $model = $this->findModel($id);
        $model->monto = 0;
        $nombre = '';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['efectuarretiro', 'id' => $model->id]);
        }
        return $this->render('retiro', [
            'model' => $this->findModel($id),
            'nombre' => $nombre,
        ]);
    }
    public function actionCajero($id){
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['efectuarcajero', 'id' => $model->id]);
        }
        return $this->render('cajero', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionEfectuarretiro($id){
        
        $model =Cuenta::findOne($id);
        
        $connection = new \yii\db\Connection([
            'dsn' => 'mysql:host=localhost;dbname=banco',
            'username' => 'marcos',
            'password' => 'ms0664',
        ]);
        $connection->open();
        if($model->monto <= $model->Saldo){
            if($model->isolation == 0){
                $transaction = $connection->beginTransaction("SERIALIZABLE");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 1){
                $transaction = $connection->beginTransaction("REPEATABLE READ");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 2){
                $transaction = $connection->beginTransaction("READ COMMITTED");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 3){
                $transaction = $connection->beginTransaction("READ UNCOMMITTED");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
                
            }
        }
        
        
        $connection->close();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionEfectuardeposito($id){
        
        $model =Cuenta::findOne($id);
        
        $connection = new \yii\db\Connection([
            'dsn' => 'mysql:host=localhost;dbname=banco',
            'username' => 'marcos',
            'password' => 'ms0664',
        ]);
        $connection->open();
            if($model->isolation == 0){
                $transaction = $connection->beginTransaction("SERIALIZABLE");
                try{
                $model->Saldo = $model->Saldo + $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 1){
                $transaction = $connection->beginTransaction("REPEATABLE READ");
                try{
                $model->Saldo = $model->Saldo + $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 2){
                $transaction = $connection->beginTransaction("READ COMMITTED");
                try{
                $model->Saldo = $model->Saldo + $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 3){
                $transaction = $connection->beginTransaction("READ UNCOMMITTED");
                try{
                $model->Saldo = $model->Saldo + $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
                
            }
        
        
        
        $connection->close();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    public function actionEfectuarcajero($id){
        
        $model =Cuenta::findOne($id);
        
        $connection = new \yii\db\Connection([
            'dsn' => 'mysql:host=localhost;dbname=banco',
            'username' => 'marcos',
            'password' => 'ms0664',
        ]);
        $connection->open();
        if($model->monto <= $model->Saldo){
            if($model->isolation == 0){
                $transaction = $connection->beginTransaction("SERIALIZABLE");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 1){
                $transaction = $connection->beginTransaction("REPEATABLE READ");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 2){
                $transaction = $connection->beginTransaction("READ COMMITTED");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
            }else if($model->isolation == 3){
                $transaction = $connection->beginTransaction("READ UNCOMMITTED");
                try{
                $model->Saldo = $model->Saldo - $model->monto;
                $model->save();
                $transaction->commit();
                }catch(Exception $e){
                    $transaction->rollBack();
                }
                
            }
        }

        
        
        $connection->close();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    /**
     * Finds the Cuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cuenta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
