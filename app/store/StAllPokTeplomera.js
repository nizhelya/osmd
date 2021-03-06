/*
 * File: app/store/StAllPokTeplomera.js
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

Ext.define('Osmd.store.StAllPokTeplomera', {
    extend: 'Ext.data.Store',
    alias: 'store.stAllPokTeplomera',

    requires: [
        'Osmd.model.MdPriborUcheta',
        'Ext.data.proxy.Direct',
        'Osmd.DirectAPI',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'stAllPokTeplomera',
            model: 'Osmd.model.MdPriborUcheta',
            proxy: {
                type: 'direct',
                directFn: 'QueryTeplomer.getResults',
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});