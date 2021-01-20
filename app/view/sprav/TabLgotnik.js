/*
 * File: app/view/sprav/TabLgotnik.js
 * Date: Wed Jul 25 2018 22:19:55 GMT+0300 (EEST)
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

Ext.define('Osmd.view.sprav.TabLgotnik', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.tablgotnik',

    requires: [
        'Osmd.view.sprav.TabLgotnikViewModel',
        'Ext.grid.Panel',
        'Ext.view.Table',
        'Ext.toolbar.Toolbar',
        'Ext.toolbar.Spacer',
        'Ext.button.Button',
        'Ext.toolbar.Separator',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Hidden',
        'Ext.grid.column.RowNumberer',
        'Ext.grid.column.Action',
        'Ext.grid.column.Number',
        'Ext.grid.column.Date',
        'Ext.grid.feature.Summary',
        'Ext.grid.feature.GroupingSummary'
    ],

    viewModel: {
        type: 'tablgotnik'
    },
    height: 761,
    id: 'tabLgotnik',
    scrollable: true,
    layout: 'fit',
    closable: true,
    title: 'Льготники',
    defaultListenerScope: true,

    items: [
        {
            xtype: 'gridpanel',
            id: 'grLgotnik',
            scrollable: true,
            title: '',
            store: 'StLgotnikTab',
            viewConfig: {
                getRowClass: function(record, rowIndex, rowParams, store) {
                    if(record.get('pr') === 1 ){
                        return 'change_color_yellow';
                    } else if(record.get('pr') === 2 ){
                        return 'change_color_red';
                    } else {
                        return 'change_color_green';
                    }
                },
                emptyText: 'Нет записей по льготе'
            },
            dockedItems: [
                {
                    xtype: 'toolbar',
                    dock: 'top',
                    items: [
                        {
                            xtype: 'tbspacer'
                        },
                        {
                            xtype: 'button',
                            handler: function(button, event) {
                                //in use
                                var winImport = Ext.ClassManager.instantiateByAlias('widget.winimport');
                                var form = Ext.getCmp('fmImport');
                                var vibor =  'utszn';
                                winImport.setTitle('Загрузка льготников из УТиСЗН)');

                                winImport.show();

                                form.getForm().findField('vibor').setValue(vibor);


                            },
                            id: 'btnImportLgotnik',
                            width: 145,
                            icon: 'resources/css/images/ico/door_in.png',
                            text: 'Импорт из УТиСЗН'
                        },
                        {
                            xtype: 'button',
                            handler: function(button, event) {
                                //COMBO
                                var grid = button.findParentByType('grid');
                                var store = grid.store;
                                var cbTabLgotnikHouse = Ext.getCmp('cbTabLgotnikHouse');

                                //STORE
                                var stUser = Ext.data.StoreManager.get("StUser");
                                var values =stUser.getAt(0);

                                //LOGIKA
                                var params = {
                                    login:values.get('login'),
                                    password:values.get('password'),
                                    what:'insert_lgota_from_utszn'
                                };


                                //LOGIKA
                                var myMask= Ext.Msg.show({
                                    title:'Обновление записи...',
                                    msg: 'Обновление записей в базе льгот.Ожидайте...',
                                    buttons: Ext.Msg.CANCEL,
                                    wait: true,
                                    modal: true,
                                    icon: Ext.Msg.INFO
                                });

                                QueryAddress.updateRecords(params,function(results){
                                    if(results.success==="1"){
                                        cbTabLgotnikHouse.clearValue();
                                        store.load({
                                            params: {
                                                what:'insert_lgota_from_utszn',
                                                login:values.get('login'),
                                                password:values.get('password')
                                            }
                                        });
                                        myMask.close();
                                        Ext.MessageBox.show({
                                            title: 'Обновление базы ',
                                            msg: results.msg,
                                            buttons: Ext.MessageBox.OK,
                                            icon: Ext.MessageBox.INFO
                                        });
                                    } else {
                                        myMask.close();
                                        Ext.MessageBox.show({
                                            title: 'Обновление базы ',
                                            msg: results.msg,
                                            buttons: Ext.MessageBox.OK,
                                            icon: Ext.MessageBox.ERROR
                                        });

                                    }

                                });
                            },
                            id: 'btninserttLgotnik',
                            width: 190,
                            icon: 'resources/css/images/ico/door_in.png',
                            text: 'подгрузить в базу льгот'
                        },
                        {
                            xtype: 'tbseparator',
                            width: 20
                        },
                        {
                            xtype: 'tbseparator',
                            width: 20
                        },
                        {
                            xtype: 'combobox',
                            hideMode: 'visibility',
                            id: 'cbTabLgotnikHouse',
                            width: 136,
                            fieldLabel: '',
                            name: 'house_id',
                            emptyText: 'Дом',
                            displayField: 'house',
                            queryMode: 'local',
                            store: 'StHousesOrg',
                            valueField: 'house_id',
                            listeners: {
                                select: 'onCbTabLgotnikHouseSelect'
                            }
                        },
                        {
                            xtype: 'button',
                            id: 'btnPrintLgotnikHouse',
                            icon: 'resources/css/images/ico/printer.png',
                            text: ''
                        },
                        {
                            xtype: 'tbspacer',
                            width: 20
                        },
                        {
                            xtype: 'tbspacer',
                            width: 20
                        },
                        {
                            xtype: 'button',
                            handler: function(button, event) {
                                var stUser = Ext.data.StoreManager.get("StUser");
                                var values =stUser.getAt(0);
                                values.set({'report':'tabLgotnik'});

                                var login = Ext.data.StoreManager.get("StUser").getAt(0).get('login');
                                var password = Ext.data.StoreManager.get("StUser").getAt(0).get('password');

                                var StLgotnik= Ext.data.StoreManager.get("StLgotnikTab");
                                StLgotnik.proxy.setExtraParam('what', 'tabLgotnik');
                                StLgotnik.proxy.setExtraParam('login', login);
                                StLgotnik.proxy.setExtraParam('password', password);
                                StLgotnik.load();
                            },
                            id: 'btnLgotaAll',
                            icon: 'resources/css/images/ico/add.png',
                            text: 'Все льготники'
                        },
                        {
                            xtype: 'button',
                            id: 'btnPrintLgotnikAll',
                            icon: 'resources/css/images/ico/printer.png',
                            text: ''
                        },
                        {
                            xtype: 'hiddenfield',
                            fieldLabel: 'Label',
                            name: 'what'
                        }
                    ]
                },
                {
                    xtype: 'toolbar',
                    dock: 'top',
                    items: [
                        {
                            xtype: 'tbspacer'
                        },
                        {
                            xtype: 'tbspacer',
                            width: 20
                        },
                        {
                            xtype: 'tbspacer',
                            width: 20
                        }
                    ]
                }
            ],
            columns: [
                {
                    xtype: 'rownumberer',
                    width: 34,
                    text: 'п.н'
                },
                {
                    xtype: 'actioncolumn',
                    editRenderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        var val="";
                        return val;
                    },
                    width: 30,
                    menuDisabled: true,
                    items: [
                        {
                            handler: function(view, rowIndex, colIndex, item, e, record, row) {
                                var dt = new Date();
                                var winLgotnik = Ext.ClassManager.instantiateByAlias('widget.winlgotnik');
                                var form = winLgotnik.down('#fmLgotnik');
                                var stUser = Ext.data.StoreManager.get("StUser");
                                var StLgota = Ext.data.StoreManager.get("StLgota");

                                var values =stUser.getAt(0);
                                StLgota.proxy.setExtraParam('login', values.get('login'));
                                StLgota.proxy.setExtraParam('password',values.get('password'));
                                StLgota.load();

                                var value = record;
                                //console.log(rowIndex);
                                //console.log(record);

                                view.getSelectionModel().select(record);
                                values.set({'vibor':'editTabLgotnik'});
                                stUser.sync();
                                form.loadRecord(value);
                                form.down('#winBtnAddLgotnik').setText('Обновить данные по льготнику');
                                winLgotnik.setTitle('Редактирование данных по льготнику');
                                winLgotnik.show();
                            },
                            icon: 'resources/css/images/ico/edit.png'
                        }
                    ]
                },
                {
                    xtype: 'numbercolumn',
                    width: 40,
                    dataIndex: 'pr',
                    menuDisabled: true,
                    text: 'пр',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'address_id',
                    text: 'АдресИд',
                    format: '0'
                },
                {
                    xtype: 'gridcolumn',
                    width: 149,
                    dataIndex: 'address',
                    menuDisabled: true,
                    text: 'Адрес'
                },
                {
                    xtype: 'gridcolumn',
                    items: {
                        xtype: 'textfield',
                        flex: 1,
                        margin: 2,
                        enableKeyEvents: true,
                        listeners: {
                            keyup: function() {
                                            var store = this.up('tablepanel').store;
                                            store.clearFilter();
                                            if (this.value) {
                                                store.filter({
                                                    property     : 'fio',
                                                    value         : this.value,
                                                    anyMatch      : true,
                                                    caseSensitive : false
                                                });
                                            }
                                        },
                            buffer: 1000
                        }
                    },
                    width: 250,
                    dataIndex: 'fio',
                    menuDisabled: true,
                    text: 'Ф.И.О.',
                    editor: {
                        xtype: 'textfield'
                    }
                },
                {
                    xtype: 'gridcolumn',
                    menuDisabled: true,
                    text: 'Период действия',
                    columns: [
                        {
                            xtype: 'datecolumn',
                            width: 80,
                            dataIndex: 'start',
                            menuDisabled: true,
                            text: 'начало',
                            format: 'd-m-y'
                        },
                        {
                            xtype: 'datecolumn',
                            width: 80,
                            dataIndex: 'finish',
                            menuDisabled: true,
                            text: 'оконч',
                            format: 'd-m-y'
                        }
                    ]
                },
                {
                    xtype: 'gridcolumn',
                    items: {
                        xtype: 'textfield',
                        flex: 1,
                        margin: 2,
                        enableKeyEvents: true,
                        listeners: {
                            keyup: function() {
                        var store = this.up('tablepanel').store;
                        store.clearFilter();
                        if (this.value) {
                        store.filter({
                        property     : 'inn',
                        value         : this.value,
                        anyMatch      : true,
                        caseSensitive : false
                        });
                        }
                        },
                            buffer: 1000
                        }
                    },
                    width: 96,
                    dataIndex: 'inn',
                    menuDisabled: true,
                    text: 'инн',
                    editor: {
                        xtype: 'textfield'
                    }
                },
                {
                    xtype: 'numbercolumn',
                    summaryType: 'sum',
                    width: 61,
                    dataIndex: 'people',
                    menuDisabled: true,
                    text: 'Чел',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'kartochka',
                    text: 'Карт'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'passport',
                    text: 'Паспорт'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'surname',
                    text: 'Фамилия'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'firstname',
                    text: 'Имя'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'lastname',
                    text: 'Отчество'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'surname_ua',
                    text: 'Фамилия укр'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'firstname_ua',
                    text: 'Имя укр'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'lastname_ua',
                    text: 'Отчество укр'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'lgota',
                    text: 'Льгота'
                },
                {
                    xtype: 'numbercolumn',
                    width: 38,
                    dataIndex: 'gr',
                    menuDisabled: true,
                    text: 'Гр',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    width: 53,
                    dataIndex: 'category',
                    menuDisabled: true,
                    text: 'Кат',
                    format: '0'
                },
                {
                    xtype: 'numbercolumn',
                    width: 47,
                    dataIndex: 'percent',
                    menuDisabled: true,
                    text: '%',
                    format: '0'
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                        switch (value) {
                            case "да":
                            metaData='<span><img clas="icon" src="resources/css/images/ico/yes.png"/></span>';
                            break;
                            case "нет":
                            metaData='<span><img clas="icon" src="resources/css/images/ico/no.png"/></span>';
                            break;
                        }
                        return metaData;

                    },
                    width: 40,
                    dataIndex: 'vkl',
                    menuDisabled: true,
                    text: 'Вкл'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'raion',
                    text: 'Raion'
                },
                {
                    xtype: 'datecolumn',
                    width: 89,
                    dataIndex: 'data',
                    menuDisabled: true,
                    text: 'Дата изм',
                    format: 'd-m-Y'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    width: 165,
                    dataIndex: 'document',
                    text: 'Документ'
                },
                {
                    xtype: 'datecolumn',
                    hidden: true,
                    width: 89,
                    dataIndex: 'data',
                    text: 'Дата',
                    format: 'd-m-Y'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    width: 200,
                    dataIndex: 'given',
                    text: 'Выдан'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'operator',
                    text: 'Оператор'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'lgota_id',
                    text: 'ЛьготаИд'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    dataIndex: 'lgota_ua',
                    text: 'Льгота укр'
                },
                {
                    xtype: 'numbercolumn',
                    hidden: true,
                    dataIndex: 'lgotnik_id',
                    text: 'ЛьготникИд'
                },
                {
                    xtype: 'gridcolumn',
                    hidden: true,
                    width: 600,
                    dataIndex: 'law_article',
                    text: 'Статья'
                }
            ],
            features: [
                {
                    ftype: 'summary'
                },
                {
                    ftype: 'groupingsummary'
                }
            ]
        }
    ],

    onCbTabLgotnikHouseSelect: function(combo, record, eOpts) {

        var stUser = Ext.data.StoreManager.get("StUser");
        var values =stUser.getAt(0);

        var login = Ext.data.StoreManager.get("StUser").getAt(0).get('login');
        var password = Ext.data.StoreManager.get("StUser").getAt(0).get('password');
        var selected = record;
        var StLgotnik= Ext.data.StoreManager.get("StLgotnikTab");

        if (selected) {
            values.set({'report':'tabLgotnikHouse','house_id':selected.get("house_id")});
            StLgotnik.proxy.setExtraParam('what', 'tabLgotnikHouse');
            StLgotnik.proxy.setExtraParam('house_id',selected.get("house_id"));
            StLgotnik.proxy.setExtraParam('login', login);
            StLgotnik.proxy.setExtraParam('password', password);
            StLgotnik.load();
        }
    }

});