/*
 * File: app/controller/CrInfo.js
 * Date: Wed Dec 04 2019 00:13:55 GMT+0200 (EET)
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

Ext.define('Osmd.controller.CrInfo', {
    extend: 'Ext.app.Controller',

    refs: {
        WinReport: {
            autoCreate: true,
            selector: 'winReport',
            xtype: 'winreport'
        },
        TabPnCenter: '#tabPnCenter'
    },

    control: {
        "#btnWinReportOrg": {
            click: 'onBtnWinReportOrgClick'
        },
        "#winReport": {
            show: 'onWinReportShow'
        },
        "#treeMenuSprav": {
            itemclick: 'onTreeMenuSpravItemClick'
        },
        "#printRaspechatakaYtke": {
            click: 'onPrintRaspechatakaYtkeClick'
        },
        "#printRaspechatakaPodogrev": {
            click: 'onPrintRaspechatakaPodogrevClick'
        },
        "#printRaspechatakaVoda": {
            click: 'onPrintRaspechatakaVodaClick'
        },
        "#printRaspechatakaStoki": {
            click: 'onPrintRaspechatakaStokiClick'
        },
        "#printRaspechatakaKvartplata": {
            click: 'onPrintRaspechatakaKvartplataClick'
        },
        "#printRaspechatakaTbo": {
            click: 'onPrintRaspechatakaTboClick'
        },
        "#btnPrintLgotnikAll": {
            click: 'onBtnPrintLgotnikAllClick'
        },
        "#btnPrintLgotnikEnd": {
            click: 'onBtnPrintLgotnikEndClick'
        },
        "#btnPrintLgotnikIzm": {
            click: 'onBtnPrintLgotnikIzmClick'
        },
        "#btnPrintLgotnikHouse": {
            click: 'onBtnPrintLgotnikHouseClick'
        },
        "#btnPrintLgotnikLgota": {
            click: 'onBtnPrintLgotnikLgotaClick'
        },
        "#btnPrintLgotnikGroup": {
            click: 'onBtnPrintLgotnikGroupClick'
        },
        "#btnFilialAccount": {
            click: 'onBtnFilialAccountClick'
        },
        "#btnAktSverkiFilialVik": {
            click: 'onBtnAktSverkiFilialVikClick'
        },
        "#printWarning": {
            click: 'onPrintWarningClick'
        }
    },

    onBtnWinReportOrgClick: function(button, e, eOpts) {
        var me = this;
        me.tabOtSvNach();

    },

    onWinReportShow: function(component, eOpts) {
        var me = this;
        var stUser = Ext.data.StoreManager.get("StUser");
        var stOrg = Ext.data.StoreManager.get("StOrg");
        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');
        var namereport = values.get('namereport');
        var report = values.get('report');
        var house_id = values.get('house_id');
        var osmd_id = values.get('osmd_id');

        //console.log(values);
        var form = Ext.getCmp('fmWinReport');
        var cbOsmd = form.getForm().findField('osmd_id');

        var header = Ext.getCmp('headerReport');
        var fsDolg = Ext.getCmp('fsDolg');
        var fsGetPeriod = Ext.getCmp('fsGetPeriod');
        var btnWinReportOrg = Ext.getCmp('btnWinReportOrg');
        var winReport = me.getWinReport();
        var chkRepHouse = Ext.getCmp('chkRepHouse');
        var chkGrLgota = Ext.getCmp('chkGrLgota');
        var cbRepGrLgota = Ext.getCmp('cbRepGrLgota');
        var dateRepFrom = Ext.getCmp('dateRepFrom');
        var dateRepTo = Ext.getCmp('dateRepTo');
        var dt = new Date();
        var dt_y =  Ext.Date.format(dt, 'Y');
        var dt_m = Ext.Date.format(dt, 'm');
        var dt_d = Ext.Date.format(dt, 'd');
        var from = new Date(dt_m+"/"+dt_d +"/"+dt_y);
        dateRepFrom.setValue(Ext.Date.getFirstDateOfMonth(from, 'Y-m-d'));
        dateRepTo.setValue(Ext.Date.getLastDateOfMonth(from, 'Y-m-d'));
        header.setText(namereport).show();

        switch (report) {
            case 'FlatRaspechatka':
            case 'InfoHouse':
            case 'ReestrOwner':
            case 'ItogMonthOsmdHouse':

                if (!cbOsmd.isHidden()){cbOsmd.hide();}
                if (chkRepHouse.isHidden()){chkRepHouse.show();}
                if (!chkGrLgota.isHidden()){chkGrLgota.hide();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                break;
            case 'ControlAllOsmd':
            case 'NachislenoAllOsmd':
            case 'ItogBudjetPoGroupOsmdSv':
            case 'PrintSubsUtsznAll':
            case 'PrintLgotaUtsznAll':
                if (!cbOsmd.isHidden()){cbOsmd.hide();}
                if (!chkRepHouse.isHidden()){chkRepHouse.hide();}
                if (!chkGrLgota.isHidden()){chkGrLgota.hide();}
                break;
            case 'ItogMonthOsmd':

            case 'ControlOsmd':
            case 'ItogBudjetPoGroupOsmd':
            case 'AppHistory':
            case 'KassaAddressOsmd':
            case 'KassaPrixodOsmd':
            case 'KassaDateOsmd':
            case 'DolgiOsmdSubs':


                if (cbOsmd.isHidden()){cbOsmd.show();}
                if (!chkRepHouse.isHidden()){chkRepHouse.hide();}
                if (!chkGrLgota.isHidden()){chkGrLgota.hide();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                break;

            case 'NachislenoAllHouseOsmd':
            case 'reportLgotnik':
                if (!cbOsmd.isHidden()){cbOsmd.hide();}
                if (chkRepHouse.isHidden()){chkRepHouse.show();}
                if (!chkGrLgota.isHidden()){chkGrLgota.hide();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                break;
            case 'ItogBudjetPoGroupRazvOsmd':
                if (cbOsmd.isHidden()){cbOsmd.show();}
                if (!chkRepHouse.isHidden()){chkRepHouse.hide();}
                if (cbRepGrLgota.isHidden()){cbRepGrLgota.show();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                break;
            case 'ItogBudjetPoGroupRazvOsmdSv':
            case 'ItogBudjetPoGroupOsmdAll':

                if (!cbOsmd.isHidden()){cbOsmd.hide();}
                if (cbRepGrLgota.isHidden()){cbRepGrLgota.show();}
                if (!chkRepHouse.isHidden()){chkRepHouse.hide();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                break;
            case 'DolgiOsmd':
            case 'SchetOsmd':
            case 'DolgWarningSummaOsmd':

                if (fsDolg.isHidden()){fsDolg.show();}
                if (!btnWinReportOrg.isHidden()){btnWinReportOrg.hide();}
                if (cbOsmd.isHidden()){cbOsmd.hide();}
                if (chkRepHouse.isHidden()){chkRepHouse.show();}
                if (!chkGrLgota.isHidden()){chkGrLgota.hide();}
                if (!cbRepGrLgota.isHidden()){cbRepGrLgota.hide();}
                break;
        }

    },

    onTreeMenuSpravItemClick: function(dataview, record, item, index, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');
        var parentId = record.data.parentId;
        var id = record.data.id;
        var text = record.data.text;
        var qtip = record.data.text;


        switch (id) {
            case 'tabSubsidia':
            case 'tabVozvratSubsidia':
            case 'tabPrivatBank':

            case 'tabSprUtszn':
            case 'tabSubsUtszn':
            case 'tabLgotaUtszn':
            case 'tabDbfLgota':
            case 'tabLgotnik':
            case 'tabKvartplata':
            case 'tabOrg':

                if(values.get('role') == 7){
                    values.set({
                        'parentid':parentId,
                        'sprav':id,
                        'namesprav':text,
                        'spravheader':qtip
                    });
                    me.openSprav(id, text);
                }else{
                    Ext.MessageBox.show({
                        title: 'Ошибка открытия отчета',
                        msg: 'Отчет может просмотреть только администратор',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
                break;
            case 'ControlAllOsmd':
            case 'NachislenoAllOsmd':
            case 'ReestrOwner':
            case 'ItogBudjetPoGroupOsmdSv':
            case 'ItogBudjetPoGroupRazvOsmdSv':
            case 'ItogBudjetPoGroupOsmdAll':
            case 'PrintSubsUtsznAll':
            case 'PrintLgotaUtsznAll':
            case 'ItogMonthOsmdHouse':

                if(values.get('role') == 7){
                    values.set({
                        'report':id,
                        'namereport':text,
                        'reportheader':text
                    });
                    winReport.show();
                }else{
                    Ext.MessageBox.show({
                        title: 'Ошибка открытия отчета',
                        msg: 'Отчет может просмотреть только администратор',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
                break;
            case 'tabHouseResidents':
            case 'tabLgota':
            case 'tabTarif':
            case 'tabOrg':
                values.set({
                    'parentid':parentId,
                    'sprav':id,
                    'namesprav':text,
                    'spravheader':qtip
                });
                me.openSprav(id, text);
                break;
            case 'AppHistory':
            case 'ItogMonthOsmd':
            case 'DolgiOsmd':
            case 'DolgiOsmdSubs':

            case 'DolgWarningSummaOsmd':
            case 'SchetOsmd':
            case 'KassaAddressOsmd':
            case 'KassaPrixodOsmd':
            case 'ControlOsmd':
            case 'NachislenoAllHouseOsmd':
            case 'KassaDateOsmd':
            case 'InfoHouse':
            case 'ItogBudjetPoGroupOsmd':
            case 'ItogBudjetPoGroupRazvOsmd':
                values.set({
                    'report':id,
                    'namereport':text,
                    'reportheader':text
                });
                winReport.show();
                break;
        }
    },

    onPrintRaspechatakaYtkeClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaYtke';
        var text = 'Распечатка тепло';
        var qtip = 'Распечатка тепло';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onPrintRaspechatakaPodogrevClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaYtke';
        var text = 'Распечатка тепло';
        var qtip = 'Распечатка тепло';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onPrintRaspechatakaVodaClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaVik';
        var text = 'Распечатка';
        var qtip = 'Распечатка';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onPrintRaspechatakaStokiClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaVik';
        var text = 'Распечатка';
        var qtip = 'Распечатка';

          values.set({
                'report':id,
                'namereport':text,
                'reportheader':text
            });

            winReport.show();

    },

    onPrintRaspechatakaKvartplataClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaMgkc';
        var text = 'Распечатка';
        var qtip = 'Распечатка';

          values.set({
                'report':id,
                'namereport':text,
                'reportheader':text
            });

            winReport.show();

    },

    onPrintRaspechatakaTboClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatRaspechatkaUgtrans';
        var text = 'Распечатка';
        var qtip = 'Распечатка';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onBtnPrintLgotnikAllClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var dataTabLgotnikEnd = Ext.getCmp('dataTabLgotnikEnd').getValue();
        // console.log(dataTabLgotnikEnd);


        if (dataTabLgotnikEnd) {
            var data_from = Ext.Date.getFirstDateOfMonth(dataTabLgotnikEnd);
            var data_to = Ext.Date.getLastDateOfMonth(dataTabLgotnikEnd);

            var usertype = 1;

            var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnik';
            var namereport = 'Список льготников';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                date_from:data_from,
                date_to:data_to
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnPrintLgotnikEndClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var dataTabLgotnikEnd = Ext.getCmp('dataTabLgotnikEnd').getValue();
           // console.log(dataTabLgotnikEnd);


        if (dataTabLgotnikEnd) {
           var data_from = Ext.Date.getFirstDateOfMonth(dataTabLgotnikEnd);
           var data_to = Ext.Date.getLastDateOfMonth(dataTabLgotnikEnd);

        var usertype = 1;

        var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnikEnd';
            var namereport = 'Контроль льготников';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                date_from:data_from,
                date_to:data_to
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnPrintLgotnikIzmClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var dataTabLgotnikIzm = Ext.getCmp('dataTabLgotnik').getValue();
           // console.log(dataTabLgotnikEnd);


        if (dataTabLgotnikIzm) {
           var data_from = Ext.Date.getFirstDateOfMonth(dataTabLgotnikIzm);
           var data_to = Ext.Date.getLastDateOfMonth(dataTabLgotnikIzm);

        var usertype = 1;

        var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnikIzm';
            var namereport = 'Изменения льготников';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                date_from:data_from,
                date_to:data_to
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnPrintLgotnikHouseClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var house_id = Ext.getCmp('cbTabLgotnikHouse').getValue();
           // console.log(dataTabLgotnikEnd);


        if (house_id) {

        var usertype = 1;

        var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnikHouse';
            var namereport = 'Льготников по дому';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                house_id:house_id
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnPrintLgotnikLgotaClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var lgota_id = Ext.getCmp('cbTabLgotnikLgota').getValue();
           // console.log(dataTabLgotnikEnd);


        if (lgota_id) {

        var usertype = 1;

        var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnikLgota';
            var namereport = 'Льготников по льготе';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                lgota_id:lgota_id
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnPrintLgotnikGroupClick: function(button, e, eOpts) {
        //in use
        var me = this;
        var StUser = Ext.data.StoreManager.get("StUser");
        var values =StUser.getAt(0);

        var gr = Ext.getCmp('cbTabLgotnikGroup').getValue();
          // console.log(gr);


        if (gr) {

        var usertype = 1;

        var tabPnCenter =  Ext.getCmp('tabPnCenter');//me.getTabPnCenter();

            var report = 'reportLgotnikGroup';
            var namereport = 'Льготников по группе';
            var value = {
                login:values.get('login'),
                password:values.get('password'),
                report:report,
                what:report,
                gr:gr
            };
            var tab = tabPnCenter.child('#'+report);
            if (!tab) {
                tab  = tabPnCenter.add({
                    xtype:'tabreportorg',
                    title:namereport,
                    id:''+report+''
                });

            }
            //console.log(value);

            tabPnCenter.setActiveTab(tab);
            var reppan = tab.getComponent(0);
            // Basic mask:
            var myMask= Ext.Msg.show({
                title:'Загрузка...',
                msg: 'Загрузка отчета .Ожидайте...',
                buttons: Ext.Msg.CANCEL,
                wait: true,
                modal: true,
                icon: Ext.Msg.INFO
            });
            QueryReport.getResults(value,function(data){
                if (data){
                    reppan.update(data.content);
                    Ext.REPORTCONTENT =data.content;
                    Ext.REPORTSQL =data.sql;
                    Ext.REPORTTITLE =report;
                    myMask.close();

                } else {
                    myMask.close();
                    Ext.MessageBox.show({
                        title: 'Ошибка ',
                        msg: 'Документ не создан',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.ERROR
                    });
                }
            });

        }
    },

    onBtnFilialAccountClick: function() {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FilialAccount';
        var text = 'Счет';
        var qtip = 'Счет';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onBtnAktSverkiFilialVikClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'AktSverkiFilialVik';
        var text = 'Распечатка';
        var qtip = 'Распечатка';

        values.set({
            'report':id,
            'namereport':text,
            'reportheader':text
        });

        winReport.show();

    },

    onPrintWarningClick: function(button, e, eOpts) {
        //in use
        var me = this;

        // STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //Component

        var winReport = me.getWinReport();

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        //LOGIKA
        var id = 'FlatWarning';
        var text = 'Предупреждение';
        var qtip = 'Предупреждение';

          values.set({
                'report':id,
                'namereport':text,
                'reportheader':text
            });

            winReport.show();

    },

    tabOtSvNach: function() {

        //in use
        var me = this;
        // STORE
        var StUser = Ext.data.StoreManager.get("StUser");
        var StReport = Ext.data.StoreManager.get("StReport");
        //TAB
        var winReport = me.getWinReport();
        var tabPnCenter = me.getTabPnCenter();
        // FORM
        var fmWinReport = Ext.getCmp("fmWinReport");  //Форма
        var house_id = fmWinReport.getForm().findField('house_id').getValue();

        var value = fmWinReport.getValues();

        //LOGIN & PASSWORD & ID
        var values =StUser.getAt(0);
        var params = {
            login:values.get('login'),
            password:values.get('password'),
            report:values.get('report'),
            what:values.get('report'),
            filial_id:values.get('filial_id'),
            address_id:values.get('address_id'),
            house_id:house_id
        };

        var report = values.get('report');
        var namereport = values.get('reportheader');

        //console.log(namereport);


        //LOGIKA

        Ext.Object.merge(value, params);


        var tab = tabPnCenter.child('#'+report);

        if (!tab) {
            tab  = tabPnCenter.add({
                xtype:'tabreportorg',
                title:namereport,
                id:''+report+''
            });

            tabPnCenter.setActiveTab(tab);

        }else{

            tabPnCenter.setActiveTab(tab);
        }

        var reppan = tab.getComponent(0);



        // Basic mask:
        //var myMask = new Ext.LoadMask(winReport, {msg:"Загрузка отчета..."});
        //myMask.show();

        var myMask= Ext.Msg.show({
            title:'Отчеты...',
            msg: 'Загрузка отчета.Ожидайте...',
            buttons: Ext.Msg.CANCEL,
            wait: true,
            modal: true,
            icon: Ext.Msg.INFO
        });

        QueryReport.getResults(value,function(results){
            if (results.success==="1"){
                reppan.update(results.content);
                Ext.REPORTCONTENT =results.content;
                Ext.REPORTSQL =results.sql;
                Ext.REPORTTITLE =report;
                myMask.close();
                winReport.close();

            }else{
                Ext.MessageBox.show({title: namereport,
                                     msg: results.msg,
                                     buttons: Ext.MessageBox.OK,
                                     icon: Ext.MessageBox.ERROR
                                    });
                myMask.close();
                winReport.close();


            }
        });
    },

    openSprav: function(tid, tname) {
        //in use

        var me = this;
        var xt = Ext.util.Format.lowercase(tid);
        var tabPnCenter = me.getTabPnCenter();
        var tab = tabPnCenter.child('#'+tid);
        if (!tab) {
            tab  = tabPnCenter.add({
                xtype:xt,
                id:tid
            });

            tabPnCenter.setActiveTab(tab);
        }else{
            tabPnCenter.setActiveTab(tab);
        }
    }

});
