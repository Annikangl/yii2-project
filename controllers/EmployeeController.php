<?php

namespace app\controllers;

use app\forms\EmployeeCreateForm;
use app\models\Interview;
use app\services\dto\RecruitData;
use app\services\EmployeeService;
use Yii;
use app\models\Employee;
use app\forms\search\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct($id, $module, EmployeeService $staffService, $config = [])
    {
        $this->employeeService = $staffService;
        parent::__construct($id, $module, $config = []);
    }

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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws \yii\web\ServerErrorHttpException
     * @return mixed
     */
    public function actionCreate($interview_id = null)
    {
        $form = new EmployeeCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $employee = $this->employeeService->create(
                new RecruitData($form->firstName, $form->lastName, $form->address, $form->email),
                $form->orderDate,
                $form->contractDate,
                $form->recruitDate
            );

            Yii::$app->session->setFlast('success', 'Employee is recruit');
            return $this->redirect(['view', 'id' => $employee->id]);
        }

         return $this->render('create', [
             'createForm' => $form,
         ]);


//            $transaction = Yii::$app->db->beginTransaction();
//            try {
//                if ($interview) {
//                    $interview->status = Interview::STATUS_PASS;
//                    $interview->save();
//                }
//
//                $model->save(false);
//
//                $order = new Order();
//                $order->date = $model->order_date;
//                $order->save(false);
//
//                $contract = new Contract();
//                $contract->employee_id = $model->id;
//                $contract->first_name = $model->first_name;
//                $contract->last_name = $model->last_name;
//                $contract->date_open = $model->contract_date;
//                $contract->save(false);
//
//                $recruit = new Recruit();
//                $recruit->order_id = $order->id;
//                $recruit->employee_id = $model->id;
//                $recruit->date = $model->recruit_date;
//                $recruit->save(false);
//
//                $transaction->commit();
//                Yii::$app->session->setFlast('success', 'Employee is recruit');
//                return $this->redirect(['view', 'id' => $model->id]);
//            } catch (Exception $e) {
//                $transaction->rollBack();
//                throw new ServerErrorHttpException($e->getMessage());
//            }
//
//            return $this->render('create', [
//                'model' => $model
//            ]);

            // $form = new EmployeeCreateForm();

            // if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            //     $employee = $this->employeeService->create(
            //         new RecruitData($form->firstName, $form->lastName, $form->address, $form->email),
            //         $form->orderDate,
            //         $form->contractDate,
            //         $form->recruitDate
            //     );
            //     Yii::$app->session->setFlash('success', 'Employee is recruit.');
            //     return $this->redirect(['view', 'id' => $employee->id]);
            // }

    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $interview_id
     * @return mixed
     *@throws \yii\web\ServerErrorHttpException
     */
    public function actionCreateByInterview(int $interview_id)
    {
        $interview = $this->findInterviewModel($interview_id);

        $form = new EmployeeCreateForm($interview);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $employee = $this->employeeService->createByInterview(
                $interview->id,
                new RecruitData($form->firstName, $form->lastName, $form->address, $form->email),
                $form->orderDate,
                $form->contractDate,
                $form->recruitDate
            );
            Yii::$app->session->setFlash('success', 'Employee is recruit.');
            return $this->redirect(['view', 'id' => $employee->id]);
        }

        return $this->render('create', [
            'createForm' => $form,
        ]);
    }

    /**
     * Updates an existing Employee model.
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
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findInterviewModel(int $id): Interview
    {
        if (($model = Interview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
