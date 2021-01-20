/*
 * File: app/model/MdOrgDog.js
 * Date: Thu Dec 08 2016 23:44:05 GMT+0200 (EET)
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

Ext.define('Osmd.model.MdOrgDog', {
    extend: 'Ext.data.Model',
    alias: 'model.mdOrgDog',

    requires: [
        'Ext.data.field.String',
        'Ext.data.field.Boolean',
        'Ext.data.field.Date',
        'Ext.data.field.Number'
    ],

    fields: [
        {
            type: 'string',
            name: 'dog_id'
        },
        {
            type: 'string',
            name: 'org_id'
        },
        {
            type: 'string',
            name: 'number'
        },
        {
            type: 'boolean',
            name: 'active'
        },
        {
            type: 'date',
            name: 'data_start'
        },
        {
            type: 'date',
            name: 'data_end'
        },
        {
            type: 'float',
            name: 'tarif_gkal_nasel'
        },
        {
            type: 'float',
            name: 'tarif_gkal_inshi'
        }
    ]
});