<?php

/**
 * User controller
 * 
 * Contiene todas las acciones referentes a la gestion de usuarios registrados en el sitio.
 * 
 * @package controllers
 */
class UserController extends AdminController {

    protected $pageTitle = ". : Usuarios : .";
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    public function filters() {
        parent::initController();
        Yii::app()->session[AppConstants::SESSION_CURRENT_TAB] = AppConstants::MENU_ITEM_USERS;
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
                'actions' => array('login'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('logout', 'myProfile', 'editMyProfile', 'changePassword'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'view', 'admin', 'updateState', 'resetPassword'),
                'roles' => array(AppConstants::USER_ROLE_ADMINISTRATOR),
            ),
            array('deny',
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

    public function actionMyProfile() {
        $this->render('myProfile', array(
            'model' => $this->loadModel(Yii::app()->user->id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = new User;

            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                $model->password = crypt(Sysparam::model()->findByPk(AppConstants::RESET_PASSWORD_DEFAULT)->value);
                if ($model->save()) {
                    $authAssign = new AuthAssignment();
                    $authAssign->itemname = $model->role;
                    $authAssign->userid = $model->nick;
                    $authAssign->save();
                    $fsu = new FileSystemUtil;
                    $fsu->createUserTmpFoderIfNotExists($model->nick);
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_NEW, $model->nick);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Usuario creado con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a la gestión de usuarios',
                        'returnUrl' => Yii::app()->createUrl('user/admin'),
                        'viewUrl' => Yii::app()->createUrl("user/view", array("id" => $model->nick))
                    ));
                    $transaction->commit();
                    return;
                } else {
                    $transaction->rollback();
                }
            }
            $this->render('create', array(
                'model' => $model,
            ));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
            $transaction->rollback();
        }
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

            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];
                if ($model->save()) {

                    $authAsign = AuthAssignment::model()->findByAttributes(array('userid' => $model->nick));
                    $authAsign->itemname = $model->role;
                    if ($authAsign->save()) {
                        $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_EDIT, $model->nick);
                        $this->render('/site/successfullOperation', array(
                            'header' => 'Usuario modificado con &eacute;xito',
                            'message' => 'Haga click en volver para regresar a la gestión de usuarios',
                            'returnUrl' => Yii::app()->createUrl('user/admin'),
                            'viewUrl' => Yii::app()->createUrl("user/view", array("id" => $model->nick))
                        ));
                        $transaction->commit();
                        return;
                    } else {
                        $transaction->rollback();
                    }
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

    public function actionEditMyProfile() {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = $this->loadModel(Yii::app()->user->id);

            if (isset($_POST['User'])) {
                $model->attributes = $_POST['User'];

                if (empty($_FILES['User_photo_file']['name']) == false) {
                    $model->newPhotoData = $_FILES['User_photo_file'];
                }

                if ($model->validate() && $model->save()) {
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_EDIT, $model->nick);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Perfil editado con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a Mi Perfil',
                        'returnUrl' => Yii::app()->createUrl('user/myProfile')
                    ));
                    $transaction->commit();
                    return;
                } else {
                    $transaction->rollback();
                }
            }

            $this->render('editMyProfile', array(
                'model' => $model,
            ));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
            $transaction->rollback();
        }
    }

    public function actionChangePassword() {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = new ChangePassword();
            if (isset($_POST['ChangePassword'])) {
                $model->attributes = $_POST['ChangePassword'];
                if ($model->save()) {
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_CHANGE_PASSWORD, Yii::app()->user->id);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Contrase&ntilde;a modificada con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a Mi Perfil',
                        'returnUrl' => Yii::app()->createUrl('user/myProfile')
                    ));
                    $transaction->commit();
                    return;
                } else {
                    $transaction->rollback();
                }
            }

            $this->render('changePassword', array(
                'model' => $model,
            ));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
            $transaction->rollback();
        }
    }

    public function actionUpdateState($id) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = $this->loadModel($id);

            $hU = new HttpUtils();
            if (strcmp($hU->getHttpRequestMethod(), HttpUtils::METHOD_POST) == 0) {
                if ($model->enabled == 1)
                    $model->enabled = 0;
                else
                    $model->enabled = 1;
                if ($model->save()) {
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_EDIT, $model->nick);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Usuario modificado con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a la gestión de usuarios',
                        'returnUrl' => Yii::app()->createUrl('user/admin'),
                        'viewUrl' => Yii::app()->createUrl("user/view", array("id" => $model->nick))
                    ));
                    $transaction->commit();
                    return;
                }
            }

            if ($model->enabled == 1) {
                $header = 'Bloquear usuario';
                $message = "¿Esta seguro que desea bloquear el usuario {$model->nick}?";
            } else {
                $header = 'Desbloquear usuario';
                $message = "¿Esta seguro que desea desbloquear el usuario {$model->nick}?";
            }
            $transaction->commit();
            $this->render('changeState', array(
                'header' => $header,
                'message' => $message
            ));
        } catch (Exception $exc) {
            Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
            $transaction->rollback();
        }
    }

    public function actionResetPassword($id) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = $this->loadModel($id);

            if (isset($_POST['User'])) {
                $model->resetPassword();
                if ($model->save()) {
                    $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_EDIT, $model->nick);
                    $this->render('/site/successfullOperation', array(
                        'header' => 'Contrase&ntilde;a reinicializada con &eacute;xito',
                        'message' => 'Haga click en volver para regresar a la gestión de usuarios',
                        'returnUrl' => Yii::app()->createUrl('user/admin'),
                        'viewUrl' => Yii::app()->createUrl("user/view", array("id" => $model->nick))
                    ));
                    $transaction->commit();
                    return;
                } else {
                    $transaction->rollback();
                }
            }

            $this->render('resetPassword', array(
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
    /*
      public function actionDelete($id) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
      $this->loadModel($id)->delete();
      if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } catch (Exception $exc) {
      Yii::log($exc->getMessage(), DBLog::LOG_LEVEL_ERROR);
      $transaction->rollback();
      }
      }
     * 
     */

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::app()->params["httpErrorCode404Message"]);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDIT_OPERATION_LOGIN, '');
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->layout = '//layouts/oneColumn';
        $this->pageTitle = ". : Login : .";
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        $this->audit->logAudit(Yii::app()->user->id, new DateTime, AppConstants::AUDIT_OBJECT_USER, AppConstants::AUDITORIA_OPERACION_LOGOUT, '');
        Yii::app()->user->logout();
        $this->redirect(array('login'));
    }

    public function getListaRoles() {
        return CHtml::listData(AuthItem::model()->findAll(), 'name', 'name');
    }

    protected function renderChangeState($data, $row) {
        if ($data->enabled == 1)
            echo "<a href=" . Yii::app()->createUrl("user/updateState", array("id" => $data->nick)) . "> " . Yii::app()->params["lockUserGridButton"] . "</a>";
        else
            echo "<a href=" . Yii::app()->createUrl("user/updateState", array("id" => $data->nick)) . "> " . Yii::app()->params["unlockUserGridButton"] . "</a>";
    }

}
