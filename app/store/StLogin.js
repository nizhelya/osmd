/*
 * File: app/store/StLogin.js
 * Date: Thu Dec 08 2016 23:44:04 GMT+0200 (EET)
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

Ext.define('Osmd.store.StLogin', {
    extend: 'Ext.data.Store',
    alias: 'store.stLogin',

    requires: [
        'Osmd.model.MdLogin',
        'Ext.data.proxy.Direct',
        'Osmd.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'stLogin',
            model: 'Osmd.model.MdLogin',
            proxy: {
                type: 'direct',
                api: {
                    read: 'QueryUserLogin.getResults',
                    update: 'QueryUserLogin.updateUser'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});