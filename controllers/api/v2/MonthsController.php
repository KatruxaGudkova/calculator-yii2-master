<?php

namespace app\controllers\api\v2;


use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use app\models\Month;
use yii\filters\VerbFilter;
use app\components\filters\TokenAuthMiddleware;

class MonthsController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        return [
            'class' => TokenAuthMiddleware::class,
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'create' => ['POST'],
                    'delete' => ['POST', 'DELETE'],
                ],
            ],
            'corsFilter'=> [
                'class' => \yii\filters\Cors::class
            ]
        ];
    }

    public function actionIndex(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $months = Month::find()->all();
        return ArrayHelper::getColumn($months, 'name');
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = \Yii::$app->request;
        $monthName = $request->post('months');

        if (!$monthName) {
            throw new BadRequestHttpException('Укажите месяц');
        }

        $month = new Month();
        $month->name = $monthName;

        if ($month->save()) {
            \Yii::$app->response->statusCode = 201;
            return ['message' => 'Месяц успешно добавлен'];
        } else {
            \Yii::$app->response->statusCode = 400;
            return ['message' => 'Месяц уже существует', 'errors' => $month->errors];
        }
    }

    public function actionDelete($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $type = Month::findOne(['id' => $id]);

        if (!$type) {
            throw new NotFoundHttpException('Месяц не найден');
        }

        if ($type->delete()) {
            \Yii::$app->response->statusCode = 204;
            return ['message' => 'Удаление прошло успешно!'];
        } else {
            \Yii::$app->response->statusCode = 500;
            return ['message' => 'Невозможно дуалить данный тип'];
        }
    }
}