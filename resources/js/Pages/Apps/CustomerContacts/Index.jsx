import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { customerContacts } = usePage().props

  return (
    <>
      <Head title='Customer Contact' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.customer-contacts.create')} label='Tambah Customer Contact' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.customer-contacts.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Customer Contact'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Customer ID</Table.Th><Table.Th>Nama</Table.Th><Table.Th>Jabatan</Table.Th><Table.Th>Email</Table.Th><Table.Th>Phone</Table.Th><Table.Th>Primary (0/1)</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {customerContacts.data.length ? customerContacts.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (customerContacts.current_page - 1) * customerContacts.per_page}</Table.Td>
                <Table.Td>{item.customer_id}</Table.Td><Table.Td>{item.name}</Table.Td><Table.Td>{item.position}</Table.Td><Table.Td>{item.email}</Table.Td><Table.Td>{item.phone}</Table.Td><Table.Td>{item.is_primary}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.customer-contacts.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.customer-contacts.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={8} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={customerContacts.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
