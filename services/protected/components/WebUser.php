<?php

// this file must be stored in:
// protected/components/WebUser.php

class WebUser extends CWebUser {

    private $_model;
    private $userRoles;

    public function getName() {
        $user = $this->loadUser(Yii::app()->user->id);
        return (isset($user) ? $user->name : "");
    }

    public function getNameAndRole() {
        $user = $this->loadUser(Yii::app()->user->id);
        return $user->name . ' (' . $this->userRoles[0]->itemname . ')';
    }

    public function hasRole($rolId) {

        if ($this->_model == null)
            $this->loadUser(Yii::app()->user->id);

        if ($this->_model != null) {
            foreach ($this->userRoles as $role) {
                if (strcmp($role->itemname, $rolId) == 0)
                    return true;
            }
        }
        return false;
    }

    protected function loadUser($id = null)
    {
        if ($this->_model === null) {
            if ($id !== null) {
                $this->_model = User::model()->findByPk($id);
                $this->userRoles = AuthAssignment::model()->findAll(
                    "userid=:usrId",
                    array(':usrId' => $this->_model->nick)
                );
            }
        }
        return $this->_model;
    }
}
