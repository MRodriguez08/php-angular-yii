<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constantes
 *
 * @author ubuntu
 */
class AppConstants {
    
    
    const APP_FILES_DIRECTORY = "appFilesDirectory";
    const APP_ADMINITRATOR_EMAIL = "appAdminEmail";
    
    const RESET_PASSWORD_DEFAULT = "defaultPassword";
    
    const PARAMETER_TYPE_STRING = "string";
    const PARAMETER_TYPE_INTEGER = "integer";
    
    const SESSION_CURRENT_TAB = 'sess_curr_tab';
    
    const DATETIME_STRING_FORMAT = 'Y-m-d H:i:s';
    
    /* OPERACIONES DE AUDITORIA */
    const AUDIT_OPERATION_NEW = "alta";
    const AUDIT_OPERATION_DELETE = "baja";
    const AUDIT_OPERATION_EDIT = "modificacion";
    const AUDIT_OPERATION_CHANGE_PASSWORD = "cambio contrasenia";
    const AUDIT_OPERATION_LOGIN = "login";
    const AUDITORIA_OPERACION_LOGOUT = "logout";
    
    /* OBJETOS DE AUDITORIA */
    const AUDIT_OBJECT_USER = "usuario";
    const AUDIT_OBJECT_SYSPARAM = "parametro";
    const AUDIT_OBJECT_CUSTOMER = "cliente";
    const AUDIT_OBJECT_NOTIFICATION_TYPE = "tipo notificacion";
    const AUDIT_OBJECT_NOTIFICATION_STATE = "estado notificacion";
    
    const MENU_ITEM_CONFIGURATION = "configuracion";
    const MENU_ITEM_USERS = "usuarios";
    const MENU_ITEM_NOTIFICATIONS = "notificaciones";
    const MENU_ITEM_CUSTOMERS = "clientes";
    const MENU_ITEM_HOME = "home";
    const MENU_ITEM_AUDIT = "auditoria";
    const MENU_ITEM_SYSPARAMS = "parametros";
    const MENU_ITEM_NOTIFICATION_TYPES = "tipos_notificacion";
    const MENU_ITEM_NOTIFICATION_STATES = "estados_notificacion";
    
    const USER_ROLE_ADMINISTRATIVE = "administrativo";
    const USER_ROLE_ADMINISTRATOR = "administrador";
    
    const OPERATION_RESULT_SUCCESS = "exito";
    const OPERATION_RESULT_FAILURE = "falla";
    
}


