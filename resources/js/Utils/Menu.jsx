import { usePage } from '@inertiajs/react';
import { IconAddressBook, IconCirclePlus, IconLayout2, IconListDetails, IconTable, IconUserBolt, IconUserShield, IconUsers } from '@tabler/icons-react';
import hasAnyPermission from './Permissions';
import React from 'react'

export default function Menu() {

    // define use page
    const { url } = usePage();

    // define menu navigations
    const menuNavigation = [
        {
            title: 'Overview',
            permissions: hasAnyPermission(['dashboard-access']),
            details: [
                {
                    title : 'Dashboard',
                    href : '/apps/dashboard',
                    active: url.startsWith('/apps/dashboard') ? true : false,
                    icon : <IconLayout2 size={20} strokeWidth={1.5}/>,
                    permissions:  hasAnyPermission(['dashboard-access']),
                },
            ]
        },
        {
            title: 'User Management',
            permissions: hasAnyPermission(['permissions-access']) || hasAnyPermission(['roles-access']) || hasAnyPermission(['users-access']),
            details : [
                {
                    title : 'Hak Akses',
                    href : '/apps/permissions',
                    active: url.startsWith('/apps/permissions') ? true : false,
                    icon : <IconUserBolt size={20} strokeWidth={1.5}/>,
                    permissions: hasAnyPermission(['permissions-access']),
                },
                {
                    title : 'Akses Group',
                    href : '/apps/roles',
                    active: url.startsWith('/apps/roles') ? true : false,
                    icon : <IconUserShield size={20} strokeWidth={1.5}/>,
                    permissions:  hasAnyPermission(['roles-access']),
                },
                {
                    title : 'Pengguna',
                    icon : <IconUsers size={20} strokeWidth={1.5}/>,
                    permissions: hasAnyPermission(['users-access']),
                    subdetails: [
                        {
                            title: 'Data Pengguna',
                            href: '/apps/users',
                            icon: <IconTable size={20} strokeWidth={1.5}/>,
                            active: url === '/apps/users' ? true : false,
                            permissions: hasAnyPermission(['users-data']),
                        },
                        {
                            title: 'Tambah Data Pengguna',
                            href: '/apps/users/create',
                            icon: <IconCirclePlus size={20} strokeWidth={1.5}/>,
                            active: url === '/apps/users/create' ? true : false,
                            permissions: hasAnyPermission(['users-create']),
                        },
                    ]
                }
            ]
        },
        {
            title: 'CRM MVP 1',
            permissions: true,
            details: [
                {
                    title: 'Customers',
                    href: '/apps/customers',
                    active: url.startsWith('/apps/customers'),
                    icon: <IconUsers size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Customer Contacts',
                    href: '/apps/customer-contacts',
                    active: url.startsWith('/apps/customer-contacts'),
                    icon: <IconAddressBook size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Lead Sources',
                    href: '/apps/lead-sources',
                    active: url.startsWith('/apps/lead-sources'),
                    icon: <IconListDetails size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Leads',
                    href: '/apps/leads',
                    active: url.startsWith('/apps/leads'),
                    icon: <IconTable size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Activities',
                    href: '/apps/activities',
                    active: url.startsWith('/apps/activities'),
                    icon: <IconTable size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Opportunities',
                    href: '/apps/opportunities',
                    active: url.startsWith('/apps/opportunities'),
                    icon: <IconTable size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
                {
                    title: 'Opportunity Items',
                    href: '/apps/opportunity-items',
                    active: url.startsWith('/apps/opportunity-items'),
                    icon: <IconTable size={20} strokeWidth={1.5}/>,
                    permissions: true,
                },
            ],
        }
    ]

    return menuNavigation;
}
