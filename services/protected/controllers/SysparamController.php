<?php

class SysparamController extends AdminController {

    protected $pageTitle = ". : Parametros : .";

    /**
     * @return array action filters
     */
    public function filters() {
        parent::initController();
        Yii::app()->session[AppConstants::SESSION_CURRENT_TAB] = AppConstants::MENU_ITEM_SYSPARAMS;
        return array(
            'accessControl',
            'postOnly + delete',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('admin', 'update'),
                'roles' => array(AppConstants::USER_ROLE_ADMINISTRATOR),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = $this->loadModel($id);

            if ($model->editable == false) {
                $this->render('/site/invalidOperation', array(
                    'header' => 'Operacion no valida',
                    'message' => 'El parametro que desea modifica esta marcado como no editable',
                    'returnUrl' => Yii::app()->createUrl('sysparam/admin')
                ));
                $transaction->rollback();
                return;
            }

            if (isset($_POST['Sysparam'])) {
                $model->attributes = $_POST['Sysparam'];
                if ($model->save()) {
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_SYSPARAM, AppConstants::AUDIT_OPERATION_EDIT, "sysparam = " . $model->name . ", nuevo_valor = " . $model->value);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Par&aacute;metro modificado con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a la gestión de parámetros',
                        'returnUrl' => Yii::app()->createUrl('sysparam/admin')
                    ));
                    $transaction->commit();
                    return;
                } else {
                    $transaction->rollback();
                }
            }
            
            $this->render('update', array(
                'model' => $model,
            ));            
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
            $transaction->rollback();
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Sysparam');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Sysparam('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sysparam']))
            $model->attributes = $_GET['Sysparam'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Sysparam the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Sysparam::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sysparam $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sysparam-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function renderEdit($data, $row) {
        if ($data->editable == 1)
            echo "<a href=" . Yii::app()->createUrl("sysparam/update", array("id" => $data->name)) . "> " . Yii::app()->params["editGridButtonLabel"] . "</a>";
        else
            echo Yii::app()->params["disabledEditGridButtonLabel"];
    }

}
