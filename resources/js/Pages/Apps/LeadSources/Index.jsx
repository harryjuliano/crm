import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { leadSources } = usePage().props

  return (
    <>
      <Head title='Lead Source' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.lead-sources.create')} label='Tambah Lead Source' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.lead-sources.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Lead Source'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Kode</Table.Th><Table.Th>Nama</Table.Th><Table.Th>Deskripsi</Table.Th><Table.Th>Aktif (0/1)</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {leadSources.data.length ? leadSources.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (leadSources.current_page - 1) * leadSources.per_page}</Table.Td>
                <Table.Td>{item.code}</Table.Td><Table.Td>{item.name}</Table.Td><Table.Td>{item.description}</Table.Td><Table.Td>{item.is_active}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.lead-sources.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.lead-sources.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={6} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={leadSources.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
