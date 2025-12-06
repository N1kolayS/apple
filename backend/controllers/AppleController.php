<?php

namespace backend\controllers;

use common\models\Apple;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'generate', 'fall', 'eat', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'generate' => ['POST'],
                        'fall' => ['POST'],
                        'eat' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Apple models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Apple::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return void
     * @throws HttpException
     */
    public function actionGenerate(): void
    {
        $count = Yii::$app->request->post('count');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        try {
            Apple::generateRandom($count);
        }
        catch (\Exception $exception)
        {
            throw new HttpException(400, $exception);
        }


    }

    /**
     * @param $id
     * @return void
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionFall($id): void
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        try {
            $model->failToGround();
        }
        catch (\Exception $exception)
        {
            throw new HttpException(400, $exception);
        }
    }

    /**
     * @param $id
     * @return void
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionEat($id): void
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $size = Yii::$app->request->post('size');
        $model = $this->findModel($id);
        try {
            $model->eat($size);
        }
        catch (\Exception $exception)
        {
            throw new HttpException(400, $exception);
        }
    }


    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Apple
    {
        if (($model = Apple::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
