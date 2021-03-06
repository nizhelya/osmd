/*
 * File: app/view/sprav/TabSubsidiaViewController.js
 * Date: Sun Dec 01 2019 00:42:08 GMT+0200 (EET)
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

Ext.define('Osmd.view.sprav.TabSubsidiaViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.tabsubsidia',

    onDataNachSubsidiaChange: function(field, newValue, oldValue, eOpts) {

        //STORE
        var stUser = Ext.data.StoreManager.get("StUser");
        var values =stUser.getAt(0);
        var login = values.get('login');
        var password = values.get('password');

        var stSubsidia = Ext.data.StoreManager.get("StSubsidia");
        var osmd_id =  Ext.getCmp('viborOsmdSubsidia').getValue();

        var btnGetSubsidiaOshadBank =  Ext.getCmp('btnGetSubsidiaOshadBank');
        var btnPrintSubsReestrToOshadBank =  Ext.getCmp('btnPrintSubsReestrToOshadBank');
        var btnPrintSubsReestrFromOshadBank =  Ext.getCmp('btnPrintSubsReestrFromOshadBank');
        var btnImportOshadBank =  Ext.getCmp('btnImportOshadBank');
        var btnExportOshadBank =  Ext.getCmp('btnExportOshadBank');
        var btnImportOplataOshad =  Ext.getCmp('btnImportOplataOshad');
        var btnImportOplataOsmd =  Ext.getCmp('btnImportOplataOsmd');
        var btnSubsidiaOtkatOsmd =  Ext.getCmp('btnSubsidiaOtkatOsmd');

        if (osmd_id){
            btnGetSubsidiaOshadBank.setDisabled(false);
            btnPrintSubsReestrToOshadBank.setDisabled(false);
            btnPrintSubsReestrFromOshadBank.setDisabled(false);
            btnImportOshadBank.setDisabled(false);
            btnExportOshadBank.setDisabled(false);
            btnImportOplataOshad.setDisabled(false);
            btnImportOplataOsmd.setDisabled(false);
            btnSubsidiaOtkatOsmd.setDisabled(false);

            stSubsidia.load({
                params: {
                    what:'getSubsidia',
                    login:login,
                    password:password,
                    data:newValue,
                    osmd_id: osmd_id
                },
                scope:this
            });
        } else {
            btnGetSubsidiaOshadBank.setDisabled(true);
            btnPrintSubsReestrToOshadBank.setDisabled(true);
            btnPrintSubsReestrFromOshadBank.setDisabled(true);
            btnImportOshadBank.setDisabled(true);
            btnExportOshadBank.setDisabled(true);
            btnImportOplataOshad.setDisabled(true);
            btnImportOplataOsmd.setDisabled(true);
            btnSubsidiaOtkatOsmd.setDisabled(true);

        }

    }

});
