/*
 * File: app/view/menu/TabPnCenter.js
 * Date: Tue Oct 06 2020 01:55:01 GMT+0300 (EEST)
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

Ext.define('Osmd.view.menu.TabPnCenter', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.tabpncenter',

    requires: [
        'Osmd.view.menu.TabPnCenterViewModel',
        'Osmd.view.flat.TabKassa',
        'Osmd.view.flat.TabAppBti',
        'Osmd.view.flat.TabNachApp',
        'Osmd.view.flat.TabAppVodomer',
        'Osmd.view.flat.TabAppTeplomer',
        'Osmd.view.flat.TabOplata',
        'Osmd.view.sprav.TabLogin',
        'Ext.panel.Panel',
        'Ext.tab.Tab'
    ],

    viewModel: {
        type: 'tabpncenter'
    },
    border: false,
    id: 'tabPnCenter',
    activeTab: 6,

    items: [
        {
            xtype: 'tabkassa'
        },
        {
            xtype: 'tabappbti'
        },
        {
            xtype: 'tabnachapp'
        },
        {
            xtype: 'tabAppVodomer'
        },
        {
            xtype: 'tabAppTeplomer'
        },
        {
            xtype: 'taboplata',
            title: 'Платежи'
        },
        {
            xtype: 'tabLogin',
            title: 'My Tab'
        }
    ]

});