/*
 * File: app/controller/Vodomer.js
 * Date: Sat Dec 10 2016 15:00:53 GMT+0200 (EET)
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

Ext.define('Osmd.controller.Vodomer', {
    extend: 'Ext.app.Controller',

    refs: {
        FmVodomer: '#fmVodomer',
        PnAppVodomer: '#pnAppVodomer',
        GrAllPokVodomera: '#grAllPokVodomera',
        VpIsCity: 'vpIsCity'
    },

    control: {
        "#grVodomer": {
            selectionchange: 'onGrVodomerSelectionChange'
        },
        "#insTekPokVod": {
            click: 'onInsTekPokVodClick'
        },
        "#grAppHVodomer": {
            selectionchange: 'onGrAppHVodomerSelectionChange'
        },
        "#grAllPokVodomera": {
            selectionchange: 'onGrAllPokVodomeraSelectionChange'
        },
        "#grAppVodomer": {
            selectionchange: 'onGrAppVodomerSelectionChange'
        },
        "#grAppTeplomer": {
            selectionchange: 'onGrAppTeplomerSelectionChange'
        },
        "#grAllPokAppTeplomera": {
            selectionchange: 'onGrAllPokAppTeplomeraSelectionChange'
        },
        "#tabAppVodomer": {
            activate: 'onTabAppVodomerActivate'
        },
        "#tabAppTeplomer": {
            activate: 'onTabAppTeplomerActivate'
        },
        "#grAppHTeplomer": {
            selectionchange: 'onGrAppHTeplomerSelectionChange'
        }
    },

    onGrVodomerSelectionChange: function(model, selected, eOpts) {
        //in use
        var me =this;
        var store = Ext.data.StoreManager.get("StWater");
        var storeTekPokVodomera = Ext.data.StoreManager.get("StTekPokVodomera");
        var formVodomer = me.getFmVodomer();
        if (selected.length){
            var address_id = selected[0].data.address_id;
            store.load({
                params: {
                    what:'AllPokVodomera',
                    what_id: selected[0].data.address_id,
                    nomer: selected[0].data.nomer
                },
                scope:this
            });
            store.sync();
            storeTekPokVodomera.load({
                params: {
                    what:'TekPokVodomera',
                    what_id: selected[0].data.address_id,
                    nomer: selected[0].data.nomer
                },
                callback: function(records,operation,success){
                    if(success){
                        storeTekPokVodomera.sync();
                        formVodomer.getForm().loadRecord(records[0]);

                    }
                },
                scope:this
            });

        }

    },

    onInsTekPokVodClick: function(button, e, eOpts) {
        // in use
        var me = this;
        //STORE
        console.log(2);

        var stUser = Ext.data.StoreManager.get("StUser");
        var stWater = Ext.data.StoreManager.get("StWater");//QueryVodomer.getResults  <AppVodomer>
        var stTekPokVodomera = Ext.data.StoreManager.get("StTekPokVodomera");//QueryVodomer.getResults <TekPokVodomera>
        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var params = {
            user_id:values.get('user_id'),
            login:values.get('login'),
            password:values.get('password'),
            address_id:values.get('address_id'),
            house_id:values.get('house_id'),
            what:'AVodomer'

        };
        //GRID

        //var grTekNachAppVodomer = Ext.getCmp('grTekNachAppVodomer');

        //FORMA

        var fmVodomer = Ext.getCmp('fmVodomer');
        var value = fmVodomer.getValues();

        //LOGIKA

        Ext.Object.merge(value, params);
        var newValue = value.newValue;
        var max =newValue - value.tek;
        if (isNaN(newValue)){
            Ext.MessageBox.show({
                title: 'Проверка вводимых данных',
                msg: 'Введите число',
                buttons: Ext.MessageBox.OK,
                icon: Ext.MessageBox.ERROR
            });
            return false;
        }else if (max < 0){
            Ext.MessageBox.show({
                title: 'Проверка вводимых данных',
                msg: 'Текущие показания <b>'+value.tek+'</b><br>Новые показания <b>'+newValue+'</b><br>Введите правильные показания !.',
                buttons: Ext.MessageBox.CANCEL,
                icon: Ext.MessageBox.ERROR,
                buttonText:{
                    cancel:'отмена'
                },
                fn:function(btn,newValue){
                    if(btn=='cancel'){
                        fmVodomer.getForm().findField('newValue').focus();
                        return false;
                    }
                }
            });
        } else if(max === 0) {
            Ext.MessageBox.confirm({
                title: 'Проверка вводимых данных',
                msg: 'Вводимые показания теже что и предыдущие<br>Подтвердите или отмените вводимые показания.',
                buttons: Ext.MessageBox.OKCANCEL,
                icon: Ext.MessageBox.ERROR,
                buttonText:{
                    ok:'подтвеждаю',
                    cancel:'отмена'
                },
                fn:function(btn,newValue){
                    if(btn=='cancel'){
                        fmVodomer.getForm().findField('newValue').focus();
                        return false;
                    }else{
                        QueryVodomer.newPokVodomera(value,function(results){
                            if (results.success){

                                fmVodomer.getForm().findField('newValue').setValue(0);
                                stWater.load({
                                    params: {
                                        what:'AllPokVodomera',
                                        what_id: value.address_id,
                                        address_id: value.address_id,
                                        vodomer_id: value.vodomer_id,
                                        login:value.login,
                                        password:value.password
                                    },
                                    scope:this
                                });
                                stTekPokVodomera.load({
                                    params: {
                                        what:'TekPokVodomera',
                                        what_id: value.address_id,
                                        address_id: value.address_id,
                                        vodomer_id: value.vodomer_id,
                                        login:value.login,
                                        password:value.password
                                    },
                                    callback: function(records,operation,success){
                                        if(success){
                                            fmVodomer.getForm().loadRecord(records[0]);
                                        }
                                    },
                                    scope:this
                                });
                            }
                        });
                    }
                }
            });
        } else if(max > 20) {
            Ext.MessageBox.confirm({
                title: 'Проверка вводимых данных',
                msg: 'Вводимые показания <b>'+newValue+'</b> очень большие <b>'+ max +'</b> куб(a)<br>Подтвердите или отмените вводимые показания.',
                buttons: Ext.MessageBox.OKCANCEL,
                icon: Ext.MessageBox.ERROR,
                buttonText:{
                    ok:'подтвеждаю',
                    cancel:'отмена'
                },
                fn:function(btn,newValue){
                    if(btn=='cancel'){
                        fmVodomer.getForm().findField('newValue').focus();
                        return false;
                    }else{
                        QueryVodomer.newPokVodomera(value,function(results){
                            if (results.success){

                                fmVodomer.getForm().findField('newValue').setValue(0);
                                stWater.load({
                                    params: {
                                        what:'AllPokVodomera',
                                        what_id: value.address_id,
                                        address_id: value.address_id,
                                        vodomer_id: value.vodomer_id,
                                        login:value.login,
                                        password:value.password
                                    },
                                    scope:this
                                });
                                stTekPokVodomera.load({
                                    params: {
                                        what:'TekPokVodomera',
                                        what_id: value.address_id,
                                        address_id: value.address_id,
                                        vodomer_id: value.vodomer_id,
                                        login:value.login,
                                        password:value.password
                                    },
                                    callback: function(records,operation,success){
                                        if(success){
                                            fmVodomer.getForm().loadRecord(records[0]);
                                        }
                                    },
                                    scope:this
                                });
                            }
                        });
                    }
                }
            });


        } else {
            QueryVodomer.newPokVodomera(value,function(results){
                if (results.success){

                    fmVodomer.getForm().findField('newValue').setValue(0);
                    stWater.load({
                        params: {
                            what:'AllPokVodomera',
                            what_id: value.address_id,
                            address_id: value.address_id,
                            vodomer_id: value.vodomer_id,
                            login:value.login,
                            password:value.password
                        },
                        scope:this
                    });

                    stTekPokVodomera.load({
                        params: {
                            what:'TekPokVodomera',
                            what_id: value.address_id,
                            address_id: value.address_id,
                            vodomer_id: value.vodomer_id,
                            login:value.login,
                            password:value.password
                        },
                        callback: function(records,operation,success){
                            if(success){
                                fmVodomer.getForm().loadRecord(records[0]);
                            }
                        },
                        scope:this
                    });

                }
            });
        }

    },

    onGrAppHVodomerSelectionChange: function(model, selected, eOpts) {
           //in use
                var me =this;

                //STORE

                var stUser = Ext.data.StoreManager.get("StUser");
                var stWater = Ext.data.StoreManager.get("StWater");//QueryVodomer.getResults  <AllPokVodomera>
                var stTekPokVodomera = Ext.data.StoreManager.get("StTekPokVodomera");//QueryVodomer.getResults <TekPokVodomera>

                //LOGIN & PASSWORD

                var values =stUser.getAt(0);
                var login = values.get('login');
                var password = values.get('password');
                var address_id = values.get('address_id');
                var house_id = values.get('house_id');

                //GRID

                var grAppVodomer = Ext.getCmp('grAppVodomer');

                //FORMA

                var fmVodomer = Ext.getCmp('fmVodomer');

                //LOGIKA

                grAppVodomer.getView().getSelectionModel().deselectAll();

                if (selected.length){
                    stTekPokVodomera.removeAll();

                    stWater.load({
                        params: {
                            login:login,
                            password:password,
                            address_id: address_id,
                            what:'AllPokVodomera',
                            what_id: selected[0].data.address_id,
                            vodomer_id: selected[0].data.vodomer_id
                        },
                        scope:this
                    });
                    fmVodomer.getForm().reset();

                }

    },

    onGrAllPokVodomeraSelectionChange: function(model, selected, eOpts) {

        //LOGIN & PASSWORD
        var form = Ext.getCmp('fmVodomer');
        if (selected.length > 0) {
            form.getForm().reset();
            form.getForm().loadRecord(selected[0]);
        }
    },

    onGrAppVodomerSelectionChange: function(model, selected, eOpts) {
        //in use
        //console.log(selected[0].data);
        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");
        var stWater = Ext.data.StoreManager.get("StWater");
        var stTekPokVodomera = Ext.data.StoreManager.get("StTekPokVodomera");

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var address_id = values.get('address_id');

        //GRID

        var grAppHVodomer = Ext.getCmp('grAppHVodomer');

        //FORMA

        var fmVodomer = Ext.getCmp('fmVodomer');


        //var tekValue = fmVodomer.getForm().findField('tekp');
        //var newValue = fmVodomer.getForm().findField('newValue');


        //LOGIKA

        grAppHVodomer.getView().getSelectionModel().deselectAll();

        if (selected.length){
            stWater.load({
                params: {
                    address_id: address_id,
                    what:'AllPokVodomera',
                    what_id: selected[0].data.address_id,
                    vodomer_id: selected[0].data.vodomer_id
                },
                scope:this
            });
            stTekPokVodomera.load({
                params: {
                    address_id: address_id,
                    what:'TekPokVodomera',
                    what_id: selected[0].data.address_id,
                    vodomer_id: selected[0].data.vodomer_id
                },
                callback: function(records,operation,success){
                    if(success){
                        fmVodomer.getForm().loadRecord(records[0]);

                    }
                },
                scope:this
            });

           // if (tekValue.isHidden()) {tekValue.show();}
        }

    },

    onGrAppTeplomerSelectionChange: function(model, selected, eOpts) {
        //in use

        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");
        var stTekPokTeplomera = Ext.data.StoreManager.get("StTekPokTeplomera");//QueryTeplomer.getResults <TekPokTeplomera>
        var stAllPokTeplomera = Ext.data.StoreManager.get("StAllPokTeplomera");//QueryTeplomer.getResults <TekPokTeplomera>

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var address_id = values.get('address_id');

        //FORMA

        var fmTeplomer = Ext.getCmp('fmAppTeplomer');

        //LOGIKA

        if (selected.length){

         //   fmTeplomer.getForm().findField('fmAppTeplomer_id').setValue(selected[0].data.teplomer_id);
         //   fmTeplomer.getForm().findField('AppT_pok_id').setValue(selected[0].data.pok_id);
            stTekPokTeplomera.load({
                params: {
                    login:login,
                    address_id: address_id,
                    what:'TekPokTeplomera',
                    what_id: selected[0].data.teplomer_id,
                    teplomer_id: selected[0].data.teplomer_id,
                    nomer: selected[0].data.nomer
                },
                callback: function(records,operation,success){
                    if(success && records.length){
                        fmTeplomer.getForm().loadRecord(records[0]);

                    }
                },
                scope:this
            });

            stAllPokTeplomera.load({
                params: {
                    login:login,
                    address_id: address_id,
                    what:'AllPokTeplomera',
                    what_id: selected[0].data.teplomer_id,
                    teplomer_id: selected[0].data.teplomer_id,
                    nomer: selected[0].data.nomer
                },
                scope:this
            });



        }

    },

    onGrAllPokAppTeplomeraSelectionChange: function(model, selected, eOpts) {

        //LOGIN & PASSWORD
        var form = Ext.getCmp('fmAppTeplomer');
        if (selected.length > 0) {
            form.getForm().reset();
            form.getForm().loadRecord(selected[0]);
        }
    },

    onTabAppVodomerActivate: function(component, eOpts) {
        //in use
        //var showAddressAppVodomer = Ext.getCmp('showAddressAppVodomer');
        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');
        var address_id = values.get('address_id');
        var address = values.get('address');
        var house_id = values.get('house_id');

        var fmVodomer = Ext.getCmp('fmVodomer');
        var grAllPokVodomera = Ext.getCmp('grAllPokVodomera');


        //STORE
        var stVodomer = Ext.data.StoreManager.get("StVodomer");//QueryVodomer.getResults  <AppVodomer>
        var stHVodomer = Ext.data.StoreManager.get("StHVodomer");//QueryVodomer.getResults <AppHVodomer>

        grAllPokVodomera.getView().refresh();

        //showAddressAppVodomer.setText(address).show();
        fmVodomer.getForm().reset();
        stVodomer.load({
            params: {
                what:'AppVodomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });

        stHVodomer.load({
            params: {
                what:'AppHVodomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });

    },

    onTabAppTeplomerActivate: function(component, eOpts) {
        //in use
        //var me = this;

        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');
        var address_id = values.get('address_id');
        var address = values.get('address');
        var house_id = values.get('house_id');
        var prixod_id = values.get('prixod_id');

        //LOGIKA

        //var showAddressAppTeplomer = Ext.getCmp('showAddressAppTeplomer');
        //FORM
        var fmAppTeplomer = Ext.getCmp('fmAppTeplomer');

        //STORE
        var stTeplomer = Ext.data.StoreManager.get("StTeplomer");//QueryTeplomer.getResults  <AppTeplomer>
        var stHTeplomer = Ext.data.StoreManager.get("StHTeplomer");//QueryTeplomer.getResults <AppHTeplomer>

        //showAddressAppTeplomer.setText(address).show();



        //tabAppTeplomer

        fmAppTeplomer.getForm().reset();


        stTeplomer.load({
            params: {
                what:'AppTeplomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });


        stHTeplomer.load({
            params: {
                what:'AppHTeplomer',
                what_id: address_id,
                address_id: address_id,
                login:login,
                password:password
            },
            scope:this
        });

    },

    onGrAppHTeplomerSelectionChange: function(model, selected, eOpts) {
        //in use

        //STORE

        var stUser = Ext.data.StoreManager.get("StUser");
        var stTekPokTeplomera = Ext.data.StoreManager.get("StTekPokTeplomera");//QueryTeplomer.getResults <TekPokTeplomera>
        var stAllPokTeplomera = Ext.data.StoreManager.get("StAllPokTeplomera");//QueryTeplomer.getResults <TekPokTeplomera>

        //LOGIN & PASSWORD

        var values =stUser.getAt(0);
        var login = values.get('login');
        var address_id = values.get('address_id');

        //FORMA

        var fmTeplomer = Ext.getCmp('fmAppTeplomer');

        //LOGIKA

        if (selected.length){

         //   fmTeplomer.getForm().findField('fmAppTeplomer_id').setValue(selected[0].data.teplomer_id);
         //   fmTeplomer.getForm().findField('AppT_pok_id').setValue(selected[0].data.pok_id);
            stTekPokTeplomera.load({
                params: {
                    login:login,
                    address_id: address_id,
                    what:'TekPokTeplomera',
                    what_id: selected[0].data.teplomer_id,
                    teplomer_id: selected[0].data.teplomer_id,
                    nomer: selected[0].data.nomer
                },
                callback: function(records,operation,success){
                    if(success && records.length){
                        fmTeplomer.getForm().loadRecord(records[0]);

                    }
                },
                scope:this
            });

            stAllPokTeplomera.load({
                params: {
                    login:login,
                    address_id: address_id,
                    what:'AllPokTeplomera',
                    what_id: selected[0].data.teplomer_id,
                    teplomer_id: selected[0].data.teplomer_id,
                    nomer: selected[0].data.nomer
                },
                scope:this
            });



        }

    }

});
