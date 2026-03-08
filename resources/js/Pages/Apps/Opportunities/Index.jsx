import React from 'react'
import { Head, usePage } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Table from '@/Components/Table'
import Search from '@/Components/Search'
import Button from '@/Components/Button'
import Pagination from '@/Components/Pagination'

export default function Index() {
  const { opportunities } = usePage().props

  return (
    <>
      <Head title='Opportunity' />
      <div className='mb-2 flex justify-between items-center gap-2'>
        <Button type='link' href={route('apps.opportunities.create')} label='Tambah Opportunity' variant='gray' />
        <div className='w-full md:w-4/12'><Search url={route('apps.opportunities.index')} placeholder='Cari data' /></div>
      </div>
      <Table.Card title='Data Opportunity'>
        <Table>
          <Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Opportunity No</Table.Th><Table.Th>Title</Table.Th><Table.Th>Lead ID</Table.Th><Table.Th>Customer ID</Table.Th><Table.Th>Assigned To</Table.Th><Table.Th>Type</Table.Th><Table.Th>Estimated Value</Table.Th><Table.Th>Probability</Table.Th><Table.Th>Stage</Table.Th><Table.Th>Status</Table.Th><Table.Th>Aksi</Table.Th></tr></Table.Thead>
          <Table.Tbody>
            {opportunities.data.length ? opportunities.data.map((item, i) => (
              <tr key={item.id}>
                <Table.Td>{++i + (opportunities.current_page - 1) * opportunities.per_page}</Table.Td>
                <Table.Td>{item.opportunity_no}</Table.Td><Table.Td>{item.title}</Table.Td><Table.Td>{item.lead_id}</Table.Td><Table.Td>{item.customer_id}</Table.Td><Table.Td>{item.assigned_to}</Table.Td><Table.Td>{item.opportunity_type}</Table.Td><Table.Td>{item.estimated_value}</Table.Td><Table.Td>{item.probability}</Table.Td><Table.Td>{item.stage}</Table.Td><Table.Td>{item.status}</Table.Td>
                <Table.Td className='flex gap-2'>
                  <Button type='edit' href={route('apps.opportunities.edit', item.id)} variant='orange' />
                  <Button type='delete' url={route('apps.opportunities.destroy', item.id)} variant='rose' />
                </Table.Td>
              </tr>
            )) : <Table.Empty colSpan={12} message='Belum ada data' />}
          </Table.Tbody>
        </Table>
      </Table.Card>
      <Pagination links={opportunities.links} />
    </>
  )
}

Index.layout = page => <AppLayout children={page} />
