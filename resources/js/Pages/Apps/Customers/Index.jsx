import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { customers } = usePage().props

  return (
    <>
      <Head title='Customer' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.customers.create')} label='Tambah Customer' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.customers.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Customer'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Kode</Table.Th><Table.Th>Nama</Table.Th><Table.Th>Tipe</Table.Th><Table.Th>Email</Table.Th><Table.Th>Phone</Table.Th><Table.Th>Status</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {customers.data.length ? customers.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (customers.current_page - 1) * customers.per_page}</Table.Td>
                <Table.Td>{item.customer_code}</Table.Td><Table.Td>{item.name}</Table.Td><Table.Td>{item.customer_type}</Table.Td><Table.Td>{item.email}</Table.Td><Table.Td>{item.phone}</Table.Td><Table.Td>{item.status}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.customers.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.customers.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={8} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={customers.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
