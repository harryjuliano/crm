import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { leads } = usePage().props

  return (
    <>
      <Head title='Lead' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.leads.create')} label='Tambah Lead' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.leads.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Lead'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Lead No</Table.Th><Table.Th>Nama</Table.Th><Table.Th>Tipe</Table.Th><Table.Th>Email</Table.Th><Table.Th>Phone</Table.Th><Table.Th>Lead Source ID</Table.Th><Table.Th>Assigned To</Table.Th><Table.Th>Status</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {leads.data.length ? leads.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (leads.current_page - 1) * leads.per_page}</Table.Td>
                <Table.Td>{item.lead_no}</Table.Td><Table.Td>{item.name}</Table.Td><Table.Td>{item.lead_type}</Table.Td><Table.Td>{item.email}</Table.Td><Table.Td>{item.phone}</Table.Td><Table.Td>{item.lead_source_id}</Table.Td><Table.Td>{item.assigned_to}</Table.Td><Table.Td>{item.status}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.leads.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.leads.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={10} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={leads.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
