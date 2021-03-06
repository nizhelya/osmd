/*
 * File: app/store/StOsmd.js
 * Date: Wed Mar 22 2017 00:13:15 GMT+0200 (EET)
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

Ext.define('Osmd.store.StOsmd', {
    extend: 'Ext.data.Store',

    requires: [
        'Osmd.model.MdHouses',
        'Ext.data.proxy.Direct',
        'Osmd.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'StOsmd',
            autoLoad: true,
            model: 'Osmd.model.MdHouses',
            proxy: {
                type: 'direct',
                extraParams: {
                    what: 'getOsmd'
                },
                directFn: 'QueryLoad.getResults',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});