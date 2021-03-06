/*
 * File: app/view/sprav/WinImport.js
 * Date: Thu May 21 2020 19:21:31 GMT+0300 (EEST)
 *
 * This file was generated by Sencha Architect version 3.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.1.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.1.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('Osmd.view.sprav.WinImport', {
    extend: 'Ext.window.Window',
    alias: 'widget.winimport',

    requires: [
        'Osmd.view.sprav.WinImportViewModel',
        'Ext.form.Panel',
        'Ext.form.FieldSet',
        'Ext.button.Button',
        'Ext.form.field.Hidden',
        'Ext.form.field.File'
    ],

    viewModel: {
        type: 'winimport'
    },
    height: 267,
    id: 'winImport',
    width: 414,
    layout: 'fit',
    title: 'Импорт файлов',
    modal: true,

    items: [
        {
            xtype: 'form',
            fileUpload: 'true',
            id: 'fmImport',
            width: 455,
            layout: 'fit',
            bodyPadding: 10,
            title: '',
            items: [
                {
                    xtype: 'fieldset',
                    style: 'background-color: #DCDCDC;',
                    layout: 'absolute',
                    title: '',
                    items: [
                        {
                            xtype: 'button',
                            handler: function(button, e) {
                                var stUser = Ext.data.StoreManager.get("StUser");
                                var values =stUser.getAt(0);
                                var form = button.findParentByType('form');
                                var vibor = form.getForm().findField('vibor').getValue();
                                var osmd_id = form.getForm().findField('osmd_id').getValue();

                                //var url = 'resources/php/classes/QueryImport.php';
                                //console.log(vibor);

                                switch (vibor) {

                                    case "utszn":
                                    url  = 'resources/php/classes/QueryImportUtszn.php';
                                    break;
                                    case "privatbank":
                                    var StPrivatBank = Ext.data.StoreManager.get("StPrivatBank");
                                    var grPrivatBank = Ext.getCmp('grPrivatBank');
                                    url  = 'resources/php/classes/QueryImportPrivatBank.php?osmd_id='+osmd_id;
                                    break;
                                    case "lgota":

                                    url  = 'resources/php/classes/QueryImportLgota.php';
                                    break;
                                    case "subsidia":
                                    url  = 'resources/php/classes/QueryImportSubsidia.php';
                                    break;
                                    case "subsidiaOshadBank":
                                    case "lgotaOshadBank":

                                    url  = 'resources/php/classes/QueryImportOshadBank.php';
                                    break;

                                    default:

                                    url  = 'resources/php/classes/QueryImportUtszn.php';
                                }

                                //console.log(url);

                                if(form.isValid()){
                                    form.submit({
                                        url: url,
                                        buttons: Ext.Msg.CANCEL,
                                        waitMsg: 'Загрузка файла...',
                                        success: function(fp, o) {
                                            Ext.MessageBox.show({
                                                title: 'Загрузка файла',
                                                msg: "Файл загружен",
                                                buttons: Ext.MessageBox.OK,
                                                icon: Ext.MessageBox.Info
                                            });
                                            switch (vibor) {

                                                case "privatbank":
                                                StPrivatBank.load({
                                                    params: {
                                                        what:'getPrivatBank',
                                                        login:values.get('login'),
                                                        password:values.get('password'),
                                                        osmd_id:osmd_id
                                                    }
                                                });
                                                grPrivatBank.getView().refresh();
                                                break;

                                            }
                                            button.up('#winImport').close();

                                        },
                                        failure: function (form, action) {
                                            // console.log(Ext.form.action.Action.CONNECT_FAILURE);
                                            switch (action.failureType) {
                                                case Ext.form.action.Action.CLIENT_INVALID:
                                                Ext.Msg.alert('Failure', 'Form fields may not be submitted with invalid values');
                                                break;
                                                case Ext.form.action.Action.CONNECT_FAILURE:
                                                Ext.Msg.alert('Failure', 'Ajax communication failed');
                                                break;
                                                case Ext.form.action.Action.SERVER_INVALID:
                                                Ext.Msg.alert('Failure', "server");
                                            }
                                        }
                                    });

                                }
                            },
                            x: 255,
                            y: 115,
                            formBind: true,
                            height: 30,
                            id: 'btImport',
                            width: 100,
                            icon: 'resources/css/images/ico/add.png',
                            text: 'Загрузить'
                        },
                        {
                            xtype: 'hiddenfield',
                            x: 10,
                            y: 70,
                            fieldLabel: 'Label',
                            name: 'vibor'
                        },
                        {
                            xtype: 'hiddenfield',
                            x: 10,
                            y: 70,
                            fieldLabel: 'Label',
                            name: 'osmd_id'
                        },
                        {
                            xtype: 'button',
                            handler: function(button, event) {
                                button.up('#winImport').close();
                            },
                            x: 20,
                            y: 120,
                            height: 30,
                            width: 80,
                            icon: 'resources/css/images/ico/delete.png',
                            text: 'Отмена'
                        },
                        {
                            xtype: 'filefield',
                            x: 20,
                            y: 30,
                            id: 'fileUpload',
                            width: 330,
                            fieldLabel: 'Файла',
                            labelWidth: 50,
                            name: 'filedata',
                            allowBlank: false,
                            buttonText: 'Просмотр'
                        }
                    ]
                }
            ]
        }
    ]

});