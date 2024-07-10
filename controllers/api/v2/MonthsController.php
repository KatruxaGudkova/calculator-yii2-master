<?php

namespace app\controllers\api\v2;


use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;
use app\models\Month;
use yii\filters\VerbFilter;
use app\components\filters\TokenAuthMiddleware;
use app\repositories\MonthRepository;


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
                    'index' => ['GET', 'POST', 'DELETE', 'OPTIONS'],
                ],

            ],
            'corsFilter'=> [
                'class' => \yii\filters\Cors::class
            ]
        ];
    }

    public function actionIndex(string $id = null): mixed
    {
        return match (\Yii::$app->getRequest()->getMethod()) {
            'GET' => $this->list(),
            'POST' => $this->create(),
            'DELETE' => $this->delete($id),
            'OPTIONS' => function() {
                \Yii::$app->getResponse()->setStatusCode(204);
            },
            default => throw new MethodNotAllowedHttpException(),
        };
    }


    private function list(): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

       return (new MonthRepository())->getMonthNames();
    }

    private function create()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = \Yii::$app->request;
        $monthName = $request->post('month');
        
        if (!$monthName) {
            throw new BadRequestHttpException('Укажите месяц');
        }

        $month = new Month();
        $month->name = $monthName;

        if ($month->validate()) {
            (new MonthRepository())->create($monthName);
            \Yii::$app->response->statusCode = 201;
            return ['message' => 'Месяц успешно добавлен'];
        } else {
            \Yii::$app->response->statusCode = 400;
            return ['message' => 'Месяц уже существует', 'errors' => $month->errors];
        }
    }

    private function delete($id)
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