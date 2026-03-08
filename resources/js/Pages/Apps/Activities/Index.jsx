import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { activities } = usePage().props

  return (
    <>
      <Head title='Activity' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.activities.create')} label='Tambah Activity' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.activities.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Activity'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Activity No</Table.Th><Table.Th>Relatable Type</Table.Th><Table.Th>Relatable ID</Table.Th><Table.Th>User ID</Table.Th><Table.Th>Activity Type</Table.Th><Table.Th>Subject</Table.Th><Table.Th>Activity At</Table.Th><Table.Th>Status</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {activities.data.length ? activities.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (activities.current_page - 1) * activities.per_page}</Table.Td>
                <Table.Td>{item.activity_no}</Table.Td><Table.Td>{item.relatable_type}</Table.Td><Table.Td>{item.relatable_id}</Table.Td><Table.Td>{item.user_id}</Table.Td><Table.Td>{item.activity_type}</Table.Td><Table.Td>{item.subject}</Table.Td><Table.Td>{item.activity_at}</Table.Td><Table.Td>{item.status}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.activities.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.activities.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={10} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={activities.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
